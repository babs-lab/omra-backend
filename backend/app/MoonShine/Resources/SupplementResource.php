<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\Supplement;
use Illuminate\Database\Eloquent\Model;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Switcher;

class SupplementResource extends ModelResource
{
    protected string $model = Supplement::class;

    protected string $title = 'Suppléments';

    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
            Text::make('Type', 'type'),
            Number::make('Montant', 'amount'),
            Switcher::make('Pourcentage', 'is_percentage'),
            BelongsTo::make('Devise', 'currency', resource: CurrencyResource::class),
        ];
    }

    protected function formFields(): iterable
    {
        return [
            Box::make([
                ID::make(),
                Text::make('Type', 'type')->required(),
                Number::make('Montant', 'amount')->required()->step(0.01),
                Switcher::make('Pourcentage', 'is_percentage'),
                BelongsTo::make('Devise', 'currency', resource: CurrencyResource::class)
                    ->nullable()
                    ->placeholder('Sélectionner une devise'),
            ]),
        ];
    }

    protected function detailFields(): iterable
    {
        return [
            ID::make(),
            Text::make('Type', 'type'),
            Number::make('Montant', 'amount'),
            Switcher::make('Pourcentage', 'is_percentage'),
            BelongsTo::make('Devise', 'currency', resource: CurrencyResource::class),
        ];
    }

    protected function search(): array
    {
        return ['type'];
    }
}
