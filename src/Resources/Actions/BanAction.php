<?php

namespace Gerenuk\FilamentBanhammer\Resources\Actions;

use Filament\Actions\Action;
use Filament\Actions\Concerns\CanCustomizeProcess;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Table;
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

        $this->successNotificationTitle(config('filament-banhammer.actions.ban.title'));

        $this->color(config('filament-banhammer.actions.ban.colour'));

        $this->icon(config('filament-banhammer.actions.ban.icon'));

        $this->requiresConfirmation(config('filament-banhammer.actions.ban.confirm'));

        $this->form(function (Model $record) {
            return $this->getFormSchema();
        });

        $this->action(function (): void {
            $this->process(function (array $data, Model $record, Table $table) {
                $result = $record->ban([
                    'comment' => $data['comment'],
                    'expired_at' => $data['expired_at'],
                ]);

                if (! config('filament-banhammer.actions.ban.notification.show')) {
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

    public function getFormSchema(): array
    {
        return [
            TextInput::make('comment')
                ->nullable(),
            DateTimePicker::make('expired_at')
                ->label('Expires at'),
        ];
    }
}
