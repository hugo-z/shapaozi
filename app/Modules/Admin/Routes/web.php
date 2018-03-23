<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your module. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::group(['prefix' => 'admin'], function () {
    Route::get('/', 'DashboardController@index')->middleware('auth');
    
    // Login
    Auth::routes();
    Route::get('login', 'SessionsController@showLoginForm')->name('login');  
    Route::post('login', 'SessionsController@authenticate');
    
    // Logout
    Route::post('logout', 'SessionsController@destroy');

      
});

