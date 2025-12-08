<?php

namespace App\Traits;

use App\Exports\ReportExport;
use Maatwebsite\Excel\Facades\Excel;

trait ExcelTrait
{
    private function storeExcelFile($lists): string
    {
        $excelUrl = 'excel/' . date('Ymd') . '/' . time() . '.xlsx';
        Excel::store(new ReportExport($lists), $excelUrl, 'public');

        return $excelUrl;
    }
}
