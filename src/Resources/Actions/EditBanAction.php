<?php

namespace Gerenuk\FilamentBanhammer\Resources\Actions;

use Filament\Actions\Action;
use Filament\Actions\Concerns\CanCustomizeProcess;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

use function Filament\get_authorization_response;

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

        $this->authorize(fn (Model $record) => get_authorization_response(config('filament-banhammer.authorization.edit_ban'), $record));

        $this->schema($this->getFormSchema());

        $this->fillForm(function (Model $record): array {
            return $record->attributesToArray();
        });

        $this->action(function (): void {
            $result = $this->process(static fn (array $data, Model $record) => $record->update(
                static::isIpOnly($record) ? $data : Arr::except($data, 'ip')
            ));

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
                    TextInput::make('ip')
                        ->label('IP address')
                        ->ip()
                        ->required(fn (?Model $record): bool => $record && static::isIpOnly($record))
                        ->visible(fn (?Model $record): bool => $record && static::isIpOnly($record)),
                    Textarea::make('comment')
                        ->nullable(),
                    DateTimePicker::make('expired_at')
                        ->label('Expires at'),
                ]),
        ];
    }

    protected static function isIpOnly(Model $record): bool
    {
        return blank($record->getAttribute('bannable_type'));
    }
}
