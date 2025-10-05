<?php

namespace App\Domain\Enums;

enum AccountType: int
{
    case CHECKING = 1;
    case SAVINGS  = 2;

    public function label(): string
    {
        return match($this) {
            self::CHECKING => 'Běžný účet',
            self::SAVINGS => 'Spořící účet',
        };
    }
}
