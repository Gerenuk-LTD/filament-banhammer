<?php

namespace Gerenuk\FilamentBanhammer\Resources\Actions;

use Filament\Actions\Concerns\CanCustomizeProcess;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\BulkAction;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class BanBulkAction extends BulkAction
{
    use CanCustomizeProcess;

    public static function getDefaultName(): ?string
    {
        return 'ban_bulk';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->successNotificationTitle(config('filament-banhammer.actions.ban_bulk.title'));

        $this->color(config('filament-banhammer.actions.ban_bulk.colour'));

        $this->icon(config('filament-banhammer.actions.ban_bulk.icon'));

        $this->requiresConfirmation(config('filament-banhammer.actions.ban_bulk.confirm'));

        $this->form(function (Model $record) {
            return $this->getFormSchema();
        });

        $this->action(function (): void {
            $this->process(function (array $data, Collection $records): void {
                $result = $records->filter(fn ($r) => ! $r->banned_at)->each->ban([
                    'comment' => $data['comment'],
                    'expired_at' => $data['expired_at'],
                ]);

                if (! config('filament-banhammer.actions.ban_bulk.notification.show')) {
                    return;
                }

                if (! $result) {
                    $this->failure();

                    return;
                }

                $this->success();
            });
        });

        $this->deselectRecordsAfterCompletion();
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
