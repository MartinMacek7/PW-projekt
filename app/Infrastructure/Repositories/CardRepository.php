<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Models\Card;
use \Illuminate\Database\Eloquent\Collection;

class CardRepository
{

    protected $model;

    public function __construct(Card $model)
    {
        $this->model = $model;
    }


    public function getAll(?int $userId = null): Collection
    {
        $cards = $this->model->all();

        if ($userId) {
            $cards = $cards->filter(function ($card) use ($userId) {
                return $card->bankAccount->user_id === $userId;
            });
        }

        return $cards->sortByDesc('created_at');
    }


}
