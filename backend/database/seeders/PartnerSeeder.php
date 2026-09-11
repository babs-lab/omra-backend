<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Partner;

class PartnerSeeder extends Seeder
{
    public function run(): void
    {
        Partner::firstOrCreate(['name' => 'Air France'], ['url' => 'https://www.airfrance.fr', 'position' => 1, 'is_active' => true]);
        Partner::firstOrCreate(['name' => 'Saudi Airlines'], ['url' => 'https://www.saudia.com', 'position' => 2, 'is_active' => true]);
        Partner::firstOrCreate(['name' => 'Atlas Voyages'], ['url' => 'https://www.atlas-voyages.example', 'position' => 3, 'is_active' => true]);
        Partner::firstOrCreate(['name' => 'Turismo Seniors'], ['url' => null, 'position' => 4, 'is_active' => false]);
    }
}
