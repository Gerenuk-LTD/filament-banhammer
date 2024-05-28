<?php

namespace Gerenuk\FilamentBanhammer\Resources\Actions;

use Filament\Actions\Concerns\CanCustomizeProcess;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Section;
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

        $this->label(config('filament-banhammer.actions.ban_bulk.label'));

        $this->color(config('filament-banhammer.actions.ban_bulk.colour'));

        $this->icon(config('filament-banhammer.actions.ban_bulk.icon'));

        $this->requiresConfirmation(config('filament-banhammer.actions.ban_bulk.require_confirmation'));

        $this->form(function (Model $record) {
            return $this->getFormSchema();
        });

        $this->action(function (): void {
            $this->process(function (array $data, Collection $records): void {
                $results = [];
                foreach ($records->filter(fn ($r) => ! $r->banned_at) as $record) {
                    $results[] = $record->ban([
                        'comment' => $data['comment'],
                        'expired_at' => $data['expired_at'],
                    ]);
                }

                if (! config('filament-banhammer.actions.ban_bulk.notifications.show')) {
                    return;
                }

                $this->failureNotificationTitle(config('filament-banhammer.actions.ban_bulk.notifications.error.title'));

                $this->successNotificationTitle(config('filament-banhammer.actions.ban_bulk.notifications.success.title'));

                if (empty($results) || in_array(false, $results, true)) {
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
