<?php

namespace Gerenuk\FilamentBanhammer\Resources\Actions;

use Filament\Actions\Action;
use Filament\Actions\Concerns\CanCustomizeProcess;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Model;

class BanAction extends Action
{
    use CanCustomizeProcess;

    public static function getDefaultName(): ?string
    {
        return 'ban';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label(config('filament-banhammer.actions.ban.label'));

        $this->color(config('filament-banhammer.actions.ban.colour'));

        $this->icon(config('filament-banhammer.actions.ban.icon'));

        $this->modalHeading(config('filament-banhammer.actions.ban.label'));

        $this->modalSubmitActionLabel('Confirm');

        $this->requiresConfirmation(config('filament-banhammer.actions.ban.require_confirmation'));

        $this->form(function (Model $record) {
            return $this->getFormSchema();
        });

        $this->action(function (): void {
            $result = $this->process(static fn (array $data, Model $record) => $record->ban([
                'comment' => $data['comment'],
                'expired_at' => $data['expired_at'],
            ]));

            if (! config('filament-banhammer.actions.ban.notifications.show')) {
                return;
            }

            $this->failureNotificationTitle(config('filament-banhammer.actions.ban.notifications.error.title'));

            $this->successNotificationTitle(config('filament-banhammer.actions.ban.notifications.success.title'));

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
                    TextInput::make('comment')
                        ->nullable(),
                    DateTimePicker::make('expired_at')
                        ->label('Expires at'),
                ]),
        ];
    }
}
