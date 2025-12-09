<?php

namespace App\Http\Controllers\Admin\Revenue;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Settings\FiscalYear;
use App\Models\Settings\RevenueCategory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

final class ReportController extends Controller
{
    public function index(): View
    {
        $fiscalYears = FiscalYear::all();
        return view('admin.report.index', compact('fiscalYears'));
    }


    public function report(Request $request): JsonResponse
    {
        $request->validate([
            'from_date' => ['nullable'],
            'to_date' => ['nullable', 'after_or_equal:from_date'],
            'payment_method' => ['nullable'],
            'fiscal_year' => ['nullable', 'integer', Rule::exists('fiscal_years', 'id')],
        ]);


        $invoices = Invoice::with(['fiscalYear', 'user'])
            ->withSum(['invoiceParticulars' => function ($query) {
                $query->select(DB::raw('SUM((rate * quantity) + (rate * quantity) * due ) as total'));
            }], 'total')
            ->where(function ($q) use ($request) {
                $this->filterDataFromUser($q, $request);
            })
            ->get();
        return response()->json([
            'letterHead' => letterHead(),
            'data' => $invoices->map(fn($invoice) => [
                'आर्थिक वर्ष' => $invoice->fiscalYear->title,
                'मिति' => get_nepali_number($invoice->payment_date),
                'बिल नं' => get_nepali_number($invoice->invoice_no),
                'नाम' => $invoice->name,
                'ठेगाना' => $invoice->address,
                'भुक्तानीको मध्यम' => $invoice->payment_method === 'Cash' ? "नगद" : "बैंक",
                'रकम' => 'रु. ' . get_nepali_number($invoice->invoice_particulars_sum_total ?? 0),
                'बिल काट्ने व्यक्ति ' => $invoice->user?->name,
                'कैफियत' => $invoice->remarks ?? "",
            ]),
            'total' => [
                [
                    [

                        'colSpan' => 7,
                        'data' => 'जम्मा',
                        'class' => 'text-center'
                    ],
                    [
                        'type' => 'data',
                        'data' => 'रु. ' . get_nepali_number($invoices->sum('invoice_particulars_sum_total'))
                    ],
                    [
                        'colSpan' => 2
                    ],
                ]
            ],
        ]);
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

    public function revenueType(): View
    {
        $fiscalYears = FiscalYear::all();
        return view('admin.report.index', compact('fiscalYears'));
    }

    public function revenueTypeReport(Request $request): JsonResponse
    {
        $request->validate([
            'from_date' => ['nullable'],
            'to_date' => ['nullable', 'after_or_equal:from_date'],
            'payment_method' => ['nullable'],
            'fiscal_year' => ['nullable', 'integer', Rule::exists('fiscal_years', 'id')],
        ]);

RevenueCategory::withCount('nestedRevenueCategories');
        $invoices = Invoice::with(['fiscalYear', 'user'])
            ->withSum(['invoiceParticulars' => function ($query) {
                $query->select(DB::raw('SUM((rate * quantity) + (rate * quantity) * due ) as total'));
            }], 'total')
            ->where(function ($q) use ($request) {
                $this->filterDataFromUser($q, $request);
            })
            ->get();
        return response()->json([
            'letterHead' => letterHead(),
            'data' => $invoices->map(fn($invoice) => [
                'आर्थिक वर्ष' => $invoice->fiscalYear->title,
                'मिति' => get_nepali_number($invoice->payment_date),
                'बिल नं' => get_nepali_number($invoice->invoice_no),
                'नाम' => $invoice->name,
                'ठेगाना' => $invoice->address,
                'भुक्तानीको मध्यम' => $invoice->payment_method === 'Cash' ? "नगद" : "बैंक",
                'रकम' => 'रु. ' . get_nepali_number($invoice->invoice_particulars_sum_total ?? 0),
                'बिल काट्ने व्यक्ति ' => $invoice->user?->name,
                'कैफियत' => $invoice->remarks ?? "",
            ]),
            'total' => [
                [
                    [

                        'colSpan' => 7,
                        'data' => 'जम्मा',
                        'class' => 'text-center'
                    ],
                    [
                        'type' => 'data',
                        'data' => 'रु. ' . get_nepali_number($invoices->sum('invoice_particulars_sum_total'))
                    ],
                    [
                        'colSpan' => 2
                    ],
                ]
            ],
        ]);
    }

}
