<?php

namespace App\Http\Controllers\Admin\GeneralSetting;

use App\Http\Controllers\Controller;
use App\Http\Requests\OfficeSetting\StoreOfficeSettingRequest;
use App\Models\Settings\FiscalYear;
use App\Models\Settings\OfficeSetting;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;

final class OfficeSettingController extends Controller
{
    public function index(): Factory|View|Application
    {
        $this->checkAuthorization('officeSetting_access');

        $officeSetting = OfficeSetting::where(function ($q) {
            if (!empty(auth()->user()->ward_no)) {
                $q->where('ward_no', auth()->user()->ward_no);
            } else {
                $q->whereNull('ward_no');
            }
        })
        ->first();
        $fiscalYears = FiscalYear::get();


        return view('admin.global.officeSetting.index', compact('officeSetting',  'fiscalYears'));
    }


    public function store(StoreOfficeSettingRequest $request): RedirectResponse
    {
        $this->checkAuthorization('officeSetting_edit');

        $officeSetting = OfficeSetting::where(function ($q) {
            if (!empty(auth()->user()->ward_no)) {
                $q->where('ward_no', auth()->user()->ward_no);
            } else {
                $q->whereNull('ward_no');
            }
        })
            ->first();

        if (!empty($officeSetting)) {
            if ($request->hasFile('logo') && $officeSetting->logo) {
                $this->deleteFile($officeSetting->logo);
            }
            if ($request->hasFile('logo1') && $officeSetting->logo1) {
                $this->deleteFile($officeSetting->logo1);
            }
            if ($request->hasFile('logo2') && $officeSetting->logo2) {
                $this->deleteFile($officeSetting->logo2);
            }
            if ($request->hasFile('background_image') && $officeSetting->background_image) {
                $this->deleteFile($officeSetting->background_image);
            }
            $officeSetting->update($request->validated());
        } else {
            OfficeSetting::create($request->validated() + ['ward_no' => auth()->user()->ward_no]);
        }


        Cache::forget('office_setting');

        toast('कार्यालय सेटिङ सफलतापूर्वक अद्यावधिक गरियो', 'success');

        return back();
    }
}
