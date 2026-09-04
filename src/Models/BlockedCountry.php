<?php

namespace Gerenuk\FilamentBanhammer\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class BlockedCountry extends Model
{
    public const CACHE_KEY = 'filament-banhammer-blocked-countries';

    protected $table = 'filament_banhammer_blocked_countries';

    protected $fillable = ['code'];

    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget(self::CACHE_KEY));
        static::deleted(fn () => Cache::forget(self::CACHE_KEY));
    }

    protected function code(): Attribute
    {
        return Attribute::make(set: fn (string $value) => strtoupper($value));
    }
}
