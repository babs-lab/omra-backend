<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MenuItem;

class MenuItemSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['label' => 'Accueil',        'route' => '/',                     'position' => 1],
            ['label' => 'Omra 2026-2027', 'route' => '/omra',                'position' => 2],
            ['label' => 'Ramadan 2027',   'route' => '/blog/ramadan-2027',    'position' => 3],
            ['label' => 'Blog',           'route' => '/blog',                'position' => 4],
            ['label' => 'Témoignages',    'route' => '/temoignages',         'position' => 5],
            ['label' => 'Contact',        'route' => '/contact',             'position' => 6],
        ];

        foreach ($items as $item) {
            $existing = MenuItem::where('route', $item['route'])->first();
            if ($existing) {
                $existing->update(['label' => $item['label'], 'position' => $item['position'], 'is_active' => true]);
            } else {
                MenuItem::create([...$item, 'is_active' => true]);
            }
        }
    }
}
