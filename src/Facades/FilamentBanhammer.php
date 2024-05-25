<?php

namespace Gerenuk\FilamentBanhammer\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Gerenuk\FilamentBanhammer\FilamentBanhammer
 */
class FilamentBanhammer extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Gerenuk\FilamentBanhammer\FilamentBanhammer::class;
    }
}
