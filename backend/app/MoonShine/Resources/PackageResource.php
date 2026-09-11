<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\Package;
use Illuminate\Database\Eloquent\Model;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Number;
use App\MoonShine\Fields\Wysiwyg;

class PackageResource extends ModelResource
{
    protected string $model = Package::class;

    protected string $title = 'Formules';

    protected string $column = 'title';

    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
            Text::make('Titre', 'title'),
            Text::make('Durée (jours)', 'duration_days'),
            Text::make('Prix base (quad)', 'base_price_quad'),
            BelongsTo::make('Devise', 'currency', resource: CurrencyResource::class),
        ];
    }

    protected function formFields(): iterable
    {
        return [
            Box::make([
                ID::make(),
                Text::make('Titre', 'title')->required(),
                Text::make('Slug', 'slug')->required(),
                Number::make('Durée (jours)', 'duration_days')->required()->min(1),
                Number::make('Prix base quadruple', 'base_price_quad')->required()->step(0.01),
                BelongsTo::make('Devise', 'currency', resource: CurrencyResource::class)
                    ->nullable()
                    ->placeholder('Sélectionner une devise'),
                Wysiwyg::make('Description', 'description'),
            ]),
        ];
    }

    protected function detailFields(): iterable
    {
        return [
            ID::make(),
            Text::make('Titre', 'title'),
            Text::make('Slug', 'slug'),
            Text::make('Durée (jours)', 'duration_days'),
            Text::make('Prix base (quad)', 'base_price_quad'),
            BelongsTo::make('Devise', 'currency', resource: CurrencyResource::class),
            Wysiwyg::make('Description', 'description'),
        ];
    }

    protected function search(): array
    {
        return ['title', 'slug'];
    }
}
