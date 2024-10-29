<?php

use App\Http\Controllers\Backend\ComplaintModule\Complaint\ComplaintController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'complaint'], function () {
    Route::get("", [ComplaintController::class, 'index'])->name('complaint.all');
    Route::get("data", [ComplaintController::class, 'data'])->name('complaint.data');
    Route::get("add-modal", [ComplaintController::class, 'add_modal'])->name('complaint.add.modal');
    Route::post("add", [ComplaintController::class, 'add'])->name('complaint.add');
    Route::get("edit-modal/{id}", [ComplaintController::class, 'edit_modal'])->name('complaint.edit.modal');
    Route::post("edit/{id}", [ComplaintController::class, 'edit'])->name('complaint.edit');
    Route::get("details/{id}", [ComplaintController::class, 'details'])->name('complaint.details');
});
