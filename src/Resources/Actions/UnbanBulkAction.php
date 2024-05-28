<?php

namespace Gerenuk\FilamentBanhammer\Resources\Actions;

use Filament\Actions\Concerns\CanCustomizeProcess;
use Filament\Tables\Actions\BulkAction;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class UnbanBulkAction extends BulkAction
{
    use CanCustomizeProcess;

    public static function getDefaultName(): ?string
    {
        return 'unban_bulk';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label(config('filament-banhammer.actions.unban_bulk.label'));

        $this->color(config('filament-banhammer.actions.unban_bulk.colour'));

        $this->icon(config('filament-banhammer.actions.unban_bulk.icon'));

        $this->modalHeading(config('filament-banhammer.actions.unban_bulk.label'));

        $this->modalSubmitActionLabel('Confirm');

        $this->requiresConfirmation(config('filament-banhammer.actions.unban_bulk.require_confirmation'));

        $this->action(function (): void {
            $this->process(static fn(Collection $records) => $records->each(fn(Model $record) => $record->unban()));

            if (!config('filament-banhammer.actions.unban_bulk.notifications.show')) {
                return;
            }

            $this->failureNotificationTitle(config('filament-banhammer.actions.unban_bulk.notifications.error.title'));

            $this->successNotificationTitle(config('filament-banhammer.actions.unban_bulk.notifications.success.title'));

            $this->success();
        });

        $this->deselectRecordsAfterCompletion();
    }
}
