<?php

namespace Gerenuk\FilamentBanhammer\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class BlockedCountry extends Model
{
    protected $table = 'filament_banhammer_blocked_countries';

    protected $fillable = ['code'];

    protected function code(): Attribute
    {
        return Attribute::make(set: fn (string $value) => strtoupper($value));
    }
}
