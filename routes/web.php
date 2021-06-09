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

Route::middleware('auth')->group(function () {
    Route::get('/home', [App\Http\Controllers\ExpenseController::class, 'index'])->name('home');
    Route::get('/create', [App\Http\Controllers\ExpenseController::class, 'create'])->name('create');
    Route::get('/structure', [App\Http\Controllers\ExpenseController::class, 'structure'])->name('total-structure');
    Route::get('/structure/{days}', [App\Http\Controllers\ExpenseController::class, 'structureByDays'])->name('days-structure');
    Route::post('/store', [App\Http\Controllers\ExpenseController::class, 'store'])->name('store');
});


