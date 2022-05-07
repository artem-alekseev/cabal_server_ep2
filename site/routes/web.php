<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
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

Route::get('/', [HomeController::class, 'index'])->middleware(['auth'])->name('home');
Route::get('/character/{character}/inventory/{item}/edit', [HomeController::class, 'editItem'])->middleware(['auth'])->name('item.edit');
Route::post('/character/{character}/inventory/{item}/save', [HomeController::class, 'saveItem'])->middleware(['auth'])->name('item.save');

Auth::routes();
