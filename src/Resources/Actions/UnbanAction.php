<?php

namespace Gerenuk\FilamentBanhammer\Resources\Actions;

use Filament\Actions\Action;
use Filament\Actions\Concerns\CanCustomizeProcess;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class UnbanAction extends Action
{
    use CanCustomizeProcess;

    public static function getDefaultName(): ?string
    {
        return 'unban';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->successNotificationTitle(config('filament-banhammer.actions.unban.title'));

        $this->color(config('filament-banhammer.actions.unban.colour'));

        $this->icon(config('filament-banhammer.actions.unban.icon'));

        $this->requiresConfirmation(config('filament-banhammer.actions.unban.confirm'));

        $this->action(function (): void {
            $this->process(function (array $data, Model $record, Table $table) {
                $result = $record->unban();

                if (! config('filament-banhammer.actions.unban.notification.show')) {
                    return;
                }

                if (! $result) {
                    $this->failure();

                    return;
                }

                $this->success();
            });
        });
    }
}
