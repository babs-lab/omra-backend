<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\Departure;
use Illuminate\Database\Eloquent\Model;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Fields\Relationships\BelongsToMany;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Json;
use App\MoonShine\Fields\Wysiwyg;

class DepartureResource extends ModelResource
{
    protected string $model = Departure::class;

    protected string $title = 'Départs';

    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
            BelongsTo::make('Formule', 'package', resource: PackageResource::class),
            Date::make('Départ', 'start_date'),
            Date::make('Retour', 'end_date'),
            Image::make('Image', 'image')->disk('public')->dir('departures'),
            Switcher::make('Vacances scolaires', 'is_school_holiday'),
            Number::make('Prix', 'price_override')->step(0.01)->nullable(),
            BelongsTo::make('Devise', 'currency', resource: CurrencyResource::class)->nullable(),
        ];
    }

    protected function formFields(): iterable
    {
        return [
            Box::make('Informations générales', [
                ID::make(),
                BelongsTo::make('Formule', 'package', resource: PackageResource::class)
                    ->required()
                    ->creatable(),
                Date::make('Date de départ', 'start_date')->required(),
                Date::make('Date de retour', 'end_date')->required(),
                Image::make('Image de couverture', 'image')
                    ->disk('public')
                    ->dir('departures')
                    ->allowedExtensions(['jpg', 'jpeg', 'png', 'webp']),
                Switcher::make('Vacances scolaires', 'is_school_holiday'),
                Number::make('Prix personnalisé', 'price_override')->step(0.01)->nullable(),
                BelongsTo::make('Devise', 'currency', resource: CurrencyResource::class)
                    ->nullable()
                    ->placeholder('Sélectionner une devise'),
            ]),
            Box::make('Détails formule', [
                Wysiwyg::make('Détails formule', 'details_formule'),
            ]),
            Box::make('Encadrement', [
                Json::make('Encadrement', 'encadrement')
                    ->fields([
                        Text::make('Icône', 'icon'),
                        Text::make('Titre', 'title'),
                    ]),
            ]),
            Box::make('Transport', [
            Wysiwyg::make('Transport', 'transport'),
            Image::make('Image transport', 'transport_image')
                ->disk('public')
                ->dir('departures'),
                Image::make('Image transport', 'transport_image')
                    ->disk('public')
                    ->dir('departures')
                    ->allowedExtensions(['jpg', 'jpeg', 'png', 'webp']),
            ]),
            Box::make('Inclus', [
                Json::make('Inclus', 'inclus')
                    ->fields([
                        Text::make('Icône', 'icon'),
                        Text::make('Texte', 'text'),
                    ]),
            ]),
            Box::make('Non inclus', [
                Json::make('Non inclus', 'non_inclus')
                    ->fields([
                        Text::make('Icône', 'icon'),
                        Text::make('Texte', 'text'),
                    ]),
            ]),
            Box::make('Hôtels', [
                BelongsToMany::make('Hôtels', 'hotels', resource: HotelResource::class)
                    ->fields([
                        Text::make('Nuits', 'nights'),
                    ]),
            ]),
        ];
    }

    protected function detailFields(): iterable
    {
        return [
            ID::make(),
            BelongsTo::make('Formule', 'package', resource: PackageResource::class),
            Date::make('Départ', 'start_date'),
            Date::make('Retour', 'end_date'),
            Image::make('Image de couverture', 'image')
                ->disk('public')
                ->dir('departures'),
            Switcher::make('Vacances scolaires', 'is_school_holiday'),
            Number::make('Prix personnalisé', 'price_override'),
            BelongsTo::make('Devise', 'currency', resource: CurrencyResource::class),
            Wysiwyg::make('Détails formule', 'details_formule'),
            Json::make('Encadrement', 'encadrement'),
            Wysiwyg::make('Transport', 'transport'),
            Json::make('Inclus', 'inclus'),
            Json::make('Non inclus', 'non_inclus'),
        ];
    }

    protected function search(): array
    {
        return [];
    }
}
