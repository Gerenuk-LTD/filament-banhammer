<?php

use Gerenuk\FilamentBanhammer\Exports\BanExporter;
use Mchev\Banhammer\Models\Ban;

it('exports against the configured ban model', function () {
    expect(BanExporter::getModel())->toBe(Ban::class);
});

it('defines export columns', function () {
    expect(BanExporter::getColumns())->not->toBeEmpty();
});
