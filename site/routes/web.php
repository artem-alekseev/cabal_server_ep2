<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CharacterController;
use App\Http\Controllers\UserController;
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
    Route::get('/', [UserController::class, 'index'])->middleware(['auth'])->name('home');
    Route::get('user/{user}', [UserController::class, 'edit'])->name('user.edit');
    Route::post('user/{user}/update', [UserController::class, 'update'])->name('user.update');
    Route::get('user/{user}/add-item', [UserController::class, 'addItem'])->name('user.add_item');
    Route::post('user/{user}/send-item',  [UserController::class, 'sendItem'])->name('user.send_item');
    Route::get('/character/{character}', [CharacterController::class, 'index'])->name('character.index');
    Route::get('/character/{character}/edit', [CharacterController::class, 'edit'])->name('character.edit');
    Route::post('/character/{character}/update', [CharacterController::class, 'update'])->name('character.update');
    Route::get('/character/{character}/inventory/{position}/edit', [CharacterController::class, 'editItem'])->name('item.edit');
    Route::post('/character/{character}/inventory/{position}/save', [CharacterController::class, 'saveItem'])->name('item.save');
    Route::get('/character/{character}/skill/edit', [CharacterController::class, 'editSkill'])->name('skill.edit');
    Route::post('/character/{character}/skill/save', [CharacterController::class, 'saveSkill'])->name('skill.save');
});


