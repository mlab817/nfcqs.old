<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

// approve new user registration
Route::get('confirm', 'Auth\RegisterController@confirmEmail');

// restricted routes
Route::group(['middleware' => 'auth'], function () {

    // dashboard
    Route::get('/', [\App\Http\Controllers\InputController::class,'commodities'])->name('dashboard');
    Route::get('home', [\App\Http\Controllers\InputController::class,'commodities'])->name('home');
    Route::get('result', [\App\Http\Controllers\DashboardController::class,'result'])->name('result');
    Route::get('province', [\App\Http\Controllers\DownloadController::class,'provinceForecast'])->name('province_forecast');
    Route::get('map-control', [\App\Http\Controllers\DashboardController::class,'mapControl'])->name('map_control');
    Route::post('map-display', [\App\Http\Controllers\DashboardController::class,'displayMap'])->name('display_map');

    // input controls
    Route::get('commodities', [\App\Http\Controllers\InputController::class,'commodities'])->name('commodities');
    Route::get('commodities/add', [\App\Http\Controllers\InputController::class,'addCommodity'])->name('add_commodity');
    Route::post('commodities/add', [\App\Http\Controllers\InputController::class,'saveCommodity'])->name('save_commodity');
    Route::get('reports/upload', [\App\Http\Controllers\InputController::class,'uploadReportForm'])->name('upload_report_form');
    Route::post('reports/upload', [\App\Http\Controllers\InputController::class,'uploadReport'])->name('upload_report');
    Route::get('reports/list', [\App\Http\Controllers\InputController::class,'reportList'])->name('report_list');
    Route::get('shifter', [\App\Http\Controllers\InputController::class,'addShifter'])->name('add_shifter');
    Route::get('import-baseline', [\App\Http\Controllers\InputController::class,'importBaseline'])->name('import_baseline');
    Route::get('crop/delete', [\App\Http\Controllers\InputController::class,'deleteCrop'])->name('delete_crop');

    // forecast
    Route::post('forecast', [\App\Http\Controllers\ForecastController::class,'forecast'])->name('forecast.post');
    Route::get('forecast', [\App\Http\Controllers\ForecastController::class,'forecast'])->name('forecast.get');

    // change password
    Route::view('change-password', 'auth.password')->name('change_password.index');
    Route::post('change-password', 'Auth\ResetPasswordController@changePassword')->name('change_password.post');

    // user management
    Route::get('user/{user}/access', [\App\Http\Controllers\UserController::class,'changeAccess'])->name('users.access');

    Route::resource('users', \App\Http\Controllers\UserController::class);

});
