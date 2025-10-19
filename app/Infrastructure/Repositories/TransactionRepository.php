<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Models\Transaction;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class TransactionRepository
{

    public function getUserTransactions(int $userId)
    {
        return Transaction::whereHas('bankAccount', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->get();
    }


    public function create(array $attributes): Transaction
    {
        return Transaction::create($attributes);
    }


    public function filterTransactions(array $filters): LengthAwarePaginator
    {
        $query = Transaction::query()->with(['bankAccount.user']);

        if (!empty($filters['client'])) {
            $query->whereHas('bankAccount.user', function ($q) use ($filters) {
                $q->where('name', 'like', "%{$filters['client']}%")
                  ->orWhere('surname', 'like', "%{$filters['client']}%");
            });
        }

        if (!empty($filters['account_number'])) {
            $query->whereHas('bankAccount', fn($q) =>
                $q->where('account_number', 'like', "%{$filters['account_number']}%"));
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['transaction_type'])) {
            $query->where('transaction_type', $filters['transaction_type']);
        }

        if (!empty($filters['amount_min'])) {
            $query->where('amount', '>=', $filters['amount_min']);
        }

        if (!empty($filters['amount_max'])) {
            $query->where('amount', '<=', $filters['amount_max']);
        }

        return $query->orderBy('created_at', 'desc')->paginate(20);
    }


    public function update(Transaction $transaction, array $attributes): void
    {
        $transaction->update($attributes);
    }

}
