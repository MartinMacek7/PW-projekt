<?php

namespace Domain\Models;

use Illuminate\Database\Eloquent\Model;
use Domain\Enums\AccountType;
use Domain\Enums\Currency;

/**
 * Class BankAccount
 *
 * @property int $id
 * @property int $user_id
 * @property string $account_number
 * @property AccountType $account_type
 * @property Currency $currency
 * @property float $balance
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class BankAccount extends Model
{

    protected $table = 'bank_accounts';

    protected $fillable = [
        'user_id',
        'account_number',
        'account_type',
        'currency',
        'balance',
    ];


    protected $casts = [
        'account_type' => AccountType::class,
        'currency' => Currency::class
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }


    public function cards()
    {
        return $this->hasOne(Card::class);
    }



    public function getFormattedBalance(): string
    {
        return number_format($this->balance, 2, '.', ' ') . ' ' . $this->currency->value;
    }



}
