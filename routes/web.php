<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\DownloadFileController;
use App\Http\Controllers\ForecastController;
use App\Http\Controllers\InputController;
use App\Http\Controllers\UserController;
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
Route::get('confirm', [RegisterController::class,'confirmEmail'])->name('confirm_email');

// restricted routes
Route::group(['middleware' => 'auth'], function () {

    // dashboard
    Route::get('/', [InputController::class,'commodities'])->name('dashboard');
    Route::get('home', [InputController::class,'commodities'])->name('home');
    Route::get('result', [DashboardController::class,'result'])->name('result');
    Route::get('province', [DownloadController::class,'provinceForecast'])->name('province_forecast');
    Route::get('map-control', [DashboardController::class,'mapControl'])->name('map_control');
    Route::post('map-display', [DashboardController::class,'displayMap'])->name('display_map');

    // input controls
    Route::get('commodities', [InputController::class,'commodities'])->name('commodities');
    Route::get('commodities/add', [InputController::class,'addCommodity'])->name('add_commodity');
    Route::post('commodities/add', [InputController::class,'saveCommodity'])->name('save_commodity');
    Route::get('reports/upload', [InputController::class,'uploadReportForm'])->name('upload_report_form');
    Route::post('reports/upload', [InputController::class,'uploadReport'])->name('upload_report');
    Route::get('reports/list', [InputController::class,'reportList'])->name('report_list');
    Route::get('shifter', [InputController::class,'addShifter'])->name('add_shifter');
    Route::get('import-baseline', [InputController::class,'importBaseline'])->name('import_baseline');
    Route::delete('crop/{crop}/delete', [InputController::class,'deleteCrop'])->name('delete_crop');

    // forecast
    Route::post('forecast', [ForecastController::class,'forecast'])->name('forecast.post');
    Route::get('forecast', [ForecastController::class,'forecast'])->name('forecast.get');

    // change password
    Route::view('change-password', 'auth.password')->name('change_password.index');
    Route::post('change-password', [ResetPasswordController::class,'changePassword'])->name('change_password.post');

    // user management
    Route::get('user/{user}/access', [UserController::class,'changeAccess'])->name('users.access');

    Route::resource('users', UserController::class);

    Route::get('/download/{filePath}', DownloadFileController::class)->name('download_file');

});

Route::post('/save_file', function (\Illuminate\Http\Request $request) {
    $file = $request->file('file');
    \Illuminate\Support\Facades\Storage::put('uploads', $file);
    return response()->json('saved data',200);
});


Route::get('/exec', function() {
    $script = base_path() . '/scripts/test.py';
    $name = 'Lester';
    $command = escapeshellcmd("python $script $name 2>&1");
    $output = shell_exec($command);
    echo $output;
});