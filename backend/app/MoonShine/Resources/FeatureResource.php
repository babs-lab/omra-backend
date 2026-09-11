<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\Feature;
use Illuminate\Database\Eloquent\Model;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Number;

class FeatureResource extends ModelResource
{
    protected string $model = Feature::class;

    protected string $title = 'Arguments';

    protected string $column = 'title';

    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
            Text::make('Titre', 'title'),
            Text::make('Icône (SVG)', 'icon'),
            Switcher::make('Actif', 'is_active'),
            Number::make('Position', 'position')->sortable(),
        ];
    }

    protected function formFields(): iterable
    {
        return [
            Box::make([
                ID::make(),
                Text::make('Titre', 'title')->required(),
                Text::make('Icône (SVG path)', 'icon')->hint('Collez le contenu SVG (path uniquement)'),
                Switcher::make('Actif', 'is_active'),
                Number::make('Position', 'position')->required()->min(0),
            ]),
        ];
    }

    protected function detailFields(): iterable
    {
        return [
            ID::make(),
            Text::make('Titre', 'title'),
            Text::make('Icône (SVG)', 'icon'),
            Switcher::make('Actif', 'is_active'),
            Number::make('Position', 'position'),
        ];
    }

    protected function search(): array
    {
        return ['title'];
    }
}
