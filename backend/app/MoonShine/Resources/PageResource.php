<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\Page;
use Illuminate\Database\Eloquent\Model;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Text;
use App\MoonShine\Fields\Wysiwyg;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Select;

class PageResource extends ModelResource
{
    protected string $model = Page::class;

    protected string $title = 'Pages';

    protected string $column = 'title';

    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
            Text::make('Titre', 'title'),
            Text::make('Slug', 'slug'),
            Switcher::make('Publiée', 'is_published'),
        ];
    }

    protected function formFields(): iterable
    {
        return [
            Box::make([
                ID::make(),
                Text::make('Titre', 'title')->required(),
                Text::make('Slug', 'slug')->required(),
                Switcher::make('Publiée', 'is_published'),
                Image::make('Image de couverture', 'cover_image')
                    ->dir('pages')
                    ->allowedExtensions(['jpg', 'jpeg', 'png', 'webp']),
                Select::make('Disposition', 'layout')
                    ->options([
                        'full' => 'Pleine largeur',
                        'sidebar' => 'Avec barre latérale',
                    ])->default('full'),
                Text::make('Meta description', 'meta_description'),
                Wysiwyg::make('Contenu', 'content')->required(),
            ]),
        ];
    }

    protected function detailFields(): iterable
    {
        return [
            ID::make(),
            Text::make('Titre', 'title'),
            Text::make('Slug', 'slug'),
            Switcher::make('Publiée', 'is_published'),
            Image::make('Image de couverture', 'cover_image'),
            Text::make('Disposition', 'layout'),
            Text::make('Meta description', 'meta_description'),
            Wysiwyg::make('Contenu', 'content'),
        ];
    }

    protected function search(): array
    {
        return ['title', 'slug'];
    }
}
