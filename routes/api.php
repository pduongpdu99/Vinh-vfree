<?php

use Illuminate\Support\Facades\Route;

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('signin', 'AuthControler@login');
    Route::post('signup', 'AuthControler@registry');
    Route::post('signout', 'AuthControler@logout');
    // Route::post('me', 'AuthControler@me');
});
