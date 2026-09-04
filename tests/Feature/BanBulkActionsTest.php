<?php

use Livewire\Livewire;
use Mchev\Banhammer\Models\Ban;
use Workbench\App\Filament\Resources\UserResource\Pages\ListUsers;
use Workbench\App\Models\User;

it('applies the submitted comment to every bulk-banned record', function () {
    $alice = User::create(['name' => 'Alice']);
    $bob = User::create(['name' => 'Bob']);

    Livewire::test(ListUsers::class)
        ->callTableBulkAction('ban_bulk', [$alice, $bob], data: [
            'comment' => 'Mass ban',
            'expired_at' => null,
        ]);

    expect($alice->fresh()->isBanned())->toBeTrue()
        ->and($bob->fresh()->isBanned())->toBeTrue()
        ->and(Ban::pluck('comment')->unique()->all())->toBe(['Mass ban']);
});

it('unbans every selected record in bulk', function () {
    $alice = User::create(['name' => 'Alice']);
    $bob = User::create(['name' => 'Bob']);
    $alice->ban();
    $bob->ban();

    Livewire::test(ListUsers::class)
        ->callTableBulkAction('unban_bulk', [$alice, $bob]);

    expect($alice->fresh()->isBanned())->toBeFalse()
        ->and($bob->fresh()->isBanned())->toBeFalse();
});
