<?php

use Presentation\Http\Controllers\Admin\AdminBankAccountController;
use Presentation\Http\Controllers\Admin\AdminCardController;
use Presentation\Http\Controllers\Admin\AdminLoanController;
use Presentation\Http\Controllers\Admin\AdminStandingOrderController;
use Presentation\Http\Controllers\Admin\AdminTransactionController;
use Presentation\Http\Controllers\Admin\AdminUserController;
use Presentation\Http\Controllers\Client\AuthController;
use Presentation\Http\Controllers\Client\BankAccountController;
use Presentation\Http\Controllers\Client\CardController;
use Presentation\Http\Controllers\Client\HomepageController;
use Presentation\Http\Controllers\Client\LoanController;
use Presentation\Http\Controllers\Client\ProfileController;
use Presentation\Http\Controllers\Client\StandingOrderController;
use Presentation\Http\Controllers\Client\TransactionController;
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

// client routes

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


// admin routes

Route::prefix('admin')->name('admin.')->group(function() {
    Route::get('clients', [\Presentation\Http\Controllers\Admin\AdminClientController::class, 'index'])->name('clients.index');
    Route::get('clients/{client}/edit', [\Presentation\Http\Controllers\Admin\AdminClientController::class, 'edit'])->name('clients.edit');
    Route::put('clients/{client}', [\Presentation\Http\Controllers\Admin\AdminClientController::class, 'update'])->name('clients.update');
});

Route::prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('bank-accounts', [AdminBankAccountController::class, 'index'])
            ->name('bank_accounts.index');

        Route::get('bank_accounts/create', [AdminBankAccountController::class, 'create'])->name('bank_accounts.create');

        Route::post('bank_accounts', [AdminBankAccountController::class, 'store'])->name('bank_accounts.store');

        Route::get('bank-accounts/{bankAccount}', [AdminBankAccountController::class, 'show'])
            ->name('bank_accounts.show');

        Route::delete('bank-accounts/{bankAccount}', [AdminBankAccountController::class, 'destroy'])
            ->name('bank_accounts.destroy');
});


Route::prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('transactions', [AdminTransactionController::class, 'index'])->name('transactions.index');
        Route::get('transactions/{transaction}', [AdminTransactionController::class, 'show'])->name('transactions.show');
        Route::post('transactions/{transaction}/block', [AdminTransactionController::class, 'block'])->name('transactions.block');
        Route::post('transactions/{transaction}/unblock', [AdminTransactionController::class, 'unblock'])->name('transactions.unblock');
        Route::post('transactions/{transaction}/cancel', [AdminTransactionController::class, 'cancel'])->name('transactions.cancel');
    });

Route::prefix('admin')
    ->name('admin.cards.')
    ->group(function () {
        Route::get('/cards', [AdminCardController::class, 'index'])->name('index');
        Route::get('/cards/{card}', [AdminCardController::class, 'show'])->name('show');
        Route::post('/cards/{card}/toggle', [AdminCardController::class, 'toggle'])->name('toggle');
    });


Route::prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('standing-orders', [AdminStandingOrderController::class, 'index'])
            ->name('standing_orders.index');

        Route::get('standing-orders/{standingOrder}', [AdminStandingOrderController::class, 'show'])
            ->name('standing_orders.show');

        Route::delete('standing-orders/{standingOrder}', [AdminStandingOrderController::class, 'destroy'])
            ->name('standing_orders.destroy');
    });


Route::prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('loans', [AdminLoanController::class, 'index'])
            ->name('loans.index');

        Route::get('loans/{loan}', [AdminLoanController::class, 'show'])
            ->name('loans.show');

        Route::post('loans/{loan}/approve', [AdminLoanController::class, 'approve'])
            ->name('loans.approve');

        Route::delete('loans/{loan}', [AdminLoanController::class, 'destroy'])
            ->name('loans.destroy');
    });


Route::prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('users', [AdminUserController::class, 'index'])
            ->name('users.index');

        Route::delete('users/{user}', [AdminUserController::class, 'destroy'])
            ->name('users.destroy');

        Route::post('users/{user}/role', [AdminUserController::class, 'updateRole'])
            ->name('users.updateRole');

    });

Route::get('/', [HomepageController::class, 'homepage'])->name('homepage');
