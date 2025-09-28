<?php

use App\Presentation\Http\Controllers\Client\AuthController;
use App\Presentation\Http\Controllers\Client\BankAccountController;
use App\Presentation\Http\Controllers\Client\CardController;
use App\Presentation\Http\Controllers\Client\HomepageController;
use App\Presentation\Http\Controllers\Client\LoanController;
use App\Presentation\Http\Controllers\Client\ProfileController;
use App\Presentation\Http\Controllers\Client\StandingOrderController;
use App\Presentation\Http\Controllers\Client\TransactionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');


Route::get('/accounts', [BankAccountController::class, 'index'])->name('accounts');
Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions');
Route::get('/cards', [CardController::class, 'index'])->name('cards');
Route::get('/standing-orders', [StandingOrderController::class, 'index'])->name('standing_orders');
Route::get('/loans', [LoanController::class, 'index'])->name('loans');

Route::get('/', [HomepageController::class, 'homepage'])->name('homepage');
