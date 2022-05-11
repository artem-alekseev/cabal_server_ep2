<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CharacterController;
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

Route::middleware(['auth'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->middleware(['auth'])->name('home');
    Route::get('/character/{character}', [CharacterController::class, 'index'])->name('character.index');
    Route::get('/character/{character}/inventory/{position}/edit', [CharacterController::class, 'editItem'])->name('item.edit');
    Route::post('/character/{character}/inventory/{position}/save', [CharacterController::class, 'saveItem'])->name('item.save');
});


