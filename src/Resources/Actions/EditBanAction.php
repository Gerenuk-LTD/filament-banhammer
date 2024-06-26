<?php

namespace Gerenuk\FilamentBanhammer\Resources\Actions;

use Filament\Actions\Concerns\CanCustomizeProcess;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Model;

class EditBanAction extends Action
{
    use CanCustomizeProcess;

    public static function getDefaultName(): ?string
    {
        return 'edit_ban';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label(config('filament-banhammer.actions.edit_ban.label'));

        $this->color(config('filament-banhammer.actions.edit_ban.colour'));

        $this->icon(config('filament-banhammer.actions.edit_ban.icon'));

        $this->modalHeading(config('filament-banhammer.actions.edit_ban.label'));

        $this->modalSubmitActionLabel('Confirm');

        $this->requiresConfirmation(config('filament-banhammer.actions.edit_ban.require_confirmation'));

        $this->form($this->getFormSchema());

        $this->fillForm(function (Model $record): array {
            return $record->attributesToArray();
        });

        $this->action(function (): void {
            $result = $this->process(static fn (array $data, Model $record) => $record->update([
                'comment' => $data['comment'],
                'expired_at' => $data['expired_at'],
            ]));

            if (! config('filament-banhammer.actions.edit_ban.notifications.show')) {
                return;
            }

            $this->failureNotificationTitle(config('filament-banhammer.actions.edit_ban.notifications.error.title'));

            $this->successNotificationTitle(config('filament-banhammer.actions.edit_ban.notifications.success.title'));

            if (! $result) {
                $this->failure();

                return;
            }

            $this->success();
        });
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
