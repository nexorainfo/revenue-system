<?php

use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\AddressController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GeneralSetting\FiscalYearController;
use App\Http\Controllers\Admin\GeneralSetting\LetterHeadController;
use App\Http\Controllers\Admin\GeneralSetting\OfficeSettingController;
use App\Http\Controllers\Admin\GeneralSetting\RevenueCategoryController;
use App\Http\Controllers\Admin\GeneralSetting\RevenueController;
use App\Http\Controllers\Admin\Revenue\InvoiceController;
use App\Http\Controllers\Admin\Revenue\ReportController;
use App\Http\Controllers\Admin\UserManagement\RoleController;
use App\Http\Controllers\Admin\UserManagement\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProfileController;

Route::get('profile', [ProfileController::class, 'profile'])->name('profile');
Route::patch('profile/update', [ProfileController::class, 'updateProfile'])->name('updateProfile');
Route::patch('password/update', [ProfileController::class, 'updatePassword'])->name('updatePassword');

Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('dashboard/ajax', [DashboardController::class, 'ajaxData'])->name('dashboard.ajax');

Route::controller(AddressController::class)->prefix('address')->as('address.')->group(function () {
    Route::get('districts', 'district')->name('districts');
    Route::get('local-bodies', 'localBodies')->name('local-bodies');
    Route::get('ward-no', 'wardNo')->name('ward-no');
});
Route::get('cache-clear', [DashboardController::class, 'cacheClear'])->name('cache-clear');

//notification
Route::get('notification', [NotificationController::class, 'notification'])->name('notification');
Route::get('notification/{databaseNotification}', [NotificationController::class, 'readNotification'])->name('notification.read');
Route::get('readAllNotification', [NotificationController::class, 'readAllNotification'])->name('notification.readAllNotification');

//activity logs
Route::get('activityLog', [ActivityLogController::class, 'index'])->name('activityLog.index');

Route::prefix('revenue')->as('revenue.')->group(function () {
    Route::resource('invoice', InvoiceController::class)->names('invoice');

    Route::prefix('report')->as('report.')->controller(ReportController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('report', 'report')->name('report-data');
        Route::get('invoice', 'invoice')->name('invoice');
        Route::post('invoice-report', 'invoiceReport')->name('invoice-report');
        Route::get('tax-payer', 'taxPayer')->name('tax-payer');
        Route::post('tax-payer-report', 'taxPayerReport')->name('tax-payer-report');
        Route::get('word-wise-invoice', 'wordWiseInvoice')->name('word-wise-invoice');
        Route::post('word-wise-invoice-report', 'wordWiseInvoiceReport')->name('word-wise-invoice-report');
    });
});

Route::prefix('generalSetting')->as('generalSetting.')->group(function () {
    Route::resource('fiscalYear', FiscalYearController::class);
    Route::resource('revenue-category', RevenueCategoryController::class)->except('show');

    Route::get('revenue/{revenue}/update-status', [RevenueController::class, 'updateStatus'])->name('revenue.update-status');
    Route::resource('revenue', RevenueController::class)->except('show');

});
Route::prefix('userManagement')->as('userManagement.')->group(function () {
    Route::get('role/{role}/letterHead', [RoleController::class, 'letterHeadPage'])->name('role.letterHead');
    Route::post('role/{role}/letterHead', [RoleController::class, 'letterHeadStore'])->name('role.letterHead.store');
    Route::resource('role', RoleController::class);
    Route::get('user/{user}/updateStatus', [UserController::class, 'updateStatus'])->name('user.updateStatus');
    Route::resource('user', UserController::class);
});
Route::prefix('systemSetting')->as('systemSetting.')->group(function () {
    Route::resource('officeSetting', OfficeSettingController::class);
    Route::resource('letterHead', LetterHeadController::class)->only('index', 'store');
});
