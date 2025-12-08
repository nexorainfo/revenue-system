<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ChartOptionEnum;
use App\Http\Controllers\Controller;
use App\Models\Settings\FiscalYear;
use App\Traits\NepaliDateConverter;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

final class DashboardController extends Controller
{
    use NepaliDateConverter;


    public function index(): View
    {
        $fiscal_year_id = officeSetting()?->fiscal_year_id ?? null;



        $invoiceCount = DB::table('invoices')
            ->where('fiscal_year_id', $fiscal_year_id)
            ->whereNull('deleted_at')
            ->count();

        $results = DB::table('invoices')
            ->selectRaw('invoices.is_cash_invoice, invoices.payment_method, invoices.payment_date, invoices.payment_date_en, invoices.fiscal_year_id, SUM((invoice_particulars.rate * invoice_particulars.quantity) + (invoice_particulars.rate * invoice_particulars.quantity) * invoice_particulars.due ) as total')
            ->join('invoice_particulars', 'invoice_particulars.invoice_id', '=', 'invoices.id')

            ->whereNull('invoices.deleted_at')
            ->whereNull('invoice_particulars.deleted_at')
            ->groupBy('invoices.fiscal_year_id', 'invoices.payment_date', 'invoices.is_cash_invoice', 'invoices.payment_method', 'invoices.payment_date_en')
            ->get();

        $all_total = $results->sum('total');

        $fiscal_year_total = $results->where('fiscal_year_id', $fiscal_year_id)->sum('total');

        $today_total = $results->where('payment_date_en', today())->sum('total');

        $nepaliMonth = $this->get_nepali_date(date('Y'), date('m'), date('d'));

        $this_month_total = $results->where('fiscal_year_id', $fiscal_year_id)
            ->filter(function ($item) use ($nepaliMonth) {
                return date('m', strtotime($item->payment_date)) == $nepaliMonth['m'];
            })
            ->sum('total');

        $previous_month_total = $results->where('fiscal_year_id', $fiscal_year_id)
            ->filter(function ($item) use ($nepaliMonth) {
                return date('m', strtotime($item->payment_date)) == $nepaliMonth['m'] - 1;
            })
            ->sum('total');

        return view('admin.dashboard', compact(
            [
                'invoiceCount',
                'all_total',
                'fiscal_year_total',
                'today_total',
                'this_month_total',
                'previous_month_total'
            ]
        ));
    }

    public function ajaxData(): array
    {
        $results = DB::table('invoices')
            ->selectRaw('invoices.is_cash_invoice,invoices.payment_method,invoices.payment_date,invoices.payment_date_en,invoices.fiscal_year_id, SUM((invoice_particulars.rate * invoice_particulars.quantity)+ (invoice_particulars.rate * invoice_particulars.quantity) * invoice_particulars.due + invoice_particulars.fine) as total')
            ->join('invoice_particulars', 'invoice_particulars.invoice_id', '=', 'invoices.id')
            ->whereNull('invoices.deleted_at')
            ->whereNull('invoice_particulars.deleted_at')
            ->groupBy('invoices.fiscal_year_id', 'invoices.payment_date', 'invoices.is_cash_invoice', 'invoices.payment_method', 'invoices.payment_date_en')
            ->get();
        $fiscal_year_id = officeSetting()->fiscal_year_id;
        return [
            'totalRevenue' => $this->totalRevenue($results),
            'totalCashBankRevenue' => $this->totalCashBankRevenue($results),
            'accordingToFy' => $this->accordingToFy($results),
            'accordingToMonth' => $this->accordingToMonth($results->where('fiscal_year_id', $fiscal_year_id)),
        ];
    }



    public function totalRevenue(Collection $result): array
    {
        $cashReceiptTotal = $result->where('is_cash_invoice', 1)->sum('total');
        $creditReceiptTotal = $result->where('is_cash_invoice', 0)->sum('total');
        $labels = ['नगदी रसिद', 'मालपोत रसिद'];
        $subjects = collect([
            ['title' => 'नगदी रसिद', 'total' => $cashReceiptTotal],
            ['title' => 'मालपोत रसिद', 'total' => $creditReceiptTotal],
        ]);

        $labelColors = collect([]);

        // Generate random colors for labels
        $subjects->each(function ($subject) use ($labelColors) {
            $labelColors->push(generateRandomRGBAColor());
        });

        return [
            'labels' => $labels,
            'option' => ChartOptionEnum::PIE_CHART->option(),
            'dataSets' => [
                [
                    'data' => $subjects->pluck('total')->toArray(),
                    'label' => 'राजस्व',
                    'backgroundColor' => $labelColors->toArray(),
                    'borderWidth' => 1,
                ],
            ],
        ];
    }


    public function totalCashBankRevenue(Collection $result): array
    {
        $cashTotal = $result->where('payment_method', 'Cash')->sum('total');
        $bankTotal = $result->where('payment_method', 'Bank')->sum('total');
        $labels = ['नगद', 'बैंक'];
        $subjects = collect([
            ['title' => 'नगद', 'total' => $cashTotal],
            ['title' => 'बैंक', 'total' => $bankTotal],
        ]);

        $labelColors = collect([]);

        // Generate random colors for labels
        $subjects->each(function ($subject) use ($labelColors) {
            $labelColors->push(generateRandomRGBAColor());
        });

        return [
            'labels' => $labels,
            'option' => ChartOptionEnum::PIE_CHART->option(),
            'dataSets' => [
                [
                    'data' => $subjects->pluck('total')->toArray(),
                    'label' => 'राजस्व',
                    'backgroundColor' => $labelColors->toArray(),
                    'borderWidth' => 1,
                ],
            ],
        ];
    }



    public function accordingToFy(Collection $result): array
    {
        $totalRevenue = collect();
        $totalLandRevenue = collect();
        $totalCashRevenue = collect();
        $fiscalYears = FiscalYear::all()->each(function ($fiscalYear) use ($result, $totalCashRevenue, $totalRevenue, $totalLandRevenue) {
            $totalRevenue->push($result->where('fiscal_year_id', $fiscalYear->id)->sum('total'));
            $totalLandRevenue->push($result->where('fiscal_year_id', $fiscalYear->id)->where('is_cash_invoice', 0)->sum('total'));
            $totalCashRevenue->push($result->where('fiscal_year_id', $fiscalYear->id)->where('is_cash_invoice', 1)->sum('total'));
        });


        return [
            'labels' => $fiscalYears->pluck('title')->toArray(),
            'dataSets' => [
                [
                    'data' => $totalRevenue,
                    'label' => 'जम्मा राजस्व',
                    'backgroundColor' => generateRandomRGBAColor(),
                    'borderColor' => generateRandomRGBAColor(),
                    'borderWidth' => 1,
                ],
                [
                    'data' => $totalLandRevenue,
                    'label' => 'मालपोत राजस्व',
                    'backgroundColor' => generateRandomRGBAColor(),
                    'borderColor' => generateRandomRGBAColor(),
                    'borderWidth' => 1,
                ],
                [
                    'data' => $totalCashRevenue,
                    'label' => 'नगदी राजस्व',
                    'backgroundColor' => generateRandomRGBAColor(),
                    'borderColor' => generateRandomRGBAColor(),
                    'borderWidth' => 1,
                ]
            ],
        ];
    }

    public function accordingToMonth(Collection $result): array
    {
        $data = collect();

        foreach ($this->month_name as $key => $month) {
            $data->push(
                $result->filter(function ($item) use ($key) {
                    return date('m', strtotime($item->payment_date)) == $key + 1;
                })
                    ->sum('total')
            );
        }

        return [
            'labels' => $this->month_name,
            'dataSets' => [
                [
                    'data' => $data,
                    'label' => 'जम्मा राजस्व',
                    'backgroundColor' => generateRandomRGBAColor(),
                    'borderColor' => generateRandomRGBAColor(),
                    'borderWidth' => 1,
                ],
            ],
        ];
    }

    public function cacheClear(): array
    {
        Artisan::call('optimize:clear');

        return [
            'message' => 'क्यास सफलतापूर्वक खाली गरियो',
        ];
    }
}
