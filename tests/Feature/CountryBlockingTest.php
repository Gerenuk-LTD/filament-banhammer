<?php

use Gerenuk\FilamentBanhammer\FilamentBanhammerServiceProvider;
use Gerenuk\FilamentBanhammer\Models\BlockedCountry;
use Gerenuk\FilamentBanhammer\Resources\BlockedCountryResource\Pages\ListBlockedCountries;
use Livewire\Livewire;

it('uppercases the stored country code', function () {
    expect(BlockedCountry::create(['code' => 'de'])->code)->toBe('DE');
});

it('merges blocked countries into the ban config when enabled', function () {
    config()->set('filament-banhammer.country_blocking.enabled', true);

    BlockedCountry::create(['code' => 'us']);
    BlockedCountry::create(['code' => 'gb']);

    app()->getProvider(FilamentBanhammerServiceProvider::class)->packageBooted();

    expect(config('ban.blocked_countries'))->toEqualCanonicalizing(['US', 'GB']);
});

it('leaves the ban config untouched when disabled', function () {
    config()->set('filament-banhammer.country_blocking.enabled', false);
    config()->set('ban.blocked_countries', ['FR']);

    BlockedCountry::create(['code' => 'us']);

    app()->getProvider(FilamentBanhammerServiceProvider::class)->packageBooted();

    expect(config('ban.blocked_countries'))->toBe(['FR']);
});

it('adds and removes blocked countries from the resource', function () {
    Livewire::test(ListBlockedCountries::class)
        ->callTableAction('add', data: ['code' => 'nz']);

    $country = BlockedCountry::sole();

    expect($country->code)->toBe('NZ');

    Livewire::test(ListBlockedCountries::class)
        ->callTableAction('delete', $country);

    expect(BlockedCountry::count())->toBe(0);
});

it('rejects a duplicate country code', function () {
    BlockedCountry::create(['code' => 'nz']);

    Livewire::test(ListBlockedCountries::class)
        ->callTableAction('add', data: ['code' => 'nz'])
        ->assertHasTableActionErrors(['code' => 'unique']);

    expect(BlockedCountry::count())->toBe(1);
});
