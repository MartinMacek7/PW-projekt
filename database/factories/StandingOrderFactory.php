<?php

namespace Database\Factories;

use App\Domain\Enums\PaymentFrequency;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Domain\Models\StandingOrder;

class StandingOrderFactory extends Factory
{
    protected $model = StandingOrder::class;

    public function definition(): array
    {
        return [
            'counterpart_account_number' => $this->faker->bankAccountNumber(),
            'counterpart_bank_code' => (string) $this->faker->numberBetween(1000, 9999),
            'amount' => $this->faker->randomFloat(2, 100, 5000),
            'currency' => $this->faker->randomElement(['CZK', 'EUR', 'USD']),
            'frequency' => $this->faker->randomElement([
                PaymentFrequency::DAILY->value,
                PaymentFrequency::MONTHLY->value,
                PaymentFrequency::WEEKLY->value,
            ]),
            'start_date' => $this->faker->dateTimeBetween('now', '+1 week'),
            'end_date' => $this->faker->optional()->dateTimeBetween('+2 months', '+1 year'),
        ];
    }

}
