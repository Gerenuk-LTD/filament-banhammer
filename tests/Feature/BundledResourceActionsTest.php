<?php

use Gerenuk\FilamentBanhammer\Resources\BanhammerResource\Pages\ListBanhammers;
use Livewire\Livewire;
use Workbench\App\Models\User;

it('edits a ban record from the bundled resource', function () {
    $user = User::create(['name' => 'Alice']);
    $ban = $user->ban(['comment' => 'Original']);

    Livewire::test(ListBanhammers::class)
        ->callTableAction('edit_ban', $ban, data: [
            'comment' => 'Updated',
            'expired_at' => null,
        ]);

    expect($ban->fresh()->comment)->toBe('Updated');
});

it('unbans via the bundled resource, where the table record is the ban itself', function () {
    $user = User::create(['name' => 'Bob']);
    $ban = $user->ban();

    expect($user->fresh()->isBanned())->toBeTrue();

    Livewire::test(ListBanhammers::class)
        ->callTableAction('unban', $ban);

    expect($user->fresh()->isBanned())->toBeFalse();
});
