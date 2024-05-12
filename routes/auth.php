<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

Route::prefix('/auth')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', [LoginController::class, 'view'])->name('auth.login.view');
        Route::post('/login', [LoginController::class, 'store'])->name('auth.login.store');
    });

    Route::middleware('auth')->group(function () {
        Route::get('/logout', [LoginController::class, 'logout'])->name('auth.logout');
    });
});
