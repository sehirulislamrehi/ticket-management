<?php

use App\Http\Controllers\Backend\DashboardController;
use Illuminate\Support\Facades\Route;

require_once "auth.php";

//backend route group start
Route::group(['prefix' => 'admindashboard', 'middleware' => 'admin_auth'], function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::group(['prefix' => 'user-module'], function(){
        require_once "user_module/role.php";
        require_once "user_module/user.php";
    });

    Route::group(['prefix' => 'complaint-module'], function(){
        require_once "complaint_module/complaint.php";
        require_once "complaint_module/complaint_comment.php";
    });

    Route::group(['prefix' => 'report-module'], function(){
        require_once "report_module/dashboard.php";
    });

    Route::group(['prefix' => 'notification-module'], function(){
        require_once "notification_module/notification.php";
    });

});

?>