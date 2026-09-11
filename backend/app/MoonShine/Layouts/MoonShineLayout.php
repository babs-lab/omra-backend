<?php

declare(strict_types=1);

namespace App\MoonShine\Layouts;

use MoonShine\Laravel\Layouts\AppLayout;
use MoonShine\ColorManager\Palettes\PurplePalette;
use MoonShine\Contracts\ColorManager\ColorManagerContract;
use MoonShine\MenuManager\MenuItem;
use MoonShine\MenuManager\MenuGroup;
use MoonShine\Laravel\Resources\MoonShineUserResource;
use MoonShine\Laravel\Resources\MoonShineUserRoleResource;
use App\MoonShine\Resources\CityResource;
use App\MoonShine\Resources\HotelResource;
use App\MoonShine\Resources\PackageResource;
use App\MoonShine\Resources\DepartureResource;
use App\MoonShine\Resources\SupplementResource;
use App\MoonShine\Resources\LeadResource;
use App\MoonShine\Resources\PageResource;
use App\MoonShine\Resources\MenuItemResource;
use App\MoonShine\Resources\CurrencyResource;
use App\MoonShine\Resources\PartnerResource;
use App\MoonShine\Resources\TestimonialResource;
use App\MoonShine\Resources\PostResource;
use App\MoonShine\Resources\FeatureResource;
use App\MoonShine\Resources\SectionResource;
use App\MoonShine\Resources\FaqResource;
use App\MoonShine\Resources\SiteSettingsResource;

final class MoonShineLayout extends AppLayout
{
    protected ?string $palette = PurplePalette::class;

    protected function assets(): array
    {
        return [
            ...parent::assets(),
        ];
    }

    protected function menu(): array
    {
        return [
            MenuItem::make(PackageResource::class, 'Formules'),
            MenuItem::make(DepartureResource::class, 'Départs'),
            MenuItem::make(HotelResource::class, 'Hôtels'),
            MenuItem::make(CityResource::class, 'Villes'),
            MenuItem::make(SupplementResource::class, 'Suppléments'),
            MenuItem::make(LeadResource::class, 'Leads'),
            MenuItem::make(PageResource::class, 'Pages'),
            MenuItem::make(MenuItemResource::class, 'Menus'),
            MenuItem::make(CurrencyResource::class, 'Devises'),
            MenuItem::make(PartnerResource::class, 'Partenaires'),
            MenuItem::make(TestimonialResource::class, 'Témoignages'),
            MenuItem::make(PostResource::class, 'Blog'),
            MenuItem::make(SectionResource::class, 'Sections'),
            MenuItem::make(FeatureResource::class, 'Arguments'),
            MenuItem::make(FaqResource::class, 'FAQ'),
            MenuItem::make(SiteSettingsResource::class, 'Paramètres du site'),
            MenuGroup::make('Système', [
                MenuItem::make(MoonShineUserResource::class, 'Utilisateurs'),
                MenuItem::make(MoonShineUserRoleResource::class, 'Rôles'),
            ]),
        ];
    }

    protected function colors(ColorManagerContract $colorManager): void
    {
        parent::colors($colorManager);

        $gold = '#BB9B2F';
        $goldHover = '#D4AF37';
        $green = '#3E9A7B';
        $greenHover = '#28B485';
        $text = '#414242';
        $beige = '#FCF6F0';
        $beigeDark = '#F9ECDA';

        // Primary - Gold
        $colorManager->primary($gold, '#FFFFFF');

        // Secondary - Black
        $colorManager->secondary('#000000', '#FFFFFF');

        // Body background - Warm beige
        $colorManager->background($beige, $beige);

        // Text color
        $colorManager->text($text);

        // Border/stroke color - Gold
        $colorManager->borders($gold);

        // Success - Green accent
        $colorManager->success($green, '#FFFFFF');

        // Buttons - Gold
        $colorManager->button($gold, '#FFFFFF', $goldHover, '#FFFFFF');

        // Menu - Gold active
        $colorManager->menu($gold, '#FFFFFF', $gold);

        // Forms - White bg, gold focus
        $colorManager->form('#FFFFFF', $text, $gold);

        // Cards - White bg
        $colorManager->card('#FFFFFF', $text);

        // Tables - White bg, warm beige header
        $colorManager->table('#FFFFFF', $beigeDark);

        // Badge
        $colorManager->badge($gold, '#FFFFFF');

        // Dividers
        $colorManager->dividers($gold);
    }
}
