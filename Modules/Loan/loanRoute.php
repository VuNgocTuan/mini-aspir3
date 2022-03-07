<?php

use Illuminate\Support\Facades\Route;
use LoanModule\Http\Controllers\LoanBankUserController;
use LoanModule\Http\Controllers\LoanUserController;

Route::controller(LoanUserController::class)
    ->middleware('auth:users')
    ->prefix('/applications')
    ->group(function () {
        Route::post('/', 'apply');
        Route::get('/', 'getLoanApplicationList');
        Route::post('/{id}/repay', 'repay');
    });

Route::controller(LoanBankUserController::class)
    ->middleware('auth:bankUsers')
    ->prefix('/banker/applications')
    ->group(function () {
        Route::post('/apply', 'apply');
        Route::get('/', 'getLoanApplicationList');
    });
