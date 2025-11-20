<?php

namespace Application\Services\Implementation;

use Application\Services\Interface\ICardService;
use Domain\Models\Card;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Infrastructure\Repositories\CardRepository;

class CardService implements ICardService
{
    public function __construct(private CardRepository $cardRepo)
    {}

    public function getUserCards(int $userId): Collection
    {
        return $this->cardRepo->getAll($userId);
    }

    public function filterCards(array $filters): LengthAwarePaginator
    {
        return $this->cardRepo->filter($filters);
    }

    public function toggleCard(Card $card): void
    {
        $this->cardRepo->update($card, ['is_active' => !$card->is_active]);
    }
}
