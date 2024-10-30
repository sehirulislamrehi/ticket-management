<?php

use App\Http\Controllers\Api\Modules\ComplaintModule\Complaint\ComplaintApiController;
use Illuminate\Support\Facades\Route;


Route::post("v1/complaint/create",[ComplaintApiController::class,"create"]);
Route::get("v1/complaints",[ComplaintApiController::class,"list"]);
Route::get("v1/complaints/{id}",[ComplaintApiController::class,"details"]);
Route::patch("v1/complaints/{id}",[ComplaintApiController::class,"update_status"]);