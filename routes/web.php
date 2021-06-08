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

Auth::routes();
// TODO create middleware group
Route::get('/home', [App\Http\Controllers\ExpenseController::class, 'index'])->middleware('auth')->name('home');
Route::get('/create', [App\Http\Controllers\ExpenseController::class, 'create'])->middleware('auth')->name('create');
Route::post('/store', [App\Http\Controllers\ExpenseController::class, 'store'])->middleware('auth')->name('store');


