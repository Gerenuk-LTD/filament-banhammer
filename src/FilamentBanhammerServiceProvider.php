<?php

namespace Gerenuk\FilamentBanhammer;

use Gerenuk\FilamentBanhammer\Models\BlockedCountry;
use Illuminate\Support\Facades\Schema;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentBanhammerServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('filament-banhammer')
            ->hasConfigFile()
            ->hasMigration('create_filament_banhammer_blocked_countries_table')
            ->runsMigrations()
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->askToStarRepoOnGitHub('gerenuk-ltd/filament-banhammer');
            });
    }

    public function packageBooted(): void
    {
        if (! config('filament-banhammer.country_blocking.enabled')) {
            return;
        }

        // The database may not be reachable yet (e.g. a fresh install, before
        // migrating), and every artisan command boots this provider — so a
        // connection failure here shouldn't break the console.
        try {
            if (! Schema::hasTable('filament_banhammer_blocked_countries')) {
                return;
            }

            config(['ban.blocked_countries' => BlockedCountry::pluck('code')->all()]);
        } catch (\Throwable) {
            return;
        }
    }
}
