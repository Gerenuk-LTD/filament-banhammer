<?php

namespace Gerenuk\FilamentBanhammer\Resources\Actions;

use Filament\Actions\Concerns\CanCustomizeProcess;
use Filament\Tables\Actions\BulkAction;
use Illuminate\Database\Eloquent\Collection;

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

        $this->requiresConfirmation(config('filament-banhammer.actions.unban_bulk.require_confirmation'));

        $this->action(function (): void {
            $this->process(function (array $data, Collection $records): void {
                $results = [];
                foreach ($records as $record) {
                    $record->unban();
                    $results[] = $record->isBanned();
                }

                if (! config('filament-banhammer.actions.unban_bulk.notifications.show')) {
                    return;
                }

                $this->failureNotificationTitle(config('filament-banhammer.actions.unban_bulk.notifications.error.title'));

                $this->successNotificationTitle(config('filament-banhammer.actions.unban_bulk.notifications.success.title'));

                if (empty($results) || in_array(true, $results, true)) {
                    $this->failure();

                    return;
                }

                $this->success();
            });
        });

        $this->deselectRecordsAfterCompletion();
    }
}
