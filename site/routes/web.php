<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CharacterController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CashShopController;
use App\Http\Controllers\Auth\LoginController;
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

Route::get('/', [LoginController::class, 'apiAuth']);

Route::prefix('cashshop')->name('cashshop.')->group(function () {
    Route::get('/login', [CashShopController::class, 'login'])->name('login');
    Route::middleware('auth')->group(function() {
        Route::get('index', [CashShopController::class, 'index'])->name('index');
        Route::get('view', [CashShopController::class, 'view'])->name('view');
        Route::post('deposit', [CashShopController::class, 'deposit'])->name('deposit');
        Route::post('withdraw', [CashShopController::class, 'withdraw'])->name('withdraw');
        Route::get('buy', [CashShopController::class, 'buy'])->name('buy');
    });
});

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('home');

    Route::prefix('user')->name('user.')->group(function() {
        Route::get('{user}', [UserController::class, 'edit'])->name('edit');
        Route::post('{user}/update', [UserController::class, 'update'])->name('update');
        Route::get('{user}/add-item', [UserController::class, 'addItem'])->name('add_item');
        Route::post('{user}/send-item',  [UserController::class, 'sendItem'])->name('send_item');
    });

    Route::prefix('character')->group(function () {
        Route::get('{character}', [CharacterController::class, 'index'])->name('character.index');
        Route::get('{character}/edit', [CharacterController::class, 'edit'])->name('character.edit');
        Route::post('{character}/update', [CharacterController::class, 'update'])->name('character.update');
        Route::get('{character}/inventory/{position}/edit', [CharacterController::class, 'editItem'])->name('item.edit');
        Route::post('{character}/inventory/{position}/save', [CharacterController::class, 'saveItem'])->name('item.save');
        Route::get('{character}/skill/edit', [CharacterController::class, 'editSkill'])->name('skill.edit');
        Route::post('{character}/skill/save', [CharacterController::class, 'saveSkill'])->name('skill.save');
    });

    Route::prefix('cashshop')->name('admin.cashshop.')->group(function() {
        Route::get('', [CashShopController::class, 'itemList'])->name('list');
        Route::get('create', [CashShopController::class, 'create'])->name('create');
        Route::post('store', [CashShopController::class, 'store'])->name('store');
        Route::get('{shopItem}/edit', [CashShopController::class, 'edit'])->name('edit');
        Route::post('{shopItem}/update', [CashShopController::class, 'update'])->name('update');
        Route::post('{shopItem}/delete', [CashShopController::class, 'delete'])->name('delete');
    });
});


