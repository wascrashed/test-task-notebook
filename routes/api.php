<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\NotebookController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::prefix('v1')->group(function () {
    Route::get('/notebook', [NotebookController::class, 'index']);
    Route::get('/notebook/{id}', [NotebookController::class, 'show']);
    Route::post('/notebook', [NotebookController::class, 'store']);
    Route::put('notebook/{id}', [NotebookController::class, 'update']);
    Route::delete('/notebook/{id}',  [NotebookController::class, 'destroy']);
});
