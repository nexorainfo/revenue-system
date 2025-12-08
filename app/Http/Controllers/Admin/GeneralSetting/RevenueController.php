<?php

namespace App\Http\Controllers\Admin\GeneralSetting;

use App\Http\Controllers\Controller;
use App\Http\Requests\Revenue\StoreRevenueRequest;
use App\Http\Requests\Revenue\UpdateRevenueRequest;
use App\Models\Settings\Revenue;
use App\Models\Settings\RevenueCategory;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;

final class RevenueController extends Controller
{
    public function index(): Application|Factory|View
    {
        $this->checkAuthorization('revenue_access');
        $revenues = Revenue::with('revenueCategory')->latest()->get();
        return view('admin.global.revenue.index', compact('revenues'));
    }

    public function create(): Factory|View
    {
        $this->checkAuthorization('revenue_create');
        $revenueCategories = get_revenue_categories(all: true);
        return view('admin.global.revenue.create', compact('revenueCategories'));
    }

    public function store(StoreRevenueRequest $request): RedirectResponse
    {
        $this->checkAuthorization('revenue_create');

        Revenue::create($request->validated() + ['user_id' => auth()->id()]);
        Cache::forget('revenues');
        toast('राजस्वको शिर्षक सफलतापुर्वक राखियो', 'success')->autoClose(2000)->timerProgressBar();
        return redirect()->back();
    }

    public function show(Revenue $revenue): void
    {
        $this->checkAuthorization('revenue_access');

    }

    public function edit(Revenue $revenue): Factory|View
    {
        $this->checkAuthorization('revenue_edit');
        $revenueCategories = get_revenue_categories(all: true);
        return view('revenue::admin.setting.revenue.edit', compact('revenue', 'revenueCategories'));
    }

    public function update(UpdateRevenueRequest $request, Revenue $revenue): RedirectResponse
    {
        $this->checkAuthorization('revenue_edit');
        $revenue->update($request->validated());
        Cache::forget('revenues');
        toast('राजस्वको शिर्षक सम्पादन गरियो', 'success')->autoClose(2000)->timerProgressBar();
        return redirect()->route('admin.generalSetting.revenue.index');
    }

    public function destroy(Revenue $revenue): RedirectResponse
    {
        $this->checkAuthorization('revenue_delete');
        $revenue->delete();
        Cache::forget('revenues');
        toast('राजस्वको शिर्षक हटाइयो', 'success')->autoClose(2000)->timerProgressBar();
        return redirect()->route('admin.generalSetting.revenue.index');
    }

    public function updateStatus(Revenue $revenue): RedirectResponse
    {
        $this->checkAuthorization('revenue_edit');
        $revenue->update(['is_active' => !$revenue->is_active]);
        Cache::forget('revenues');
        toast('राजस्वको शिर्षक स्थिति अपडेट गरियो', 'success')->autoClose(2000)->timerProgressBar();
        return redirect()->route('admin.generalSetting.revenue.index');
    }
}
