<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ReportsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::middleware('auth:sanctum')->group(function () {
    Route::post('migrant', [ReportsController::class, 'save'])->name('save_record');
    // Route::post('currentmigrant', [ReportsController::class, 'store'])->name('store_record');
});

Route::post('login', [AuthController::class, 'login'])->name('login');
