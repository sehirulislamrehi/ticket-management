<?php

use App\Http\Controllers\Backend\ComplaintModule\ComplaintComment\ComplaintCommentController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'complaint/comment'], function () {
    Route::get("get/{id}", [ComplaintCommentController::class, 'get'])->name('complaint.comments');
    Route::post("add/{id}", [ComplaintCommentController::class, 'add'])->name('complaint.comment.add');
    Route::post("edit/{id}", [ComplaintCommentController::class, 'edit'])->name('complaint.comment.edit');
    Route::get("delete/{id}", [ComplaintCommentController::class, 'delete'])->name('complaint.comment.delete');
});
