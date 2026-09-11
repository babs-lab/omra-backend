<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\Testimonial;
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

class TestimonialResource extends ModelResource
{
    protected string $model = Testimonial::class;

    protected string $title = 'Témoignages';

    protected string $column = 'name';

    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
            Text::make('Nom', 'name'),
            Text::make('Ville', 'city'),
            LogoPreview::make('Avatar', 'avatar')->dir('testimonials'),
            Switcher::make('Actif', 'is_active'),
            Number::make('Position', 'position')->sortable(),
        ];
    }

    protected function formFields(): iterable
    {
        return [
            Box::make([
                ID::make(),
                Text::make('Nom', 'name')->required(),
                Text::make('Ville', 'city'),
                Wysiwyg::make('Contenu', 'content')->required(),
                Number::make('Note', 'rating')->min(1)->max(5),
                Image::make('Avatar', 'avatar')
                    ->dir('testimonials')
                    ->allowedExtensions(['jpg', 'jpeg', 'png', 'webp']),
                Switcher::make('Actif', 'is_active'),
                Number::make('Position', 'position')->required()->min(0),
            ]),
        ];
    }

    protected function detailFields(): iterable
    {
        return [
            ID::make(),
            Text::make('Nom', 'name'),
            Text::make('Ville', 'city'),
            Wysiwyg::make('Contenu', 'content'),
            Number::make('Note', 'rating'),
            LogoPreview::make('Avatar', 'avatar')->dir('testimonials'),
            Switcher::make('Actif', 'is_active'),
            Number::make('Position', 'position'),
        ];
    }

    protected function search(): array
    {
        return ['name', 'city', 'content'];
    }
}
