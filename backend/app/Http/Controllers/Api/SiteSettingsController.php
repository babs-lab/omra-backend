<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SiteSettings;
use Illuminate\Http\JsonResponse;

class SiteSettingsController extends Controller
{
    private const SOCIAL_PLATFORMS = [
        'facebook', 'instagram', 'twitter', 'whatsapp',
        'youtube', 'linkedin', 'tiktok', 'telegram',
        'snapchat', 'pinterest', 'twitch', 'discord', 'github',
    ];

    public function index(): JsonResponse
    {
        $settings = SiteSettings::pluck('value', 'key')->toArray();

        $socialLinks = [];
        foreach (self::SOCIAL_PLATFORMS as $platform) {
            $url = $settings[$platform] ?? null;
            if ($url) {
                $socialLinks[] = [
                    'platform' => $platform,
                    'url' => $url,
                ];
            }
        }

        return response()->json([
            'email' => $settings['email'] ?? null,
            'phone' => $settings['phone'] ?? null,
            'facebook' => $settings['facebook'] ?? null,
            'instagram' => $settings['instagram'] ?? null,
            'twitter' => $settings['twitter'] ?? null,
            'whatsapp' => $settings['whatsapp'] ?? null,
            'social_links' => $socialLinks,
        ]);
    }
}
