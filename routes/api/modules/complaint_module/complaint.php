<?php

use App\Http\Controllers\Api\Modules\ComplaintModule\Complaint\ComplaintApiController;
use Illuminate\Support\Facades\Route;


Route::post("v1/create-complaint",[ComplaintApiController::class,"create"]);