<?php

namespace Application\Services\Interface;

use Domain\Models\BankAccount;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface IBankAccountService
{
    public function filterAccounts(array $filters): LengthAwarePaginator;

    public function getTransactions(BankAccount $bankAccount): Collection;

    public function createAccount(array $data): BankAccount;

    public function deleteAccount(BankAccount $bankAccount): bool;
}
