<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\Faq;
use Illuminate\Database\Eloquent\Model;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Number;

class FaqResource extends ModelResource
{
    protected string $model = Faq::class;

    protected string $title = 'FAQ';

    protected string $column = 'question';

    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
            Text::make('Question', 'question'),
            Text::make('Réponse', 'answer'),
            Switcher::make('Actif', 'is_active'),
            Number::make('Position', 'position')->sortable(),
        ];
    }

    protected function formFields(): iterable
    {
        return [
            Box::make([
                ID::make(),
                Text::make('Question', 'question')->required(),
                Textarea::make('Réponse', 'answer')->required(),
                Switcher::make('Actif', 'is_active'),
                Number::make('Position', 'position')->required()->min(0),
            ]),
        ];
    }

    protected function detailFields(): iterable
    {
        return [
            ID::make(),
            Text::make('Question', 'question'),
            Textarea::make('Réponse', 'answer'),
            Switcher::make('Actif', 'is_active'),
            Number::make('Position', 'position'),
        ];
    }

    protected function search(): array
    {
        return ['question'];
    }
}