<?php

namespace App\Domain\Enums;

enum TransactionType: int
{

    case DEPOSIT = 1;
    case WITHDRAWAL = 2;
    case OUTGOING = 3;
    case INCOMING = 4;
    case FEE = 5;
    case INTEREST = 6;
    case REVERSAL = 7;

    public function label(): string
    {
        return match($this) {
            self::DEPOSIT => 'Vklad',
            self::WITHDRAWAL => 'Výběr',
            self::OUTGOING => 'Odchozí platba',
            self::INCOMING => 'Příchozí platba',
            self::FEE => 'Poplatek',
            self::INTEREST => 'Úrok',
            self::REVERSAL => 'Storno',
        };
    }
}
