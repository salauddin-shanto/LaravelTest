<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TransactionController;


Route::get('/register', [UserController::class, 'index']);

Route::post('/user', [UserController::class, 'register'])->name('user');

Route::get('/login', [UserController::class, 'loginForm']);

Route::post('/login', [UserController::class, 'login'])->name('login');

Route::get('/', [TransactionController::class, 'index']);

Route::get('/makeDeposit', [TransactionController::class, 'makeDeposit'])->name('makeDeposit');
Route::get('/deposit', [TransactionController::class, 'showDeposits'])->name('deposit');


Route::post('/deposit', [TransactionController::class, 'deposit']);

Route::get('/makeWithdrawal', [TransactionController::class, 'makeWithdrawal']);

Route::get('/withdrawal', [TransactionController::class, 'showWithdrawals'])->name('withdrawal');

// Accept the user ID and amount, and update the user's balance by deducting the withdrawn amount
Route::post('/withdrawal', [TransactionController::class, 'processWithdrawal']);
