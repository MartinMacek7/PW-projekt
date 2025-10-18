<?php

namespace App\Domain\Enums;

enum UserRole: int
{
    case ADMIN = 99;
    case BANKER = 2;
    case CLIENT = 1;

    public function label(): string
    {
        return match($this) {
            self::ADMIN => 'Administrátor banky',
            self::BANKER => 'Pracovník banky',
            self::CLIENT => 'Klient',
        };
    }
}
