<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\SiteSettings;
use Illuminate\Database\Eloquent\Model;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Fields\Text;

class SiteSettingsResource extends ModelResource
{
    protected string $model = SiteSettings::class;

    protected string $title = 'Paramètres du site';

    private const SOCIAL_PLATFORMS = [
        'email' => 'Email',
        'phone' => 'Téléphone',
        'facebook' => 'Facebook',
        'instagram' => 'Instagram',
        'twitter' => 'Twitter / X',
        'whatsapp' => 'WhatsApp',
        'youtube' => 'YouTube',
        'linkedin' => 'LinkedIn',
        'tiktok' => 'TikTok',
        'telegram' => 'Telegram',
        'snapchat' => 'Snapchat',
        'pinterest' => 'Pinterest',
        'twitch' => 'Twitch',
        'discord' => 'Discord',
        'github' => 'GitHub',
    ];

    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
            Text::make('Clé', 'key'),
            Text::make('Valeur', 'value'),
        ];
    }

    protected function formFields(): iterable
    {
        return [
            Box::make([
                ID::make(),
                Select::make('Clé', 'key')
                    ->options(self::SOCIAL_PLATFORMS)
                    ->required(),
                Text::make('Valeur', 'value')
                    ->placeholder('URL ou valeur du paramètre'),
            ]),
        ];
    }

    protected function detailFields(): iterable
    {
        return [
            ID::make(),
            Text::make('Clé', 'key'),
            Text::make('Valeur', 'value'),
        ];
    }

    protected function search(): array
    {
        return ['key', 'value'];
    }
}
