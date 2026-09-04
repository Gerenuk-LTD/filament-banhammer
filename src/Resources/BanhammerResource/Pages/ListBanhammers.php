<?php

namespace Gerenuk\FilamentBanhammer\Resources\BanhammerResource\Pages;

use Filament\Resources\Pages\ListRecords;
use Gerenuk\FilamentBanhammer\Resources\Actions\BanIpAction;

class ListBanhammers extends ListRecords
{
    public static function getResource(): string
    {
        return config('filament-banhammer.resource');
    }

    protected function getHeaderActions(): array
    {
        return [
            BanIpAction::make()
                ->visible(config('filament-banhammer.ip_blocking.enabled')),
        ];
    }
}
