<?php

use App\Http\Controllers\Api\Auth\LoginController;
use Illuminate\Support\Facades\Route;


Route::post("v1/login",[LoginController::class,"login"]);