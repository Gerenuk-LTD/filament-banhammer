<?php

namespace Gerenuk\FilamentBanhammer\Exports;

use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class BanExporter extends Exporter
{
    protected static ?string $model = null;

    public static function getModel(): string
    {
        return static::$model ??= config('ban.model');
    }

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id'),
            ExportColumn::make('bannable_type')
                ->label('Type'),
            ExportColumn::make('bannable_id')
                ->label('Bannable ID'),
            ExportColumn::make('ip'),
            ExportColumn::make('created_by_type')
                ->label('Banned by type'),
            ExportColumn::make('created_by_id')
                ->label('Banned by ID'),
            ExportColumn::make('comment'),
            ExportColumn::make('expired_at'),
            ExportColumn::make('created_at')
                ->label('Banned at'),
            ExportColumn::make('updated_at'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $failedRowsCount = $export->getFailedRowsCount();

        $body = 'Your ban export has completed and '.number_format($export->successful_rows).' '.str('row')->plural($export->successful_rows).' exported.';

        if ($failedRowsCount > 0) {
            $body .= ' '.number_format($failedRowsCount).' '.str('row')->plural($failedRowsCount).' failed to export.';
        }

        return $body;
    }
}
