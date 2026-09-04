<?php

namespace Gerenuk\FilamentBanhammer\Tests;

use Gerenuk\FilamentBanhammer\FilamentBanhammerServiceProvider;
use Gerenuk\FilamentBanhammer\Resources\BlockedCountryResource;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Orchestra\Testbench\TestCase as Orchestra;
use Workbench\App\Providers\Filament\AdminPanelProvider;

class TestCase extends Orchestra
{
    protected $enablesPackageDiscoveries = true;

    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Gerenuk\\FilamentBanhammer\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            FilamentBanhammerServiceProvider::class,
            AdminPanelProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');
        config()->set('app.key', 'base64:'.base64_encode(random_bytes(32)));

        // Enabling this by default lets tests exercise the country-blocking
        // resource; array_merge in mergeConfigFrom() replaces the whole
        // "country_blocking" key, so its "resource" default is repeated here.
        config()->set('filament-banhammer.country_blocking', [
            'enabled' => true,
            'resource' => BlockedCountryResource::class,
        ]);

        $this->setUpDatabase();
    }

    protected function setUpDatabase(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        (include __DIR__.'/../vendor/mchev/banhammer/database/migrations/create_bans_table.php')->up();
        (include __DIR__.'/../vendor/mchev/banhammer/database/migrations/metas_field_to_bans_table.php')->up();

        (include __DIR__.'/../database/migrations/create_filament_banhammer_blocked_countries_table.php.stub')->up();
    }
}
