<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\Currency;
use Illuminate\Database\Eloquent\Model;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Switcher;

class CurrencyResource extends ModelResource
{
    protected string $model = Currency::class;

    protected string $title = 'Devises';

    protected string $column = 'name';

    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
            Text::make('Code', 'code'),
            Text::make('Nom', 'name'),
            Text::make('Symbole', 'symbol'),
            Number::make('Taux', 'exchange_rate')->sortable(),
            Switcher::make('Actif', 'is_active'),
        ];
    }

    protected function formFields(): iterable
    {
        return [
            Box::make([
                ID::make(),
                Text::make('Code', 'code')->required(),
                Text::make('Nom', 'name')->required(),
                Text::make('Symbole', 'symbol')->required(),
                Number::make('Taux de change (vs EUR)', 'exchange_rate')->required()->step(0.0001)->min(0),
                Switcher::make('Actif', 'is_active'),
            ]),
        ];
    }

    protected function detailFields(): iterable
    {
        return [
            ID::make(),
            Text::make('Code', 'code'),
            Text::make('Nom', 'name'),
            Text::make('Symbole', 'symbol'),
            Number::make('Taux de change', 'exchange_rate'),
            Switcher::make('Actif', 'is_active'),
        ];
    }

    protected function search(): array
    {
        return ['code', 'name'];
    }
}
