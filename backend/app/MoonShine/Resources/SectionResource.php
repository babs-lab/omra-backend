<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\Section;
use App\MoonShine\Fields\Wysiwyg;
use Illuminate\Database\Eloquent\Model;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Select;

class SectionResource extends ModelResource
{
    protected string $model = Section::class;

    protected string $title = 'Sections';

    protected string $column = 'title';

    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
            Text::make('Titre', 'title'),
            Text::make('Page cible', 'target_page'),
            Number::make('Position', 'position')->sortable(),
            Switcher::make('Actif', 'is_active'),
        ];
    }

    protected function formFields(): iterable
    {
        return [
            Box::make([
                ID::make(),
                Text::make('Titre', 'title')->required(),
                Text::make('Slug', 'slug')->required(),
                Text::make('Page cible', 'target_page')->required()->placeholder('homepage'),
                Number::make('Position', 'position')->required()->min(0),
                Select::make('Style', 'style')->options([
                    'default' => 'Standard (blanc)',
                    'dark' => 'Sombre',
                    'gold' => 'Accent doré',
                ])->default('default'),
                Wysiwyg::make('Contenu', 'content')->required(),
                Switcher::make('Actif', 'is_active'),
            ]),
        ];
    }

    protected function detailFields(): iterable
    {
        return [
            ID::make(),
            Text::make('Titre', 'title'),
            Text::make('Slug', 'slug'),
            Text::make('Page cible', 'target_page'),
            Number::make('Position', 'position'),
            Text::make('Style', 'style'),
            Switcher::make('Actif', 'is_active'),
        ];
    }

    protected function search(): array
    {
        return ['title', 'target_page'];
    }
}
