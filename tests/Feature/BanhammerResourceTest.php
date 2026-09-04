<?php

use Filament\Facades\Filament;
use Gerenuk\FilamentBanhammer\Resources\BanhammerResource;
use Mchev\Banhammer\Models\Ban;

it('uses the configured ban model', function () {
    expect(BanhammerResource::getModel())->toBe(Ban::class);
});

it('registers the index page', function () {
    expect(BanhammerResource::getPages())->toHaveKey('index');
});

it('is registered on the panel by the plugin', function () {
    expect(Filament::getPanel('admin')->getResources())->toContain(BanhammerResource::class);
});
