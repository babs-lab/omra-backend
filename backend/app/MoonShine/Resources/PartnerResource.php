<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\Partner;
use App\MoonShine\Fields\LogoPreview;
use Illuminate\Database\Eloquent\Model;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Url;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Number;

class PartnerResource extends ModelResource
{
    protected string $model = Partner::class;

    protected string $title = 'Partenaires';

    protected string $column = 'name';

    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
            Text::make('Nom', 'name'),
            LogoPreview::make('Logo', 'logo')->dir('partners'),
            Url::make('URL', 'url'),
            Switcher::make('Actif', 'is_active'),
            Number::make('Position', 'position')->sortable(),
        ];
    }

    protected function formFields(): iterable
    {
        return [
            Box::make([
                ID::make(),
                Text::make('Nom', 'name')->required(),
                Image::make('Logo', 'logo')
                    ->dir('partners')
                    ->allowedExtensions(['jpg', 'jpeg', 'png', 'webp', 'svg']),
                Url::make('URL du site', 'url'),
                Switcher::make('Actif', 'is_active'),
                Number::make('Position', 'position')->required()->min(0),
            ]),
        ];
    }

    protected function detailFields(): iterable
    {
        return [
            ID::make(),
            Text::make('Nom', 'name'),
            LogoPreview::make('Logo', 'logo')->dir('partners'),
            Url::make('URL', 'url'),
            Switcher::make('Actif', 'is_active'),
            Number::make('Position', 'position'),
        ];
    }

    protected function search(): array
    {
        return ['name', 'url'];
    }
}
