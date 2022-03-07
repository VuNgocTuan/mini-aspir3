<?php
use Illuminate\Support\Facades\Route;
use UserModule\Http\Controllers\AuthController;

Route::controller(AuthController::class)->group(function (){
    Route::post('/auth', 'authenticate');
});