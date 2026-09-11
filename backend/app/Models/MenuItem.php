<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class MenuItem extends Model
{
    protected $fillable = ['label', 'route', 'url', 'is_external', 'is_active', 'position'];

    protected function casts(): array
    {
        return [
            'is_external' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    protected static function booted(): void
    {
        static::addGlobalScope('order', fn (Builder $q) => $q->orderBy('position'));
    }
}
