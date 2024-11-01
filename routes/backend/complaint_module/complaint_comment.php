<?php

use App\Http\Controllers\Backend\ComplaintModule\ComplaintComment\ComplaintCommentController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'complaint/comment'], function () {
    Route::post("add/{id}", [ComplaintCommentController::class, 'add'])->name('complaint.comment.add');
});
