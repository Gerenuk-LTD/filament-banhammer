<?php

use Gerenuk\FilamentBanhammer\Resources\BanhammerResource\Pages\ListBanhammers;
use Livewire\Livewire;
use Mchev\Banhammer\Models\Ban;
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

it('requires an IP when editing an IP-only ban, so it cannot be blanked out', function () {
    $ban = Ban::create(['ip' => '203.0.113.5', 'comment' => 'Original']);

    Livewire::test(ListBanhammers::class)
        ->callTableAction('edit_ban', $ban, data: [
            'ip' => null,
            'comment' => 'Updated',
            'expired_at' => null,
        ])
        ->assertHasTableActionErrors(['ip' => 'required']);

    expect($ban->fresh())
        ->ip->toBe('203.0.113.5')
        ->comment->toBe('Original');
});

it('unbans via the bundled resource, where the table record is the ban itself', function () {
    $user = User::create(['name' => 'Bob']);
    $ban = $user->ban();

    expect($user->fresh()->isBanned())->toBeTrue();

    Livewire::test(ListBanhammers::class)
        ->callTableAction('unban', $ban);

    expect($user->fresh()->isBanned())->toBeFalse();
});
