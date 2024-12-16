<?php

use Illuminate\Http\Request;
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


use App\Http\Controllers\Api\DataController;
use App\Http\Controllers\TrainingController;

Route::post('/training', [TrainingController::class, 'store']);
Route::get('/training', [TrainingController::class, 'index2']);
Route::get('/training/{id}', [TrainingController::class, 'show']);

Route::middleware(['validate_api_key'])->group(function () {
    Route::get('/data', [DataController::class, 'index']); // Fetch data
    Route::get('/data/{id}', [DataController::class, 'show']); // Fetch specific record
    Route::post('/data', [DataController::class, 'store']); // Create new record
    Route::put('/data/{id}', [DataController::class, 'update']); // Update record
    Route::delete('/data/{id}', [DataController::class, 'destroy']); // Delete record
});

