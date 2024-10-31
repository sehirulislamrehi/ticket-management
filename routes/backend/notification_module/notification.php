<?php

use App\Http\Controllers\Backend\NotificationModule\Notification\NotificationController;
use Illuminate\Support\Facades\Route;

//user start 
Route::group(['prefix' => 'notification'], function () {
    Route::get("my/notification", [NotificationController::class, 'my_notification'])->name('notification.my');
    Route::get("notification/view/{id}", [NotificationController::class, 'make_notification_view'])->name('notification.make.view');
    Route::get("notification", [NotificationController::class, 'index'])->name('notification.all');
    Route::get("notification/data", [NotificationController::class, 'data'])->name('notification.data');
    Route::get("notification/delete/{id}", [NotificationController::class, 'delete_modal'])->name('notification.delete.modal');
    Route::post("notification/delete/{id}", [NotificationController::class, 'delete'])->name('notification.delete');
});
//user end
