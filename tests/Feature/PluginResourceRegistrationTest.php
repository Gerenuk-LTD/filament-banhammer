<?php

use Filament\Panel;
use Gerenuk\FilamentBanhammer\FilamentBanhammerPlugin;
use Gerenuk\FilamentBanhammer\Resources\BlockedCountryResource;

it('only registers the country blocking resource when enabled', function () {
    config()->set('filament-banhammer.country_blocking.enabled', false);

    $panel = Panel::make()->id('test');
    FilamentBanhammerPlugin::make()->register($panel);

    expect($panel->getResources())->not->toContain(BlockedCountryResource::class);
});
