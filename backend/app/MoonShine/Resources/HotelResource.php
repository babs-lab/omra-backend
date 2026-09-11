<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\Hotel;
use Illuminate\Database\Eloquent\Model;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Image;
use App\MoonShine\Fields\Wysiwyg;

class HotelResource extends ModelResource
{
    protected string $model = Hotel::class;

    protected string $title = 'Hôtels';

    protected string $column = 'name';

    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
            Text::make('Nom', 'name'),
            BelongsTo::make('Ville', 'city', resource: CityResource::class),
            Text::make('Note', 'rating'),
        ];
    }

    protected function formFields(): iterable
    {
        return [
            Box::make([
                ID::make(),
                Text::make('Nom', 'name')->required(),
                BelongsTo::make('Ville', 'city', resource: CityResource::class)->required(),
                Text::make('Note', 'rating'),
                Text::make('Distance du Haram', 'distance_to_haram'),
                Wysiwyg::make('Description', 'description'),
                Image::make('Photos', 'images')
                    ->multiple()
                    ->disk('public')
                    ->dir('hotels')
                    ->allowedExtensions(['jpg', 'jpeg', 'png', 'webp']),
            ]),
        ];
    }

    protected function detailFields(): iterable
    {
        return [
            ID::make(),
            Text::make('Nom', 'name'),
            BelongsTo::make('Ville', 'city', resource: CityResource::class),
            Text::make('Note', 'rating'),
            Text::make('Distance du Haram', 'distance_to_haram'),
            Wysiwyg::make('Description', 'description'),
            Image::make('Photos', 'images')
                ->multiple()
                ->disk('public')
                ->dir('hotels'),
        ];
    }

    protected function search(): array
    {
        return ['name'];
    }
}
