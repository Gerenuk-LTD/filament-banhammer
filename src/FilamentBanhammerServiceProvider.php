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

        if (! Schema::hasTable('filament_banhammer_blocked_countries')) {
            return;
        }

        config(['ban.blocked_countries' => BlockedCountry::pluck('code')->all()]);
    }
}
