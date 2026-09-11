<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\City;
use Illuminate\Database\Eloquent\Model;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Text;

class CityResource extends ModelResource
{
    protected string $model = City::class;

    protected string $title = 'Villes';

    protected string $column = 'name';

    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
            Text::make('Nom', 'name'),
        ];
    }

    protected function formFields(): iterable
    {
        return [
            Box::make([
                ID::make(),
                Text::make('Nom', 'name')->required(),
            ]),
        ];
    }

    protected function detailFields(): iterable
    {
        return [
            ID::make(),
            Text::make('Nom', 'name'),
        ];
    }

    protected function search(): array
    {
        return ['name'];
    }
}
