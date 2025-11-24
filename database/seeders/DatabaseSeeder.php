<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Domain\Enums\AccountType;
use Domain\Enums\Currency;
use Domain\Models\BankAccount;
use Domain\Models\Card;
use Domain\Models\Loan;
use Domain\Models\StandingOrder;
use Domain\Models\Transaction;
use Domain\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {


        $user1 = User::create([
            'name' => 'Petr',
            'surname' => 'Novak',
            'email' => 'petr.novak@example.com',
            'birth_number' => '900101/1234',
            'phone_number' => '+420123456789',
            'gender' => 'M',
            'password' => Hash::make('tajneheslo'),
            'address_street' => 'Hlavní',
            'address_number' => '123',
            'address_city' => 'Praha',
            'address_zip_code' => '11000',
        ]);

        $user2 = User::create([
            'name' => 'Martin',
            'surname' => 'Macek',
            'email' => 'macekm7@seznam.cz',
            'birth_number' => '030131/4551',
            'phone_number' => '+420723104754',
            'gender' => 'M',
            'password' => Hash::make('123'),
            'address_street' => 'Humna',
            'address_number' => '192',
            'address_city' => 'Vacenovice',
            'address_zip_code' => '69603',
            'permission_level' => 100
        ]);

        $account1 = BankAccount::create([
            'user_id' => $user2->id,
            'account_number' => '1130985',
            'account_type' => AccountType::CHECKING,
            'currency' => Currency::CZK,
            'balance' => 15800
        ]);


        $account2 = BankAccount::create([
            'user_id' => $user2->id,
            'account_number' => '1130986',
            'account_type' => AccountType::SAVINGS,
            'currency' => Currency::EUR,
            'balance' => 574100
        ]);


        Transaction::factory()->count(10)->create([
            'bank_account_id' => $account1->id,
        ]);


        Transaction::factory()->count(10)->create([
            'bank_account_id' => $account2->id,
        ]);

        Card::create([
            'bank_account_id' => $account1->id,
            'card_number' => '4111111111111111',
            'expire_year' => Carbon::now()->addYears(3)->year,
            'expire_month' => 12,
            'cvv' => '123',
            'is_active' => true,
        ]);

        Card::create([
            'bank_account_id' => $account1->id,
            'card_number' => '4000123412341234',
            'expire_year' => Carbon::now()->addYears(2)->year,
            'expire_month' => 6,
            'cvv' => '321',
            'is_active' => false,
        ]);

        Card::create([
            'bank_account_id' => $account2->id,
            'card_number' => '5555444433332222',
            'expire_year' => Carbon::now()->addYears(4)->year,
            'expire_month' => 11,
            'cvv' => '456',
            'is_active' => true,
        ]);

        Card::create([
            'bank_account_id' => $account2->id,
            'card_number' => '5105105105105100',
            'expire_year' => Carbon::now()->addYears(1)->year,
            'expire_month' => 3,
            'cvv' => '654',
            'is_active' => true,
        ]);

        StandingOrder::factory()->count(4)->create([
            'bank_account_id' => $account1->id,
        ]);

        StandingOrder::factory()->count(3)->create([
            'bank_account_id' => $account2->id,
        ]);


        Loan::create([
            'user_id' => $user1->id,
            'interest_rate' => 5.5,
            'monthly_payment' => 2000,
            'total_balance' => 50000,
            'remaining_balance' => 40000,
        ]);

        Loan::create([
            'user_id' => $user2->id,
            'interest_rate' => 3.9,
            'monthly_payment' => 1500,
            'total_balance' => 30000,
            'remaining_balance' => 15000,
        ]);

    }
}
