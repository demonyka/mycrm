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
    Route::prefix('/staff')->middleware('can:staff')->group(function () {
        Route::get('/list', [StaffController::class, 'listView'])->middleware('can:staff.view.list')->name('staff.view.list');
        Route::get('/list/dismiss', [StaffController::class, 'listDismissView'])->middleware('can:staff.view.dismiss')->name('staff.view.dismiss');

        Route::prefix('/user')->group(function () {
            Route::get('/show/{id}', [StaffController::class, 'userView'])->middleware('can:staff.view')->name('staff.view');
            Route::get('/edit/{id}', [StaffController::class, 'userEditView'])->middleware('can:staff.edit')->name('staff.edit.view');
            Route::post('/edit/{id}', [StaffController::class, 'edit'])->middleware('can:staff.edit')->name('staff.edit');
            Route::post('/edit_tpl/{id}', [StaffController::class, 'editTpl'])->middleware('can:staff.edit')->name('staff.edit.tpl');

            Route::post('/delete/{id}', [StaffController::class, 'delete'])->middleware('can:staff.delete')->name('staff.delete');
            Route::post('/restore/{id}', [StaffController::class, 'restore'])->middleware('can:staff.restore')->name('staff.restore');

            Route::post('/create', [StaffController::class, 'create'])->middleware('can:staff.create')->name('staff.create');
            Route::get('/create', [StaffController::class, 'createView'])->middleware('can:staff.create')->name('staff.view.create');
        });

        Route::prefix('/template')->group(function () {
           Route::get('/list', [StaffController::class, 'templateListView'])->middleware('can:staff.template.view')->name('staff.template.view');
           Route::get('/create', [StaffController::class, 'createTemplateView'])->middleware('can:staff.template.create')->name('staff.template.create.view');
           Route::post('/create', [StaffController::class, 'createTemplate'])->middleware('can:staff.template.create')->name('staff.template.create');
           Route::post('/delete/{id}', [StaffController::class, 'deleteTemplate'])->middleware('can:staff.template.delete')->name('staff.template.delete');
           Route::get('/edit/{id}', [StaffController::class, 'editTemplateView'])->middleware('can:staff.template.edit')->name('staff.template.edit.view');
           Route::post('/edit/{id}/field', [StaffController::class, 'editTemplateFields'])->middleware('can:staff.template.edit')->name('staff.template.edit.field');
           Route::post('/edit/{id}/field/add', [StaffController::class, 'editTemplateAddField'])->middleware('can:staff.template.edit')->name('staff.template.edit.field.add');
           Route::post('/edit/{id}/field/delete', [StaffController::class, 'editTemplateDeleteField'])->middleware('can:staff.template.edit')->name('staff.template.edit.field.delete');

        });
    });
});

require __DIR__.'/auth.php';
