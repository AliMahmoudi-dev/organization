<?php

use App\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\RegisteredUserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return 'home';
})->middleware('auth')->name('home');

Route::controller(AuthenticatedSessionController::class)
    ->group(function () {
        Route::get('/login', 'create')
            ->middleware('guest')
            ->name('login');

        Route::post('/login', 'store')
            ->middleware('guest')
            ->name('login.store');

        Route::get('/logout', 'destroy')
            ->middleware('auth')
            ->name('logout');
    });

Route::controller(RegisteredUserController::class)
    ->middleware('guest')
    ->group(function () {
        Route::get('/register', 'create')->name('register.create');
        Route::post('/register', 'store')->name('register.store');
    });
