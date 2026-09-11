<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Departure extends Model
{
    protected $fillable = [
        'package_id', 'start_date', 'end_date', 'image', 'is_school_holiday',
        'price_override', 'currency_id',
        'details_formule', 'encadrement', 'transport', 'transport_image', 'inclus', 'non_inclus',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_school_holiday' => 'boolean',
        'encadrement' => 'array',
        'inclus' => 'array',
        'non_inclus' => 'array',
    ];

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    public function hotels(): BelongsToMany
    {
        return $this->belongsToMany(Hotel::class, 'departure_hotel')
            ->withPivot('nights');
    }

    public function leads(): HasMany
    {
        return $this->hasMany(Lead::class);
    }
}
