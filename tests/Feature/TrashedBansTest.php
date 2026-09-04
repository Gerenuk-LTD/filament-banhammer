<?php

use Gerenuk\FilamentBanhammer\Resources\BanhammerResource\Pages\ListBanhammers;
use Livewire\Livewire;
use Mchev\Banhammer\Models\Ban;
use Workbench\App\Models\User;

it('soft-deletes a ban when unbanning an IP-only record, and can restore it', function () {
    $user = User::create(['name' => 'Alice']);
    $ban = $user->ban();

    Livewire::test(ListBanhammers::class)
        ->callTableAction('unban', $ban);

    expect(Ban::withTrashed()->find($ban->id)->trashed())->toBeTrue();

    Livewire::test(ListBanhammers::class)
        ->callTableAction('restore', $ban->fresh());

    expect(Ban::find($ban->id)->trashed())->toBeFalse();
});

it('permanently deletes a trashed ban when force-delete is enabled', function () {
    config()->set('filament-banhammer.trashed.force_delete', true);

    $user = User::create(['name' => 'Bob']);
    $ban = $user->ban();
    $ban->delete();

    Livewire::test(ListBanhammers::class)
        ->callTableAction('forceDelete', $ban->fresh());

    expect(Ban::withTrashed()->find($ban->id))->toBeNull();
});

it('hides the force-delete action unless explicitly enabled', function () {
    $user = User::create(['name' => 'Carol']);
    $ban = $user->ban();
    $ban->delete();

    Livewire::test(ListBanhammers::class)
        ->assertTableActionHidden('forceDelete', $ban->fresh());
});
