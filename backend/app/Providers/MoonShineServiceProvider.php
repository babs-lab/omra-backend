<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use MoonShine\Contracts\Core\DependencyInjection\CoreContract;
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
use MoonShine\Laravel\Resources\MoonShineUserResource;
use MoonShine\Laravel\Resources\MoonShineUserRoleResource;

class MoonShineServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            base_path('vendor/moonshine/tinymce/config/moonshine_tinymce.php'),
            'moonshine_tinymce'
        );
    }

    public function boot(CoreContract $core): void
    {
        View::addNamespace('moonshine-tinymce', base_path('vendor/moonshine/tinymce/resources/views'));

        if ($this->app->runningInConsole()) {
            $this->publishes([
                base_path('vendor/moonshine/tinymce/config/moonshine_tinymce.php') => config_path('moonshine_tinymce.php'),
            ], 'moonshine-tinymce-config');

            $this->publishes([
                base_path('vendor/moonshine/tinymce/public') => public_path('vendor/moonshine-tinymce'),
            ], ['moonshine-tinymce-assets', 'laravel-assets']);
        }

        $core
            ->resources([
                CityResource::class,
                HotelResource::class,
                PackageResource::class,
                DepartureResource::class,
                SupplementResource::class,
                LeadResource::class,
                PageResource::class,
                MenuItemResource::class,
                CurrencyResource::class,
                PartnerResource::class,
                TestimonialResource::class,
                PostResource::class,
                FeatureResource::class,
                SectionResource::class,
                FaqResource::class,
                SiteSettingsResource::class,
                MoonShineUserResource::class,
                MoonShineUserRoleResource::class,
            ])
            ->pages([
                ...$core->getConfig()->getPages(),
            ])
        ;
    }
}
