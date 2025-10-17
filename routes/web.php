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
Route::get('/accounts/{account}', [BankAccountController::class, 'show'])
    ->middleware('account.owner')
    ->name('accounts.show');


Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions');
Route::get('/transactions/create', [TransactionController::class, 'showCreateForm'])->name('transactions.create');
Route::post('/transactions/create', [TransactionController::class, 'create'])->name('transactions.create.post');

Route::get('/cards', [CardController::class, 'index'])->name('cards');
Route::get('cards/{card}', [CardController::class, 'show'])
    ->middleware('card.owner')
    ->name('cards.show');
Route::post('cards/{card}/toggle', [CardController::class, 'toggle'])
    ->middleware('card.owner')
    ->name('cards.toggle');

Route::get('/standing-orders/create', [StandingOrderController::class, 'create'])
    ->name('standing_orders.create');

Route::get('/standing-orders', [StandingOrderController::class, 'index'])
    ->name('standing_orders');

Route::get('/standing-orders/{standingOrder}', [StandingOrderController::class, 'show'])
    ->middleware('standing_order.owner')
    ->name('standing_orders.show');

Route::delete('/standing-orders/{standingOrder}', [StandingOrderController::class, 'destroy'])
    ->middleware('standing_order.owner')
    ->name('standing_orders.destroy');


Route::post('/standing-orders', [StandingOrderController::class, 'store'])
    ->name('standing_orders.store');

Route::get('/loans', [LoanController::class, 'index'])->name('loans');
Route::get('/loans/create', [LoanController::class, 'create'])->name('loans.create');
Route::post('/loans', [LoanController::class, 'store'])->name('loans.store');

Route::get('/loans/{loan}', [LoanController::class, 'show'])
    ->middleware('loan.owner')
    ->name('loans.show');

Route::delete('/loans/{loan}', [LoanController::class, 'destroy'])
    ->middleware('loan.owner')
    ->name('loans.destroy');


Route::get('/', [HomepageController::class, 'homepage'])->name('homepage');
