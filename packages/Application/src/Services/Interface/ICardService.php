<?php

namespace Application\Services\Interface;

use Domain\Models\Card;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface ICardService
{
    public function getUserCards(int $userId): Collection;

    public function filterCards(array $filters): LengthAwarePaginator;

    public function toggleCard(Card $card): void;
}
