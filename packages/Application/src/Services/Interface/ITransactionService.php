<?php

namespace Application\Services\Interface;

use Domain\Enums\TransactionStatus;
use Domain\Models\Transaction;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface ITransactionService
{
    public function getUserTransactions(int $userId): Collection;

    public function createTransaction(array $data): Transaction;

    public function filterTransactions(array $filters): LengthAwarePaginator;

    public function updateStatus(Transaction $transaction, TransactionStatus $status): void;
}
