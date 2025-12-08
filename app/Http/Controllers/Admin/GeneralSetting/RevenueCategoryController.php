<?php

namespace App\Http\Controllers\Admin\GeneralSetting;

use App\Http\Controllers\Controller;
use App\Http\Requests\RevenueCategory\StoreRevenueCategoryRequest;
use App\Http\Requests\RevenueCategory\UpdateRevenueCategoryRequest;
use App\Models\Settings\RevenueCategory;
use Illuminate\Support\Facades\Cache;

final class RevenueCategoryController extends Controller
{
    public function index()
    {
        $this->checkAuthorization('revenueCategory_access');
        $revenueCategories = RevenueCategory::with('revenueCategory')->latest()->get();

        return view('admin.global.revenue-category.index', compact('revenueCategories'));
    }

    public function create()
    {
        $this->checkAuthorization('revenueCategory_create');
        $revenueCategories = RevenueCategory::with('revenueCategories')->whereNull('revenue_category_id')->latest()->get();
        return view('admin.global.revenue-category.create', compact('revenueCategories'));
    }

    public function store(StoreRevenueCategoryRequest $request)
    {
        $this->checkAuthorization('revenueCategory_create');

        RevenueCategory::create($request->validated());

        Cache::forget('revenueCategories');
        toast('वर्ग सफलतापूर्वक थपियो', 'success');
        return redirect()->back();
    }


    public function edit(RevenueCategory $revenueCategory)
    {
        $this->checkAuthorization('revenueCategory_edit');

        $revenueCategories = RevenueCategory::with('revenueCategories')->whereNull('revenue_category_id')->latest()->get();

        return view('admin.global.revenue-category.edit', compact('revenueCategory', 'revenueCategories'));
    }

    public function update(UpdateRevenueCategoryRequest $request, RevenueCategory $revenueCategory)
    {
        $this->checkAuthorization('revenueCategory_edit');

        $revenueCategory->update($request->validated());
        Cache::forget('revenueCategories');
        toast('वर्ग सफलतापूर्वक सम्पादन गरियो', 'success');
        return redirect()->route('admin.generalSetting.revenue-category.index');
    }

    public function destroy(RevenueCategory $revenueCategory)
    {
        $this->checkAuthorization('revenueCategory_delete');

        $revenueCategory->delete();
        Cache::forget('revenueCategories');
        toast('वर्ग सफलतापूर्वक हटाइयो', 'success');
        return redirect()->route('admin.generalSetting.revenue-category.index');
    }
}
