<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lead extends Model
{
    protected $fillable = [
        'departure_id', 'first_name', 'last_name', 'email',
        'phone', 'passengers_count', 'room_type_requested',
        'estimated_total_price', 'currency', 'status', 'notes',
    ];

    protected $casts = [
        'estimated_total_price' => 'decimal:2',
        'passengers_count' => 'integer',
    ];

    public function departure(): BelongsTo
    {
        return $this->belongsTo(Departure::class);
    }
}
