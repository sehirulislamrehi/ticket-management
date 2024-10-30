<?php

use App\Http\Controllers\Backend\ReportModule\Dashboard\DashboardReportController;
use Illuminate\Support\Facades\Route;

//user start 
Route::group(['prefix' => 'dashboard-report'], function () {
    Route::get("complaint/status/report", [DashboardReportController::class, 'status_report'])->name('dashboard.status.report');
    Route::get("complaint/priority/report", [DashboardReportController::class, 'priority_report'])->name('dashboard.priority.report');
    Route::get("complaint/category/report", [DashboardReportController::class, 'category_report'])->name('dashboard.category.report');
    Route::get("complaint/over/time", [DashboardReportController::class, 'over_time_report'])->name('dashboard.over.time.report');
});
//user end
