<?php

namespace App\Http\Controllers\Admin\Revenue;

use App\Http\Resources\InvoiceResource;
use App\Models\Invoice;
use App\Models\Settings\FiscalYear;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\Rule;

final class ReportController extends Controller
{
    public function index(): \Illuminate\Contracts\View\View
    {
        $fiscalYears = FiscalYear::all();
        return view('admin.report.index', compact('fiscalYears', ));
    }


    public function report(Request $request): JsonResponse
    {
        $request->validate([
            'from_date' => ['nullable'],
            'to_date' => ['nullable', 'after_or_equal:from_date'],
            'payment_method'=>['nullable'],
            'fiscal_year'=>['nullable', 'integer', Rule::exists('fiscal_years', 'id')],
        ]);


        $invoices = Invoice::with(['fiscalYear','user'])
            ->withSum(['invoiceParticulars' => function ($query) {
                $query->select(DB::raw('SUM((rate * quantity) + (rate * quantity) * due ) as total'));
            }], 'total')
            ->where(function ($q) use ($request) {
            $this->filterDataFromUser($q, $request);
        })
            ->get()
            ->map(function ($invoice) {
                return [
                    'आर्थिक वर्ष'=>$invoice->fiscalYear->title,
                    'मिति' => get_nepali_number($invoice->payment_date),
                    'बिल नं'=>get_nepali_number($invoice->invoice_no),
                    'नाम' => $invoice->name,
                    'ठेगाना' => $invoice->address,
                    'भुक्तानीको मध्यम'=>$invoice->payment_method === 'Cash'? "नगद":"बैंक",
                    'रकम'=>'रु. '.get_nepali_number($invoice->invoice_particulars_sum_total ?? 0),
                    'बिल काट्ने व्यक्ति '=>$invoice->user?->name,
                    'कैफियत'=>$invoice->remarks ?? "",
                ];

            })
        ;
        return response()->json([
            'data' => $invoices
        ]);
    }

    private function getColumns(): Collection
    {
        $columnData = collect();

        new Invoice()
            ->ownAndRelatedModelsFillableColumns()
            ->filter(function ($column) {
                return !array_keys($column, 'printedData');
            })
            ->each(function ($column) use ($columnData) {
                $columnData->push(collect($column)->put('columns', $column['columns']));
            });
        return $columnData;
    }

    private function filterDataFromUser(mixed $q, Request $request): void
    {
        if (!empty($request->input('fiscal_year'))) {
            $q->where('fiscal_year_id', $request->input('fiscal_year'));
        }

        if (!empty($request->input('from_date'))) {
            $q->whereDate('payment_date', '>=', $request->input('from_date'));
        }

        if (!empty($request->input('to_date'))) {
            $q->whereDate('payment_date', '<=', $request->input('to_date'));
        }

        if (!empty($request->input('payment_method'))) {
            $q->where('payment_method', $request->input('payment_method'));
        }
    }

    public function invoice(): \Illuminate\Contracts\View\View
    {
        $fiscalYears = FiscalYear::all();
        return view('admin.report.invoice', compact('fiscalYears'));
    }



    public function invoiceReport(Request $request): JsonResponse
    {
        $request->validate([
            'from_date' => ['nullable'],
            'to_date' => ['nullable'],
            'payment_method' => ['nullable'],
            'fiscal_year' => ['nullable', 'array'],
            'fiscal_year.*' => [Rule::exists('fiscal_years', 'id')],
        ]);



        $invoices = Invoice::where(function ($query) use ($request) {
            $this->filterDataFromUser($query, $request);

        })->get();

        $wardData = [];
        foreach (officeSetting()->localBody->ward_no as $ward_no) {
            $wardData[] = $invoices->where('ward', $ward_no)->count();
        }

        $palikaCount = $invoices->whereNull('ward')->count();

        return response()->json([
            'fiscal_years' => !empty($request->input('fiscal_year')) ? FiscalYear::select('title')->whereIn('id', Arr::wrap($request->input('fiscal_year')))->pluck('title') : FiscalYear::pluck('title'),
            'wardsData' => $wardData,
            'palikaCount' => $palikaCount,
        ]);
    }
}
