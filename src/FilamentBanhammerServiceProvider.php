<?php

namespace Gerenuk\FilamentBanhammer;

use Gerenuk\FilamentBanhammer\Commands\FilamentBanhammerCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentBanhammerServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('filament-banhammer')
            ->hasConfigFile()
            ->hasViews()
            ->hasCommand(FilamentBanhammerCommand::class);
    }
}
