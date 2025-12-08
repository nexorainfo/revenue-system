<?php

namespace Modules\Revenue\Http\Controllers\Admin;

use App\Models\Settings\FiscalYear;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Modules\Plan\Transformers\ProjectResource;
use Modules\Revenue\Entities\TaxPayer;

class ReportController extends Controller
{
    public function index()
    {
        $fiscalYears = FiscalYear::get();
        $columnData = $this->getColumns();

        return view('revenue::admin.report.index', compact('fiscalYears', 'columnData'));
    }

    public function report(Request $request)
    {
        $request->validate([
            'from_date' => ['nullable'],
            'to_date' => ['nullable', 'after_or_equal:from_date'],
            'columns' => ['nullable', 'array']
        ]);

        if (empty($request->input('columns'))) {
            $request->request->add(
                ['columns' =>
                    [
                        'projects' => ['registration_no', 'project_name', 'project_start_date', 'project_completion_date', 'allocated_amount']
                    ]
                ]
            );
        }

        $projects = TaxPayer::with('fiscalYear')->where(function ($q) use ($request) {
            $this->filterDataFromUser($q, $request);
        })->get();

        if (!empty($request->input('columns')['project_grant_details'])) {
            $projects->load('projectGrantDetails');
        }

        if (!empty($request->input('columns')['benefited_member_details'])) {
            $projects->load('benefitedMemberDetails');
        }

        return response()->json([
            'data' => ProjectResource::collection($projects)
        ]);
    }

    private function getColumns(): Collection
    {
        $columnData = collect();

        (new TaxPayer())
            ->ownAndRelatedModelsFillableColumns()
//            ->filter(function ($column) {
//                return !array_keys($column, 'printedData');
//            })
            ->each(function ($column) use ($columnData) {
                $columnData->push(collect($column)->put('columns', $column['columns']));
            });
        return $columnData;
    }
}
