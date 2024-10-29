<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\UserModule\User\UserController;

//user start 
    Route::group(['prefix' => 'user'], function(){
        Route::get("/",[UserController::class,'index'])->name('user.all');
        Route::get("/data",[UserController::class,'data'])->name('user.data');

        //user add
        Route::get("/add",[UserController::class,'add_modal'])->name('user.add.modal');
        Route::post("/add",[UserController::class,'add'])->name('user.add');

        //user edit
        Route::get("/edit/{id}",[UserController::class,'edit'])->name('user.edit');
        Route::post("/edit/{id}",[UserController::class,'update'])->name('user.update');

        //password reset
        Route::get("/reset/modal/{id}",[UserController::class,'reset_modal'])->name('user.reset.modal');
        Route::post("/reset/{id}",[UserController::class,'reset'])->name('user.reset');

        //password reset
        Route::get("edit-my-profile-page",[UserController::class,'edit_my_profile_page'])->name('user.edit.my.profile.page');
        Route::post("edit-my-profile",[UserController::class,'edit_my_profile'])->name('user.edit.my.profile');
        Route::post("edit-my-password",[UserController::class,'edit_my_password'])->name('user.edit.my.password');

    }); 
    //user end


?>