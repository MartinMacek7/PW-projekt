<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Models\BankAccount;
use App\Domain\Models\Card;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class BankAccountRepository
{

    public function __construct(private CardRepository $cardRepository)
    {}

    public function filter(array $filters): LengthAwarePaginator
    {
        $query = BankAccount::query()->with('user');

        if (!empty($filters['account_number'])) {
            $query->where('account_number', 'like', '%' . $filters['account_number'] . '%');
        }

        if (!empty($filters['user_name'])) {
            $query->whereHas('user', function ($q) use ($filters) {
                $q->where('name', 'like', '%' . $filters['user_name'] . '%')
                  ->orWhere('surname', 'like', '%' . $filters['user_name'] . '%');
            });
        }

        return $query->orderByDesc('id')->paginate(15);
    }


    public function getTransactions(BankAccount $bankAccount)
    {
        return $bankAccount->transactions()->orderByDesc('created_at')->get();
    }


    public function create(array $data): BankAccount
    {
        return BankAccount::create($data);
    }


    public function delete(BankAccount $bankAccount): bool
    {
        return $bankAccount->delete();
    }


    public function getMaxAccountNumber(): ?int
    {
        return BankAccount::max('account_number');
    }


    public function createCard(BankAccount $bankAccount, array $data): Card
    {
        $data['bank_account_id'] = $bankAccount->id;
        return $this->cardRepository->create($data);
    }


    public function cardNumberExists(string $number): bool
    {
        return Card::where('card_number', $number)->exists();
    }
}
