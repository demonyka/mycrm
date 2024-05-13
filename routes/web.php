<?php

use App\Http\Controllers\IndexController;
use App\Http\Controllers\Staff\StaffController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('auth')->group(function () {
    Route::get('/', [IndexController::class, 'view'])->name('index.view');
    Route::prefix('staff')->middleware('can:staff')->group(function () {
        Route::get('/list', [StaffController::class, 'listView'])->middleware('can:staff.view.list')->name('staff.view.list');
        Route::get('/list/dismiss', [StaffController::class, 'listDismissView'])->middleware('can:staff.view.dismiss')->name('staff.view.dismiss');
        Route::get('/create', [StaffController::class, 'createView'])->middleware('can:staff.create')->name('staff.view.create');
        Route::post('/create', [StaffController::class, 'create'])->middleware('can:staff.create')->name('staff.create');
        Route::post('/delete/{id}', [StaffController::class, 'delete'])->middleware('can:staff.delete')->name('staff.delete');
        Route::post('/restore/{id}', [StaffController::class, 'restore'])->middleware('can:staff.restore')->name('staff.restore');
    });
});

require __DIR__.'/auth.php';
