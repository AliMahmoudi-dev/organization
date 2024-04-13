<?php

use App\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\RegisteredUserController;
use App\Models\Category;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;

Route::get('/test', function () {
    $user = User::where('id', 1)->first();

    dd(Gate::allows('view-all-invoices'));
});

Route::get('/', IndexController::class)->middleware('auth')->name('home');

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

Route::controller(InvoiceController::class)
    ->middleware('auth')
    ->group(function () {
        Route::get('/invoices', 'index')->name('invoices.index');
        Route::get('/invoices/create', 'create')->name('invoices.create');
        Route::post('/invoices', 'store')->name('invoices.store');
        Route::get('/invoices/{invoice}/delete', 'delete')->name('invoices.delete');
        Route::get('/invoices/{invoice}/confirm', 'confirm')->name('invoices.confirm');
        Route::get('/invoices/{invoice}/reject', 'reject')->name('invoices.reject');
        Route::get('/invoices/{invoice}/download-attached-file', 'downloadAttachedFile')->name('invoices.download-file');
    });
