<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSettings extends Model
{
    protected $fillable = ['key', 'value'];

    private static ?self $instance = null;

    public static function instance(): self
    {
        if (self::$instance === null) {
            self::$instance = self::first() ?? self::create(['key' => 'initialized']);
        }

        return self::$instance;
    }

    public function get($key, $default = null): ?string
    {
        $setting = static::where('key', $key)->first();

        return $setting?->value ?? $default;
    }

    public function set($key, $value = null): static
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);

        return $this;
    }

    public function allAsArray(): array
    {
        return static::pluck('value', 'key')->toArray();
    }
}
