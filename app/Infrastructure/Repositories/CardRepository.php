<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Models\Card;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CardRepository
{

    public function getAll(?int $userId = null)
    {
        $query = Card::query()->with('bankAccount.user');

        if ($userId) {
            $query->whereHas('bankAccount', fn($q) => $q->where('user_id', $userId));
        }

        return $query->orderByDesc('created_at')->get();
    }


    public function filter(array $filters): LengthAwarePaginator
    {
        $query = Card::query()->with('bankAccount.user');

        if (!empty($filters['account'])) {
            $query->whereHas('bankAccount', fn($q) =>
                $q->where('account_number', 'like', '%' . $filters['account'] . '%')
            );
        }

        if (!empty($filters['client'])) {
            $query->whereHas('bankAccount.user', function ($q) use ($filters) {
                $q->where('name', 'like', '%' . $filters['client'] . '%')
                  ->orWhere('surname', 'like', '%' . $filters['client'] . '%');
            });
        }

        if (!empty($filters['status'])) {
            $isActive = $filters['status'] === 'active';
            $query->where('is_active', $isActive);
        }

        return $query->orderByDesc('created_at')->paginate(15);
    }


    public function update(Card $card, array $attributes): void
    {
        $card->update($attributes);
    }


    public function create($data): Card {
        return Card::create($data);
    }

}
