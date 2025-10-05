<?php

namespace App\Domain\Enums;

enum TransactionStatus: int
{
    case PENDING = 1;
    case COMPLETED = 2;
    case FAILED = 3;
    case CANCELLED = 4;
    case BLOCKED = 5;

    public function label(): string
    {
        return match($this) {
            self::PENDING   => 'Čeká na zpracování',
            self::COMPLETED => 'Dokončeno',
            self::FAILED    => 'Neúspěšné',
            self::CANCELLED => 'Stornováno',
            self::BLOCKED   => 'Blokováno',
        };
    }
}
