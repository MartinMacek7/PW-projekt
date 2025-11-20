<?php

namespace Application\Services\Interface;

use Domain\Models\StandingOrder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface IStandingOrderService
{
    public function getUserStandingOrders(int $userId): Collection|array;

    public function filterStandingOrders(array $filters): LengthAwarePaginator;

    public function createStandingOrder(int $userId, array $data): StandingOrder;

    public function deleteStandingOrder(StandingOrder $standingOrder): bool;
}
