<?php

namespace App\Application\Services;

use App\Infrastructure\Repositories\TransactionRepository;
use Illuminate\Database\Eloquent\Collection;

class TransactionService
{


    public function __construct(private TransactionRepository $transactionRepo)
    {
    }


    public function getUserTransactions(int $userId): Collection {
        return $this->transactionRepo->getAll($userId);
    }


}
