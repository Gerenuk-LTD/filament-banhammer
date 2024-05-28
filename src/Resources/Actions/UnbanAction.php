<?php

namespace Gerenuk\FilamentBanhammer\Resources\Actions;

use Filament\Actions\Concerns\CanCustomizeProcess;
use Filament\Tables\Actions\Action;
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

        $this->label(config('filament-banhammer.actions.unban.label'));

        $this->color(config('filament-banhammer.actions.unban.colour'));

        $this->icon(config('filament-banhammer.actions.unban.icon'));

        $this->modalHeading(config('filament-banhammer.actions.unban.label'));

        $this->modalSubmitActionLabel('Confirm');

        $this->requiresConfirmation(config('filament-banhammer.actions.unban.require_confirmation'));

        $this->action(function (): void {
            $result = $this->process(static fn (array $data, Model $record) => $record->unban());

            if (! config('filament-banhammer.actions.unban.notifications.show')) {
                return;
            }

            $this->failureNotificationTitle(config('filament-banhammer.actions.unban.notifications.error.title'));

            $this->successNotificationTitle(config('filament-banhammer.actions.unban.notifications.success.title'));

            if (! $result) {
                $this->failure();

                return;
            }

            $this->success();
        });
    }
}
