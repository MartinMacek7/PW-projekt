<?php

namespace Database\Factories;

use App\Domain\Models\Transaction;
use App\Domain\Models\BankAccount;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Domain\Enums\TransactionType;
use App\Domain\Enums\TransactionStatus;

class TransactionFactory extends Factory
{
    protected $model = Transaction::class;

    public function definition(): array
    {
        return [
            'bank_account_id' => BankAccount::inRandomOrder()->first()->id,
            'transaction_type' => $this->faker->randomElement([
                TransactionType::DEPOSIT->value,
                TransactionType::WITHDRAWAL->value,
                TransactionType::OUTGOING->value,
                TransactionType::INCOMING->value,
                TransactionType::FEE->value,
                TransactionType::INTEREST->value,
            ]),
            'counterparty_account_number' => $this->faker->bankAccountNumber(),
            'counterparty_bank_code' => $this->faker->randomNumber(4, true),
            'amount' => $this->faker->randomFloat(2, 50, 50000),
            'currency' => $this->faker->randomElement(['CZK', 'EUR']),
            'vs' => $this->faker->randomNumber(6, true),
            'message' => $this->faker->sentence(),
            'status' => $this->faker->randomElement([
                TransactionStatus::PENDING->value,
                TransactionStatus::COMPLETED->value,
                TransactionStatus::FAILED->value,
            ]),
        ];
    }
}
