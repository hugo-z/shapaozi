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

Route::group(['prefix' => 'superuser'], function () {
    Event::listen('illuminate.query',function($query){
        var_dump($query);
    });
    Route::get('/', function () {
        dd('This is the Superuser module index page. Build something great!');
    });
    Route::group(['prefix' => 'roles'], function () {
        Route::get('/', 'RoleController@index')->name('rolesList');

        Route::get('create-role', 'RoleController@create')->name('addRole');

        Route::get('edit-role/{id}', 'RoleController@update')->name('editRole');

        Route::get('ajax-pager', 'RoleController@ajaxData')->name('rolePager');

        Route::post('store', 'RoleController@store');
    });

    Route::group(['prefix' => 'users'], function () {
        Route::get('/', 'UsersController@index')->name('usersList');

        // Route::get('create-user/{step?}', 'UsersController@createOrUpdate')->name('addUser');

        Route::get('edit-user/{id?}', 'UsersController@createOrUpdate')->name('editUser');

        Route::post('edit-user-step/{id?}', 'UsersController@createOrUpdate')->name('addUserStep');
        
        Route::get('ajax-pager', 'UsersController@ajaxData')->name('userPager');

        Route::post('store', 'UsersController@store');

        Route::post('update', 'UserController@update');
    });

    Route::group(['prefix' => 'people'], function () {
        Route::get('followers-list', 'FollowersController@index')->name('followersList');

        Route::get('contestants-list', 'ContestantsController@index')->name('contestantsList');
    });

    Route::group(['prefix' => 'zones'], function () {
        Route::get('/', 'ZoneController@index')->name('zonesList');

        Route::get('create-a-zone', 'ZoneController@create')->name('addZone');

        Route::get('edit-a-zone/{id}', 'ZoneController@edit')->name('editZone');

        Route::post('store/{id?}', 'ZoneController@store');

        Route::get('ajax-get-subsequent-zones', 'ZoneController@ajaxFetchLocations')->name('ajaxZones');

        Route::get('ajax-pager', 'ZoneController@ajaxData')->name('zonesPager');
    });

    Route::get('users/{id}', function ($id) {
        
    });
    
    Route::group(['prefix' => 'permissions-list'], function () {
        Route::get('/', 'PermissionController@index');

        Route::get('create-a-permission', 'PermissionController@create');
    });

    // Contests
    Route::group(['prefix' => 'contest', 'middleware' => 'auth'], function () {
        Route::get('/', 'ContestController@index')->name('contestList');

        Route::get('/create', 'ContestController@create')->name('addContest');

        Route::post('/store/{id?}', 'ContestController@store');
    });

    // Templates
    Route::group(['prefix' => 'template'], function () {
        Route::get('/', 'TemplateController@index')->name('templList');
    });
    // Ajax get locations
    Route::get('ajax-get-locations', 'LocationController@ajaxData')->name('getLoc');

    Route::post('/store/{id?}', 'TemplateController@store');
    
});
