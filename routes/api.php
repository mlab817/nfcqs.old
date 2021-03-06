<?php

use App\Http\Controllers\Api\HandleArimaController;
use App\Http\Controllers\Api\HandleCagrController;
use App\Http\Controllers\Api\HandleImageUploadController;
use App\Http\Controllers\Api\HandleLttController;
use App\Http\Controllers\Api\HandleSaveModelResults;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/', function () {
    return 'index of api';
});

Route::post('handle_ltt', HandleLttController::class);

Route::post('handle_cagr', HandleCagrController::class);

Route::post('handle_arima', HandleArimaController::class);

Route::post('handle_image_upload', HandleImageUploadController::class);

Route::post('handle_save_model_results', HandleSaveModelResults::class);