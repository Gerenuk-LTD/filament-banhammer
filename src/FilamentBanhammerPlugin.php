<?php

namespace Gerenuk\FilamentBanhammer;

use Filament\Contracts\Plugin;
use Filament\FilamentManager;
use Filament\Panel;

class FilamentBanhammerPlugin implements Plugin
{
    public function getId(): string
    {
        return 'filament-banhammer';
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): FilamentManager
    {
        return filament(app(static::class)->getId());
    }

    public function register(Panel $panel): void
    {
        $resources = [config('filament-banhammer.resource')];

        if (config('filament-banhammer.country_blocking.enabled')) {
            $resources[] = config('filament-banhammer.country_blocking.resource');
        }

        $panel->resources($resources);
    }

    public function boot(Panel $panel): void
    {
        //
    }
}
