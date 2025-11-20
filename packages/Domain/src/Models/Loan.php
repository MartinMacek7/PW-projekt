<?php

namespace Domain\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Loan
 *
 * @property int $id
 * @property int $user_id
 * @property float $interest_rate
 * @property float $monthly_payment
 * @property float $remaining_balance
 * @property float $total_balance
 * @property bool $approved
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @property-read User $user
 */
class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'interest_rate',
        'monthly_payment',
        'remaining_balance',
        'total_balance',
        'approved',
    ];

    protected $casts = [
        'interest_rate' => 'float',
        'monthly_payment' => 'float',
        'remaining_balance' => 'float',
        'total_balance' => 'float',
        'approved' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getFormattedBalance(): string
    {
        return number_format($this->remaining_balance, 2, '.', ' ') . ' Kč';
    }
}
