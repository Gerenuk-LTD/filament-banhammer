<?php

namespace Gerenuk\FilamentBanhammer\Resources\Actions;

use Filament\Actions\Action;
use Filament\Actions\Concerns\CanCustomizeProcess;
use Illuminate\Database\Eloquent\Model;

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

        $this->action(function (): void {
            $result = $this->process(static function (Model $record): bool {
                $bannable = static::resolveBannable($record);

                if (! $bannable) {
                    return false;
                }

                $bannable->unban();

                return true;
            });

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
     * Resolve the bannable model to unban, whether this action is mounted on a
     * bannable model directly, or on a ban record (e.g. the bundled Banhammer resource).
     */
    public static function resolveBannable(Model $record): ?Model
    {
        if (method_exists($record, 'unban')) {
            return $record;
        }

        return $record->bannable ?? null;
    }
}
