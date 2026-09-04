<?php

use Gerenuk\FilamentBanhammer\FilamentBanhammerServiceProvider;
use Gerenuk\FilamentBanhammer\Models\BlockedCountry;
use Gerenuk\FilamentBanhammer\Resources\BlockedCountryResource\Pages\ListBlockedCountries;
use Gerenuk\FilamentBanhammer\Tests\Fixtures\BlockedCountryPolicy;
use Illuminate\Support\Facades\Gate;
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

it('picks up a change after the list is cached, since writes invalidate the cache', function () {
    config()->set('filament-banhammer.country_blocking.enabled', true);

    $provider = app()->getProvider(FilamentBanhammerServiceProvider::class);

    BlockedCountry::create(['code' => 'us']);
    $provider->packageBooted();
    expect(config('ban.blocked_countries'))->toBe(['US']);

    BlockedCountry::create(['code' => 'gb']);
    $provider->packageBooted();
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

it('hides adding a country when a policy denies it', function () {
    Gate::policy(BlockedCountry::class, BlockedCountryPolicy::class);

    Livewire::test(ListBlockedCountries::class)
        ->assertTableActionHidden('add');
});

it('hides deleting a country when a policy denies it', function () {
    Gate::policy(BlockedCountry::class, BlockedCountryPolicy::class);

    $country = BlockedCountry::create(['code' => 'nz']);

    Livewire::test(ListBlockedCountries::class)
        ->assertTableActionHidden('delete', $country);
});
