<?php

use Gerenuk\FilamentBanhammer\Tests\Fixtures\UserBanPolicy;
use Illuminate\Support\Facades\Gate;
use Livewire\Livewire;
use Workbench\App\Filament\Resources\UserResource\Pages\ListUsers;
use Workbench\App\Models\User;

it('allows an action when the target model has no policy', function () {
    $user = User::create(['name' => 'Alice']);

    Livewire::test(ListUsers::class)
        ->assertTableActionVisible('ban', $user);
});

it('hides an action when its policy method denies it', function () {
    Gate::policy(User::class, UserBanPolicy::class);

    $user = User::create(['name' => 'Alice']);

    Livewire::test(ListUsers::class)
        ->assertTableActionHidden('ban', $user);
});

it('still allows a different action not covered by the policy', function () {
    Gate::policy(User::class, UserBanPolicy::class);

    $user = User::create(['name' => 'Alice']);

    Livewire::test(ListUsers::class)
        ->assertTableActionVisible('unban', $user);
});
