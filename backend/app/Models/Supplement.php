<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Supplement extends Model
{
    protected $fillable = ['type', 'amount', 'is_percentage', 'currency_id'];

    protected function casts(): array
    {
        return [
            'is_percentage' => 'boolean',
        ];
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }
}
