<?php

namespace Gerenuk\FilamentBanhammer\Resources\BanhammerResource\Pages;

use Filament\Resources\Pages\ListRecords;

class ListBanhammers extends ListRecords
{
    public static function getResource(): string
    {
        return config('filament-banhammer.resource');
    }
}
