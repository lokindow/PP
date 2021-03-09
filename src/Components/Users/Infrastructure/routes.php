<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['api'], 'prefix' => 'v1/user', 'namespace' => '\Src\Components\Users\Infrastructure\Api'], function () {
    Route::post('/save', ['uses' => 'UserController@save']);
    Route::get('/', ['uses' => 'UserController@getAll']);
});


