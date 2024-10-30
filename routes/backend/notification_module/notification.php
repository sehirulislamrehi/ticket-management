<?php

use App\Http\Controllers\Backend\NotificationModule\Notification\NotificationController;
use Illuminate\Support\Facades\Route;

//user start 
Route::group(['prefix' => 'notification'], function () {
    Route::get("my/notification", [NotificationController::class, 'my_notification'])->name('notification.my');
    Route::get("notification/view/{id}", [NotificationController::class, 'make_notification_view'])->name('notification.make.view');
});
//user end
