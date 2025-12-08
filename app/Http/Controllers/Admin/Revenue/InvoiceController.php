<?php

namespace App\Http\Controllers\Admin\Revenue;

use App\Http\Controllers\Controller;
use App\Http\Requests\Invoice\StoreInvoiceRequest;
use App\Http\Requests\Invoice\UpdateInvoiceRequest;
use App\Models\Invoice;
use App\Models\InvoiceParticular;
use App\Models\Settings\FiscalYear;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Throwable;

final class InvoiceController extends Controller
{
    private const int RESERVATION_TTL = 600; // 10 minutes

    public function index(): View|Factory
    {
        $this->checkAuthorization('invoice_access');

        $invoices = Invoice::query()
            ->withSum(['invoiceParticulars' => function ($query) {
                $query->select(DB::raw('SUM((rate * quantity) + (rate * quantity) * due ) as total'));
            }], 'total')
            ->where('fiscal_year_id', officeSetting()->fiscal_year_id)
            ->latest('invoice_no')
            ->paginate(25);

        return view('admin.invoice.index', compact('invoices'));
    }

    public function create(): View|Factory
    {
        $this->checkAuthorization('invoice_create');

        $fiscalYear = officeSetting()->fiscalYear;

        // This returns the SAME number on every reload until saved or expired
        $serialNumber  = $this->getOrReserveInvoiceNumber($fiscalYear);
        $invoiceNumber = $this->formatInvoiceNumber($fiscalYear, $serialNumber);

        $fiscalYears = FiscalYear::latest()->get();

        return view('admin.invoice.create', compact('fiscalYears', 'invoiceNumber'));
    }

    /**
     * @throws Throwable
     */
    public function store(StoreInvoiceRequest $request): RedirectResponse
    {
        $this->checkAuthorization('invoice_create');

        $invoice = DB::transaction(function () use ($request) {
            $fiscalYear = FiscalYear::findOrFail(
                $request->fiscal_year_id ?? officeSetting()->fiscal_year_id
            );

            $reservedNumber = $this->getReservedNumberForUser($fiscalYear);

            if (!$reservedNumber) {
                abort(400, 'Your invoice number has expired. Please reload the form.');
            }

            $invoiceNumber = $this->formatInvoiceNumber($fiscalYear, $reservedNumber);

            // Final safety check: prevent duplicate even if collision
            $exists = Invoice::withTrashed()
                ->where('fiscal_year_id', $fiscalYear->id)
                ->where('invoice_no', $invoiceNumber)
                ->exists();

            if ($exists) {
                // Extremely rare case — generate fresh number
                $reservedNumber = $this->generateNextAvailableNumber($fiscalYear);
                $invoiceNumber = $this->formatInvoiceNumber($fiscalYear, $reservedNumber);
                $this->reserveForUser($fiscalYear, $reservedNumber);
            }

            $invoice = Invoice::create(
                $request->validated() + [
                    'user_id'        => auth()->id(),
                    'invoice_no'     => $invoiceNumber,
                    'fiscal_year_id' => $fiscalYear->id,
                ]
            );

            $this->syncParticulars($invoice, $request->input('particulars', []));

            // Release reservation so next user gets next number
            $this->clearUserReservation($fiscalYear);

            return $invoice;
        });

        toast('नगदी रसिद सफलतापूर्वक थपियो | रसिद नं.: ' . $invoice->invoice_no, 'success');
        return back();
    }

    public function show(Invoice $invoice): View|Factory
    {
        $this->checkAuthorization('invoice_access');

        $invoice->loadMissing(['invoiceParticulars', 'user', 'fiscalYear']);
        $invoice->loadSum(['invoiceParticulars' => function ($query) {
            $query->select(DB::raw('SUM((rate * quantity)) as total'));
        }], 'total');

        $nepaliDate = get_nepali_number(adToBs($invoice->created_at->format('Y-m-d')));

        return view('admin.invoice.show', compact('invoice', 'nepaliDate'));
    }

    public function edit(Invoice $invoice): View|Factory
    {
        $this->checkAuthorization('invoice_edit');
        $invoice->loadMissing('invoiceParticulars');
        $fiscalYears = FiscalYear::latest()->get();

        return view('admin.invoice.edit', compact('invoice', 'fiscalYears'));
    }

    /**
     * @throws Throwable
     */
    public function update(UpdateInvoiceRequest $request, Invoice $invoice): RedirectResponse
    {
        $this->checkAuthorization('invoice_edit');

        DB::transaction(function () use ($request, $invoice) {
            $invoice->update($request->validated());
            $this->syncParticulars($invoice, $request->input('particulars', []));
        });

        toast('नगदी रसिद सफलतापूर्वक सम्पादन भयो', 'success');
        return redirect()->route('admin.revenue.invoice.index');
    }

    public function destroy(Invoice $invoice): RedirectResponse
    {
        $this->checkAuthorization('invoice_delete');
        $invoice->delete();

        toast('नगदी रसिद सफलतापूर्वक हटाइयो', 'success');
        return redirect()->route('admin.revenue.invoice.index');
    }

    // =============================================================================
    // RELOAD-PROOF + SOFT-DELETE SAFE INVOICE NUMBER SYSTEM
    // =============================================================================

    /**
     * Returns SAME number on every reload (F5) until saved or expired
     */
    private function getOrReserveInvoiceNumber(FiscalYear $fiscalYear): int
    {
        $userKey = $this->userReservationKey($fiscalYear);

        // If user already has a reserved number → return it (RELOAD SAFE)
        if ($reserved = Cache::get($userKey)) {
            return (int) $reserved;
        }

        // First time → generate and reserve
        return $this->generateNextAvailableNumber($fiscalYear);
    }

    /**
     * Generate next valid number (respects soft-deletes, never goes backward)
     */
    private function generateNextAvailableNumber(FiscalYear $fiscalYear): int
    {
        $lockKey    = "invoice_global_lock:fy:{$fiscalYear->id}";
        $counterKey = "invoice_global_counter:fy:{$fiscalYear->id}";
        $userKey    = $this->userReservationKey($fiscalYear);

        return Cache::lock($lockKey, 10)->block(10, function () use ($fiscalYear, $counterKey, $userKey) {
            // Get highest number from DB (including soft-deleted)
            $highest = Invoice::withTrashed()
                ->where('fiscal_year_id', $fiscalYear->id)
                ->whereNotNull('invoice_no')
                ->orderByRaw("CAST(SUBSTRING(invoice_no, LOCATE('-', invoice_no) + 1) AS UNSIGNED) DESC")
                ->value(DB::raw("CAST(SUBSTRING(invoice_no, LOCATE('-', invoice_no) + 1) AS UNSIGNED)")) ?? 0;

            $cached = Cache::get($counterKey, 0);
            $next   = max($highest, $cached) + 1;

            // Reserve for this user
            Cache::put($userKey, $next, now()->addSeconds(self::RESERVATION_TTL));

            // Update global counter
            Cache::forever($counterKey, $next);

            return $next;
        });
    }

    private function getReservedNumberForUser(FiscalYear $fiscalYear): ?int
    {
        return Cache::get($this->userReservationKey($fiscalYear));
    }

    private function reserveForUser(FiscalYear $fiscalYear, int $number): void
    {
        Cache::put($this->userReservationKey($fiscalYear), $number, now()->addSeconds(self::RESERVATION_TTL));
    }

    private function clearUserReservation(FiscalYear $fiscalYear): void
    {
        Cache::forget($this->userReservationKey($fiscalYear));
    }

    private function userReservationKey(FiscalYear $fiscalYear): string
    {
        return "invoice_reserved:user:" . auth()->id() . ":fy:{$fiscalYear->id}";
    }

    private function formatInvoiceNumber(FiscalYear $fiscalYear, int $number): string
    {
        return $fiscalYear->title . '-' . str_pad($number, 4, '0', STR_PAD_LEFT);
    }

    // =============================================================================
    // PARTICULARS SYNC
    // =============================================================================

    private function syncParticulars(Invoice $invoice, array $particulars): void
    {
        $keepIds = collect();

        foreach ($particulars ?? [] as $particular) {
            if (empty(array_filter($particular))) continue;

            $p = InvoiceParticular::updateOrCreate(
                ['invoice_id' => $invoice->id, 'id' => $particular['id'] ?? null],
                \Arr::except($particular, ['id'])
            );
            $keepIds->push($p->id);
        }

        $invoice->invoiceParticulars()
            ->when($keepIds->isNotEmpty(), fn($q) => $q->whereNotIn('id', $keepIds))
            ->delete();
    }
}
