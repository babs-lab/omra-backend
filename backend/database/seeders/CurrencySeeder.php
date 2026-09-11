<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Currency;

class CurrencySeeder extends Seeder
{
    public function run(): void
    {
        Currency::firstOrCreate(
            ['code' => 'EUR'],
            ['name' => 'Euro', 'symbol' => '€', 'exchange_rate' => 1.0, 'is_active' => true]
        );

        Currency::firstOrCreate(
            ['code' => 'USD'],
            ['name' => 'Dollar américain', 'symbol' => '$', 'exchange_rate' => 1.08, 'is_active' => true]
        );
    }
}
