<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SiteSettings;

class SiteSettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            'email' => 'contact@omra.fr',
            'phone' => '+33 1 23 45 67 89',
            'facebook' => null,
            'instagram' => null,
            'twitter' => null,
            'whatsapp' => null,
            'youtube' => null,
            'linkedin' => null,
            'tiktok' => null,
            'telegram' => null,
            'snapchat' => null,
            'pinterest' => null,
            'twitch' => null,
            'discord' => null,
            'github' => null,
        ];

        foreach ($settings as $key => $value) {
            SiteSettings::updateOrCreate(['key' => $key], ['value' => $value]);
        }
    }
}
