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

        $invoices = Invoice::withSum(['invoiceParticulars' => function ($query) {
            $query->select(DB::raw('SUM((rate * quantity) + (rate * quantity) * due ) as total'));
        }], 'total')
            ->where('fiscal_year_id', officeSetting()->fiscal_year_id)
            ->latest('payment_date_en')
            ->paginate(25);

        return view('admin.invoice.index', compact('invoices'));
    }

    public function create(): View|Factory
    {
        $this->checkAuthorization('invoice_create');

        $fiscalYear = officeSetting()->fiscalYear;

        $serialNumber  = $this->reserveInvoiceNumberForUser($fiscalYear);
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
                abort(400, 'Invoice number expired. Please go back and reload the form.');
            }

            $invoice = Invoice::create(
                $request->validated() + [
                    'user_id'        => auth()->id(),
                    'invoice_no'     => $this->formatInvoiceNumber($fiscalYear, $reservedNumber),
                    'fiscal_year_id' => $fiscalYear->id,
                ]
            );

            $this->syncParticulars($invoice, $request->input('particulars', []));
            $this->releaseUserReservation($fiscalYear);

            return $invoice;
        });

        toast('नगदी रसिद सफलतापूर्वक थपियो | रसिद नं.: ' . $invoice->invoice_number, 'success');

        return back();
    }

    public function show(Invoice $invoice): View|Factory
    {
        $this->checkAuthorization('invoice_access');

        $invoice->loadMissing(['invoiceParticulars', 'user', 'fiscalYear'])
            ->loadSum(['invoiceParticulars' => function ($query) {
                $query->select(DB::raw('SUM((rate * quantity) ) as total'));
            }], 'total');

        $nepaliDate = get_nepali_number(adToBs($invoice->created_at->format('Y-m-d')));

        return view('admin.invoice.show', compact('invoice', 'nepaliDate'));
    }

    public function edit(Invoice $invoice): View|Factory
    {
        $this->checkAuthorization('invoice_edit');

        $fiscalYears = FiscalYear::latest()->get();
        $invoice->loadMissing('invoiceParticulars');

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
    // INVOICE NUMBER GENERATION
    // =============================================================================

    private function reserveInvoiceNumberForUser(FiscalYear $fiscalYear): int
    {
        $userKey = $this->getUserReservationKey($fiscalYear);

        if ($reserved = Cache::get($userKey)) {
            return $reserved;
        }

        $lockKey    = "invoice_global_lock:fy:{$fiscalYear->id}";
        $counterKey = "invoice_global_counter:fy:{$fiscalYear->id}";

        $lock = Cache::lock($lockKey, 10);

        return $lock->block(10, function () use ($counterKey, $userKey) {
            $next = Cache::get($counterKey, 0) + 1;

            Cache::put($userKey, $next, now()->addSeconds(self::RESERVATION_TTL));
            Cache::forever($counterKey, $next);

            return $next;
        });
    }

    private function getReservedNumberForUser(FiscalYear $fiscalYear): ?int
    {
        return Cache::get($this->getUserReservationKey($fiscalYear));
    }

    private function releaseUserReservation(FiscalYear $fiscalYear): void
    {
        Cache::forget($this->getUserReservationKey($fiscalYear));
    }

    private function getUserReservationKey(FiscalYear $fiscalYear): string
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

        foreach ($particulars as $particular) {
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
