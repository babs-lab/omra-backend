<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\Post;
use App\MoonShine\Fields\LogoPreview;
use Illuminate\Database\Eloquent\Model;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Text;
use App\MoonShine\Fields\Wysiwyg;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Number;

class PostResource extends ModelResource
{
    protected string $model = Post::class;

    protected string $title = 'Articles';

    protected string $column = 'title';

    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
            Text::make('Titre', 'title'),
            LogoPreview::make('Image', 'cover_image')->dir('posts'),
            Switcher::make('Publié', 'is_published'),
            Number::make('Position', 'position')->sortable(),
        ];
    }

    protected function formFields(): iterable
    {
        return [
            Box::make([
                ID::make(),
                Text::make('Titre', 'title')->required(),
                Text::make('Slug', 'slug')->required(),
                Text::make('Extrait', 'excerpt'),
                Wysiwyg::make('Contenu', 'content')->required(),
                Image::make('Image de couverture', 'cover_image')
                    ->dir('posts')
                    ->allowedExtensions(['jpg', 'jpeg', 'png', 'webp']),
                Switcher::make('Publié', 'is_published'),
                Number::make('Position', 'position')->required()->min(0),
            ]),
        ];
    }

    protected function detailFields(): iterable
    {
        return [
            ID::make(),
            Text::make('Titre', 'title'),
            Text::make('Slug', 'slug'),
            Text::make('Extrait', 'excerpt'),
            Wysiwyg::make('Contenu', 'content'),
            LogoPreview::make('Image', 'cover_image')->dir('posts'),
            Switcher::make('Publié', 'is_published'),
            Number::make('Position', 'position'),
        ];
    }

    protected function search(): array
    {
        return ['title', 'slug', 'excerpt'];
    }
}
