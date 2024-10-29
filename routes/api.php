<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


require_once "api/auth/auth.php";

Route::middleware('auth:sanctum')->group(function () {
    require_once "api/modules/complaint_module/complaint.php";
});
