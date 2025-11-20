<?php

namespace Domain\Models;

use Domain\Enums\Currency;
use Domain\Enums\PaymentFrequency;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * Class StandingOrder
 *
 * @property int $id
 * @property int $bank_account_id
 * @property string $counterpart_account_number
 * @property string $counterpart_bank_code
 * @property float $amount
 * @property Currency $currency
 * @property PaymentFrequency $frequency
 * @property \Carbon\Carbon $start_date
 * @property \Carbon\Carbon|null $end_date
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class StandingOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'bank_account_id',
        'counterpart_account_number',
        'counterpart_bank_code',
        'amount',
        'currency',
        'frequency',
        'start_date',
        'end_date',
    ];


    protected $casts = [
        'currency' => Currency::class,
        'frequency' => PaymentFrequency::class
    ];


    protected static function newFactory()
    {
        return \Database\Factories\StandingOrderFactory::new();
    }


    public function bankAccount()
    {
        return $this->belongsTo(BankAccount::class);
    }

    public function getBankAccount(): ?BankAccount
    {
        return $this->bankAccount()->first();
    }
}
