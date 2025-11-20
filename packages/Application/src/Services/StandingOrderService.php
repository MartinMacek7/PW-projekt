<?php

namespace Application\Services;

use Domain\Models\StandingOrder;
use Infrastructure\Repositories\StandingOrderRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class StandingOrderService
{
    public function __construct(private StandingOrderRepository $standingOrderRepository) {}


    public function getUserStandingOrders(int $userId)
    {
        return $this->standingOrderRepository->getAllForUser($userId);
    }


    public function filterStandingOrders(array $filters): LengthAwarePaginator
    {
        return $this->standingOrderRepository->filter($filters);
    }


    public function createStandingOrder(int $userId, array $data): StandingOrder
    {
        return $this->standingOrderRepository->create([
            'user_id' => $userId,
            ...$data,
        ]);
    }


    public function deleteStandingOrder(StandingOrder $standingOrder): bool
    {
        return $this->standingOrderRepository->delete($standingOrder);
    }
}
