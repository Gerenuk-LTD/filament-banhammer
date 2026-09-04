<?php

use Gerenuk\FilamentBanhammer\Resources\BanhammerResource\Pages\ListBanhammers;
use Livewire\Livewire;
use Mchev\Banhammer\Models\Ban;

it('bans a raw IP address with no bannable model', function () {
    Livewire::test(ListBanhammers::class)
        ->callAction('ban_ip', data: [
            'ip' => '203.0.113.5',
            'comment' => 'Scraping',
            'expired_at' => null,
        ]);

    $ban = Ban::sole();

    expect($ban->ip)->toBe('203.0.113.5')
        ->and($ban->bannable_type)->toBeNull();
});

it('unbans an IP-only ban by deleting it', function () {
    Livewire::test(ListBanhammers::class)
        ->callAction('ban_ip', data: ['ip' => '203.0.113.5', 'comment' => null, 'expired_at' => null]);

    $ban = Ban::sole();

    Livewire::test(ListBanhammers::class)
        ->callTableAction('unban', $ban);

    expect(Ban::withTrashed()->find($ban->id)->trashed())->toBeTrue();
});
