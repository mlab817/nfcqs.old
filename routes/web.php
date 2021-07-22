<?php

// authentication routes
Auth::routes();
Route::get('/logout', 'Auth\LoginController@logout');

// approve new user registration
Route::get('confirm', 'Auth\RegisterController@confirmEmail');

// restricted routes
Route::group(['middleware' => 'auth'], function () {

    // dashboard
    Route::get('/', 'InputController@commodities');
    Route::get('home', 'InputController@commodities');
    Route::get('result', 'DashboardController@result');
    Route::get('province', 'DownloadController@provinceForecast');
    Route::get('map-control', 'DashboardController@mapControl');
    Route::post('map-display', 'DashboardController@displayMap');

    // input controls
    Route::get('commodities', 'InputController@commodities');
    Route::get('commodities/add', 'InputController@addCommodity');
    Route::post('commodities/add', 'InputController@saveCommodity');
    Route::get('reports/upload', 'InputController@uploadReportForm');
    Route::post('reports/upload', 'InputController@uploadReport');
    Route::get('reports/list', 'InputController@reportList');
    Route::get('shifter', 'InputController@addShifter');
    Route::get('import-baseline', 'InputController@importBaseline');
    Route::get('crop/delete', 'InputController@deleteCrop');

    // forecast
    Route::post('forecast', 'ForecastController@forecast');
    Route::get('forecast', 'ForecastController@forecast');

    // change password
    Route::get('change-password', function() { return view('auth.password'); });
    Route::post('change-password', 'Auth\ResetPasswordController@changePassword');

    // user management
    Route::get('users', 'UserController@list');
    Route::get('user/edit', 'UserController@editUserForm');
    Route::post('user/update', 'UserController@updateUser');
    Route::get('user/access', 'UserController@changeAccess');
    Route::get('user/delete', 'UserController@deleteUser');

});
