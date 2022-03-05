<?php

use App\Http\Controllers\LyricController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('lyrics')->group(function () {
    Route::post('/', [LyricController::class, 'create']);
    Route::get('/all', [LyricController::class, 'getAll']);
    Route::get('/{id}', [LyricController::class, 'read']);
});
