<?php

use App\Http\Controllers\LyricController;
use App\Http\Controllers\FavoriteController;
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
    Route::get('/all', [LyricController::class, 'getAll']);
    Route::get('/myUpload/{token}', [LyricController::class, 'getMyUpload']);
    Route::get('/myFavorite/{token}', [FavoriteController::class, 'getMyFavorite']);


    Route::post('/', [LyricController::class, 'create']);
    Route::get('/{lyric_id}', [LyricController::class, 'read']);
    Route::put('/', [LyricController::class, 'update']);
    Route::delete('/{token}/{lyric_id}', [LyricController::class, 'delete']);
});


Route::prefix('favorites')->group(function () {
    Route::get('/{token}/{lyric_id}', [FavoriteController::class, 'isFavorite']);
    Route::post('/', [FavoriteController::class, 'switchFavorite']);
});