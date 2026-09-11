<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Package extends Model
{
    protected $fillable = [
        'title', 'slug', 'duration_days', 'base_price_quad', 'description',
        'currency_id',
    ];

    public function departures(): HasMany
    {
        return $this->hasMany(Departure::class);
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }
}
