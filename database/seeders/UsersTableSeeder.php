<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
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
            'remember_token' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
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
            'remember_token' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
