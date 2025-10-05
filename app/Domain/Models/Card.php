<?php

namespace App\Domain\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory;

    protected $fillable = [
        'bank_account_id',
        'card_number',
        'expire_year',
        'expire_month',
        'cvv',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'expire_year' => 'integer',
        'expire_month' => 'integer',
    ];

    public function bankAccount()
    {
        return $this->belongsTo(BankAccount::class);
    }
}
