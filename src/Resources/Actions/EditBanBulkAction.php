<?php

namespace Gerenuk\FilamentBanhammer\Resources\Actions;

use Filament\Actions\BulkAction;
use Filament\Actions\Concerns\CanCustomizeProcess;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

use function Filament\get_authorization_response;

class EditBanBulkAction extends BulkAction
{
    use CanCustomizeProcess;

    public static function getDefaultName(): ?string
    {
        return 'edit_ban_bulk';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label(config('filament-banhammer.actions.edit_ban_bulk.label'));

        $this->color(config('filament-banhammer.actions.edit_ban_bulk.colour'));

        $this->icon(config('filament-banhammer.actions.edit_ban_bulk.icon'));

        $this->modalHeading(config('filament-banhammer.actions.edit_ban_bulk.label'));

        $this->modalSubmitActionLabel('Confirm');

        $this->requiresConfirmation(config('filament-banhammer.actions.edit_ban_bulk.require_confirmation'));

        $this->authorizeIndividualRecords(fn (Model $record) => get_authorization_response(config('filament-banhammer.authorization.edit_ban'), $record));

        $this->schema($this->getFormSchema());

        $this->action(function (): void {
            $this->process(static fn (array $data, Collection $records) => $records->each(fn (Model $record) => $record->update([
                'comment' => $data['comment'],
                'expired_at' => $data['expired_at'],
            ])));

            if (! config('filament-banhammer.actions.edit_ban_bulk.notifications.show')) {
                return;
            }

            $this->failureNotificationTitle(config('filament-banhammer.actions.edit_ban_bulk.notifications.error.title'));

            $this->successNotificationTitle(config('filament-banhammer.actions.edit_ban_bulk.notifications.success.title'));

            $this->success();
        });

        $this->deselectRecordsAfterCompletion();
    }

    public function getFormSchema(): array
    {
        return [
            Section::make()
                ->schema([
                    Textarea::make('comment')
                        ->nullable(),
                    DateTimePicker::make('expired_at')
                        ->label('Expires at'),
                ]),
        ];
    }
}
