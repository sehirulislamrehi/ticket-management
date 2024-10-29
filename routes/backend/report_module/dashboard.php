<?php

use App\Http\Controllers\Backend\ReportModule\Dashboard\DashboardReportController;
use Illuminate\Support\Facades\Route;

//user start 
Route::group(['prefix' => 'dashboard-report'], function () {
    Route::get("task-counting", [DashboardReportController::class, 'task_counting'])->name('dashboard.report.task.counting');
    Route::get("highest-compelte-task-user", [DashboardReportController::class, 'highest_complete_task_user'])->name('dashboard.report.highest.complete.task.user');
    Route::get("highest-average-time-taken-user", [DashboardReportController::class, 'highest_average_time_taken_user'])->name('dashboard.report.highest.average.time.taken.user');
});
//user end
