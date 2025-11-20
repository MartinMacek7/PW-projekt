<?php

namespace App\Providers;

use Application\Services\Implementation\AuthService;
use Application\Services\Implementation\BankAccountService;
use Application\Services\Implementation\CardService;
use Application\Services\Implementation\LoanService;
use Application\Services\Implementation\StandingOrderService;
use Application\Services\Implementation\TransactionService;
use Application\Services\Implementation\UserService;
use Application\Services\Interface\IAuthService;
use Application\Services\Interface\IBankAccountService;
use Application\Services\Interface\ICardService;
use Application\Services\Interface\ILoanService;
use Application\Services\Interface\IStandingOrderService;
use Application\Services\Interface\ITransactionService;
use Application\Services\Interface\IUserService;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(IAuthService::class, AuthService::class);
        $this->app->bind(IBankAccountService::class, BankAccountService::class);
        $this->app->bind(ICardService::class, CardService::class);
        $this->app->bind(ILoanService::class, LoanService::class);
        $this->app->bind(IStandingOrderService::class, StandingOrderService::class);
        $this->app->bind(ITransactionService::class, TransactionService::class);
        $this->app->bind(IUserService::class, UserService::class);


    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::addLocation(app_path('Presentation/Views'));
    }
}
