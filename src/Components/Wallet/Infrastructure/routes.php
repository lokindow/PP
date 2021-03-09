<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['api'], 'prefix' => 'v1/wallet', 'namespace' => '\Src\Components\Wallet\Infrastructure\Api'], function () {
    Route::post('/transaction', ['uses' => 'WalletController@setTransaction']);
    Route::get('/', ['uses' => 'WalletController@getAllTransaction']);
});


