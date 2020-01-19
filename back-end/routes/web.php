<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::prefix('api')->group(function() {

    Route::resource('tag', 'TagController')->only(['index', 'show']);

    Route::middleware('auth')->group(function() {

        Route::get('profile', 'UserController@profile');

        Route::post('logout', 'Auth\LoginController@logout');

        Route::middleware('admin')->group(function() {

            Route::resource('tag', 'TagController')->only(['store', 'update', 'destroy']);

        });

    });

});

Auth::routes();
