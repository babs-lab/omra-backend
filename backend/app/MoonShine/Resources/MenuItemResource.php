<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\MenuItem;
use Illuminate\Database\Eloquent\Model;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Number;

class MenuItemResource extends ModelResource
{
    protected string $model = MenuItem::class;

    protected string $title = 'Menus';

    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
            Text::make('Label', 'label'),
            Text::make('Route', 'route'),
            Text::make('URL', 'url'),
            Switcher::make('Actif', 'is_active'),
            Number::make('Position', 'position')->sortable(),
        ];
    }

    protected function formFields(): iterable
    {
        return [
            Box::make([
                ID::make(),
                Text::make('Label', 'label')->required(),
                Text::make('Route', 'route'),
                Text::make('URL', 'url'),
                Switcher::make('Lien externe', 'is_external'),
                Switcher::make('Actif', 'is_active'),
                Number::make('Position', 'position')->required()->min(0),
            ]),
        ];
    }

    protected function detailFields(): iterable
    {
        return [
            ID::make(),
            Text::make('Label', 'label'),
            Text::make('Route', 'route'),
            Text::make('URL', 'url'),
            Switcher::make('Lien externe', 'is_external'),
            Switcher::make('Actif', 'is_active'),
            Number::make('Position', 'position'),
        ];
    }

    protected function search(): array
    {
        return ['label', 'route', 'url'];
    }
}
