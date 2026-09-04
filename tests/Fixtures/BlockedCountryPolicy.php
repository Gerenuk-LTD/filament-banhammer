<?php

namespace Gerenuk\FilamentBanhammer\Tests\Fixtures;

class BlockedCountryPolicy
{
    public function create(?object $user): bool
    {
        return false;
    }

    public function delete(?object $user, object $blockedCountry): bool
    {
        return false;
    }
}
