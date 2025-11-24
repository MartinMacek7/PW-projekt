<?php

namespace Application\Services\Interface;

use Domain\Models\BankAccount;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Response;

interface IBankAccountService
{
    public function filterAccounts(array $filters): LengthAwarePaginator;

    public function getTransactions(BankAccount $bankAccount): Collection;

    public function createAccount(array $data): BankAccount;

    public function deleteAccount(BankAccount $bankAccount): bool;

    public function generatePdf(BankAccount $account): Response;

}
