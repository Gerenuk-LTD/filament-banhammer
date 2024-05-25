<?php

namespace Gerenuk\FilamentBanhammer\Commands;

use Illuminate\Console\Command;

class FilamentBanhammerCommand extends Command
{
    public $signature = 'filament-banhammer';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
