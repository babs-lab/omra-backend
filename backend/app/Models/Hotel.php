<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Hotel extends Model
{
    protected $fillable = ['city_id', 'name', 'rating', 'distance_to_haram', 'description', 'images'];

    protected $casts = [
        'images' => 'array',
    ];

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function departures(): BelongsToMany
    {
        return $this->belongsToMany(Departure::class, 'departure_hotel')
            ->withPivot('nights');
    }
}
