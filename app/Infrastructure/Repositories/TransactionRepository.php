<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Models\Transaction;
use App\Domain\Models\User;
use \Illuminate\Database\Eloquent\Collection;

class TransactionRepository
{

    protected $model;

    public function __construct(Transaction $model)
    {
        $this->model = $model;
    }


    public function getAll(?int $userId = null): Collection
    {
        $transactions = $this->model->all();

        if ($userId) {
            $transactions = $transactions->filter(function ($transaction) use ($userId) {
                return $transaction->bankAccount->user_id === $userId;
            });
        }

        return $transactions->sortByDesc('created_at');
    }


}
