<?php

use Livewire\Livewire;
use Mchev\Banhammer\Models\Ban;
use Workbench\App\Filament\Resources\UserResource\Pages\ListUsers;
use Workbench\App\Models\User;

it('bans a record with the submitted comment and expiry', function () {
    $user = User::create(['name' => 'Alice']);

    Livewire::test(ListUsers::class)
        ->callTableAction('ban', $user, data: [
            'comment' => 'Spamming',
            'expired_at' => now()->addDays(3)->toDateTimeString(),
        ]);

    expect($user->fresh()->isBanned())->toBeTrue()
        ->and(Ban::first()->comment)->toBe('Spamming');
});

it('unbans a record directly when used on the host resource', function () {
    $user = User::create(['name' => 'Bob']);
    $user->ban(['comment' => 'Naughty']);

    expect($user->fresh()->isBanned())->toBeTrue();

    Livewire::test(ListUsers::class)
        ->callTableAction('unban', $user);

    expect($user->fresh()->isBanned())->toBeFalse();
});
