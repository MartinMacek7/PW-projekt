<?php

namespace App\Domain\Models;

use App\Domain\Enums\Currency;
use App\Domain\Enums\TransactionStatus;
use App\Domain\Enums\TransactionType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Transaction
 *
 * @property int $id
 * @property int $bank_account_id
 * @property int $transaction_type
 * @property string $counterparty_account_number
 * @property string|null $counterparty_bank_code
 * @property float $amount
 * @property string $currency
 * @property string|null $vs
 * @property string|null $message
 * @property int $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Transaction extends Model
{

    use HasFactory;

    protected $fillable = [
        'bank_account_id',
        'transaction_type',
        'counterparty_account_number',
        'counterparty_bank_code',
        'amount',
        'currency',
        'vs',
        'message',
        'status',
    ];


    protected $casts = [
        'transaction_type' => TransactionType::class,
        'currency' => Currency::class,
        'status' => TransactionStatus::class
    ];


    protected static function newFactory()
    {
        return \Database\Factories\TransactionFactory::new();
    }


    public function bankAccount()
    {
        return $this->belongsTo(BankAccount::class);
    }






}
