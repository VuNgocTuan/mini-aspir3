<?php

use Illuminate\Support\Facades\Route;
use LoanModule\Http\Controllers\LoanUserController;

Route::controller(LoanUserController::class)
    ->middleware('auth:users')
    ->group(function () {
        Route::post('/application', 'apply');
    });
