<?php

namespace Gerenuk\FilamentBanhammer\Tests\Fixtures;

use Workbench\App\Models\User;

class UserBanPolicy
{
    public function ban(?User $user, User $target): bool
    {
        return false;
    }
}
