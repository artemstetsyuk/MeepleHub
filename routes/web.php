<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BoardGameController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;


// Головна сторінка каталогу
Route::get('/', [BoardGameController::class, 'index'])->name('games.index');

// Маршрути для гостей (Вхід / Реєстрація)
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Вихід з акаунту
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Публічний перегляд ігор (Доступно всім)
Route::get('/games', [BoardGameController::class, 'index'])->name('games.index');
Route::get('/games/{game}', [BoardGameController::class, 'show'])->name('games.show');

// Модифікація бази даних (Доступно авторизованим користувачам)
Route::middleware(['auth'])->group(function () {
    Route::get('/games/create/new', [BoardGameController::class, 'create'])->name('games.create');
    Route::post('/games', [BoardGameController::class, 'store'])->name('games.store');
    Route::get('/games/{game}/edit', [BoardGameController::class, 'edit'])->name('games.edit');
    Route::put('/games/{game}', [BoardGameController::class, 'update'])->name('games.update');
    Route::delete('/games/{game}', [BoardGameController::class, 'destroy'])->name('games.destroy');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/checkout', [CartController::class, 'checkout'])->name('checkout.store');
});