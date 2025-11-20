<?php

namespace Application\Services;

use Domain\Enums\TransactionStatus;
use Domain\Enums\TransactionType;
use Domain\Models\Transaction;
use Infrastructure\Repositories\TransactionRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class TransactionService
{
    public function __construct(private TransactionRepository $transactionRepo)
    {
    }

    public function getUserTransactions(int $userId)
    {
        return $this->transactionRepo->getUserTransactions($userId);
    }

    public function createTransaction(array $data): Transaction
    {
        $attributes = [
            'bank_account_id' => $data['bank_account_id'],
            'transaction_type' => TransactionType::OUTGOING->value,
            'counterparty_account_number' => $data['counterparty_account_number'],
            'counterparty_bank_code' => $data['counterparty_bank_code'] ?? null,
            'vs' => $data['vs'] ?? null,
            'amount' => $data['amount'],
            'currency' => $data['currency'],
            'message' => $data['message'] ?? null,
            'status' => TransactionStatus::PENDING->value,
        ];

        return $this->transactionRepo->create($attributes);
    }


    public function filterTransactions(array $filters): LengthAwarePaginator
    {
        return $this->transactionRepo->filterTransactions($filters);
    }


    public function updateStatus(Transaction $transaction, TransactionStatus $status): void
    {
        $this->transactionRepo->update($transaction, ['status' => $status]);
    }
}
