<?php

namespace Gerenuk\FilamentBanhammer\Resources\Actions;

use Filament\Actions\Action;
use Filament\Actions\Concerns\CanCustomizeProcess;
use Illuminate\Database\Eloquent\Model;

use function Filament\get_authorization_response;

class UnbanAction extends Action
{
    use CanCustomizeProcess;

    public static function getDefaultName(): ?string
    {
        return 'unban';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label(config('filament-banhammer.actions.unban.label'));

        $this->color(config('filament-banhammer.actions.unban.colour'));

        $this->icon(config('filament-banhammer.actions.unban.icon'));

        $this->modalHeading(config('filament-banhammer.actions.unban.label'));

        $this->modalSubmitActionLabel('Confirm');

        $this->requiresConfirmation(config('filament-banhammer.actions.unban.require_confirmation'));

        $this->authorize(fn (Model $record) => get_authorization_response(config('filament-banhammer.authorization.unban'), $record));

        $this->action(function (): void {
            $result = $this->process(static fn (Model $record): bool => static::unban($record));

            if (! config('filament-banhammer.actions.unban.notifications.show')) {
                return;
            }

            $this->failureNotificationTitle(config('filament-banhammer.actions.unban.notifications.error.title'));

            $this->successNotificationTitle(config('filament-banhammer.actions.unban.notifications.success.title'));

            if (! $result) {
                $this->failure();

                return;
            }

            $this->success();
        });
    }

    /**
     * Unbans $record, whether it's a bannable model, a ban record for one, or an IP-only ban.
     */
    public static function unban(Model $record): bool
    {
        if (method_exists($record, 'unban')) {
            $record->unban();

            return true;
        }

        if ($bannable = $record->bannable ?? null) {
            $bannable->unban();

            return true;
        }

        return (bool) $record->delete();
    }
}
