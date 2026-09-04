<?php

namespace Gerenuk\FilamentBanhammer\Resources\Actions;

use Filament\Actions\Action;
use Filament\Actions\Concerns\CanCustomizeProcess;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;

use function Filament\get_authorization_response;

class BanIpAction extends Action
{
    use CanCustomizeProcess;

    public static function getDefaultName(): ?string
    {
        return 'ban_ip';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label(config('filament-banhammer.actions.ban_ip.label'));

        $this->color(config('filament-banhammer.actions.ban_ip.colour'));

        $this->icon(config('filament-banhammer.actions.ban_ip.icon'));

        $this->modalHeading(config('filament-banhammer.actions.ban_ip.label'));

        $this->modalSubmitActionLabel('Confirm');

        $this->requiresConfirmation(config('filament-banhammer.actions.ban_ip.require_confirmation'));

        $this->authorize(fn () => get_authorization_response(config('filament-banhammer.authorization.ban_ip'), config('ban.model')));

        $this->schema([
            Section::make()
                ->schema([
                    TextInput::make('ip')
                        ->label('IP address')
                        ->required()
                        ->ip(),
                    Textarea::make('comment')
                        ->nullable(),
                    DateTimePicker::make('expired_at')
                        ->label('Expires at'),
                ]),
        ]);

        $this->action(function (): void {
            $this->process(static fn (array $data) => config('ban.model')::create([
                'ip' => $data['ip'],
                'comment' => $data['comment'],
                'expired_at' => $data['expired_at'],
            ]));

            if (! config('filament-banhammer.actions.ban_ip.notifications.show')) {
                return;
            }

            $this->failureNotificationTitle(config('filament-banhammer.actions.ban_ip.notifications.error.title'));

            $this->successNotificationTitle(config('filament-banhammer.actions.ban_ip.notifications.success.title'));

            $this->success();
        });
    }
}
