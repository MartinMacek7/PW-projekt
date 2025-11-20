<?php

namespace Infrastructure\Repositories;

use Domain\Models\StandingOrder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class StandingOrderRepository
{

    public function getAllForUser(int $userId)
    {
        return StandingOrder::with('bankAccount')
            ->whereHas('bankAccount', fn ($query) => $query->where('user_id', $userId))
            ->get();
    }


    public function filter(array $filters): LengthAwarePaginator
    {
        $query = StandingOrder::with(['bankAccount.user']);

        if (!empty($filters['account_number'])) {
            $query->whereHas('bankAccount', fn($q) =>
                $q->where('account_number', 'like', '%' . $filters['account_number'] . '%')
            );
        }

        if (!empty($filters['client_name'])) {
            $query->whereHas('bankAccount.user', function ($q) use ($filters) {
                $q->where('name', 'like', '%' . $filters['client_name'] . '%')
                  ->orWhere('surname', 'like', '%' . $filters['client_name'] . '%');
            });
        }

        return $query->orderByDesc('created_at')->paginate(20);
    }


    public function create(array $attributes): StandingOrder
    {
        return StandingOrder::create($attributes);
    }


    public function delete(StandingOrder $standingOrder): bool
    {
        return $standingOrder->delete();
    }
}
