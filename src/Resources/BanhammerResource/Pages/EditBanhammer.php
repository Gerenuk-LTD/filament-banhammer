<?php

namespace Gerenuk\FilamentBanhammer\Resources\BanhammerResource\Pages;

use Filament\Resources\Pages\EditRecord;

class EditBanhammer extends EditRecord
{
    public static function getResource(): string
    {
        return config('filament-banhammer.resource');
    }
}
