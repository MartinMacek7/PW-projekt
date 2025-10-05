<?php

namespace App\Application\Services;

use App\Domain\Models\Card;
use App\Infrastructure\Repositories\CardRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class CardService
{


    public function __construct(private CardRepository $cardRepo)
    {
    }


    public function getUserCards(int $userId): Collection {
        return $this->cardRepo->getAll($userId);
    }


}
