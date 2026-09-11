<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\Lead;
use Illuminate\Database\Eloquent\Model;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\UI\Fields\Email;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Switcher;

class LeadResource extends ModelResource
{
    protected string $model = Lead::class;

    protected string $title = 'Leads';

    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
            Text::make('Prénom', 'first_name'),
            Text::make('Nom', 'last_name'),
            Email::make('Email', 'email'),
            BelongsTo::make('Départ', 'departure', resource: DepartureResource::class),
            Number::make('Voyageurs', 'passengers_count'),
            Text::make('Chambre', 'room_type_requested'),
            Text::make('Total estimation', 'estimated_total_price'),
            Text::make('Devise', 'currency'),
            Text::make('Statut', 'status'),
        ];
    }

    protected function formFields(): iterable
    {
        return [
            Box::make([
                ID::make(),
                Text::make('Prénom', 'first_name')->required(),
                Text::make('Nom', 'last_name')->required(),
                Email::make('Email', 'email')->required(),
                Text::make('Téléphone', 'phone')->required(),
                BelongsTo::make('Départ', 'departure', resource: DepartureResource::class)->required(),
                Number::make('Nombre de voyageurs', 'passengers_count')->required()->min(1),
                Text::make('Type de chambre', 'room_type_requested')->required(),
                Number::make('Total estimation', 'estimated_total_price')->min(0),
                Text::make('Devise', 'currency'),
                Text::make('Statut', 'status'),
            ]),
        ];
    }

    protected function detailFields(): iterable
    {
        return [
            ID::make(),
            Text::make('Prénom', 'first_name'),
            Text::make('Nom', 'last_name'),
            Email::make('Email', 'email'),
            Text::make('Téléphone', 'phone'),
            BelongsTo::make('Départ', 'departure', resource: DepartureResource::class),
            Number::make('Voyageurs', 'passengers_count'),
            Text::make('Chambre', 'room_type_requested'),
            Text::make('Total estimation', 'estimated_total_price'),
            Text::make('Devise', 'currency'),
            Text::make('Statut', 'status'),
        ];
    }

    protected function search(): array
    {
        return ['first_name', 'last_name', 'email'];
    }
}
