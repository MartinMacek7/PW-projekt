<?php

namespace Domain\Enums;

enum PaymentFrequency: int
{
    case DAILY = 1;
    case WEEKLY = 2;
    case MONTHLY = 3;

    public function label(): string
    {
        return match($this) {
            self::DAILY => 'Denně',
            self::WEEKLY => 'Týdně',
            self::MONTHLY => 'Měsíčně',
        };
    }

}
