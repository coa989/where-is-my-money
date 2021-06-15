<?php

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
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware('auth')->prefix('expenses')->group(function () {
    Route::get('/home', [App\Http\Controllers\ExpenseController::class, 'index'])->name('expenses');
    Route::get('/structure', [App\Http\Controllers\ExpenseController::class, 'structure'])->name('structure.total');
    Route::get('/structure/{days}', [App\Http\Controllers\ExpenseController::class, 'structureByDays'])->where('days', '[0-9]+')->name('structure.days');
    Route::post('/store', [App\Http\Controllers\ExpenseController::class, 'store'])->name('expense.store');
    Route::get('/create', [App\Http\Controllers\ExpenseController::class, 'create'])->middleware('create.expense')->name('expense.create');
});

Route::middleware( 'auth')->prefix('account')->group(function () {
    Route::get('/create', [\App\Http\Controllers\AccountController::class, 'create'])->name('account.create');
    Route::post('/store', [\App\Http\Controllers\AccountController::class, 'store'])->name('account.store');
    Route::middleware('owner')->group(function () {
        Route::get('/{account}/show', [\App\Http\Controllers\AccountController::class, 'show'])->name('account.show');
        Route::get('/{account}/edit', [\App\Http\Controllers\AccountController::class, 'edit'])->name('account.edit');
        Route::put('/{account}/update', [\App\Http\Controllers\AccountController::class, 'update'])->name('account.update');
        Route::delete('/{account}/destroy', [\App\Http\Controllers\AccountController::class, 'destroy'])->name('account.destroy');
    });
});
