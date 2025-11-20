<?php

namespace Application\Services\Implementation;

use Application\Services\Interface\IStandingOrderService;
use Domain\Models\StandingOrder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Infrastructure\Repositories\StandingOrderRepository;

class StandingOrderService implements IStandingOrderService
{
    public function __construct(private StandingOrderRepository $standingOrderRepository) {}


    public function getUserStandingOrders(int $userId): Collection|array
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
