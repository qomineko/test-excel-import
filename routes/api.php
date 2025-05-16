<?php

use App\Http\Controllers\UserImportController;
use App\Http\Controllers\UserIndexController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('imported-users')->group(function () {
    Route::post('/import', UserImportController::class);
    Route::get('/grouped-by-date', UserIndexController::class);
});
