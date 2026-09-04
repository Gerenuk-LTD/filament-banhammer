<?php

namespace Gerenuk\FilamentBanhammer\Resources\Actions;

use Filament\Actions\BulkAction;
use Filament\Actions\Concerns\CanCustomizeProcess;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

use function Filament\get_authorization_response;

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

        $this->authorizeIndividualRecords(fn (Model $record) => get_authorization_response(config('filament-banhammer.authorization.unban'), $record));

        $this->action(function (): void {
            $this->process(static fn (Collection $records) => $records->each(
                fn (Model $record) => UnbanAction::unban($record)
            ));

            if (! config('filament-banhammer.actions.unban_bulk.notifications.show')) {
                return;
            }

            $this->failureNotificationTitle(config('filament-banhammer.actions.unban_bulk.notifications.error.title'));

            $this->successNotificationTitle(config('filament-banhammer.actions.unban_bulk.notifications.success.title'));

            $this->success();
        });

        $this->deselectRecordsAfterCompletion();
    }
}
