<?php

namespace Gerenuk\FilamentBanhammer\Resources;

use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\ExportBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Gerenuk\FilamentBanhammer\Resources\Actions\EditBanAction;
use Gerenuk\FilamentBanhammer\Resources\Actions\EditBanBulkAction;
use Gerenuk\FilamentBanhammer\Resources\Actions\UnbanAction;
use Gerenuk\FilamentBanhammer\Resources\Actions\UnbanBulkAction;
use Gerenuk\FilamentBanhammer\Resources\BanhammerResource\Pages;

class BanhammerResource extends Resource
{
    protected static ?string $label = 'Bans';

    protected static ?string $slug = 'bans';

    protected static ?string $navigationGroup = 'Admin';

    protected static ?string $navigationIcon = 'heroicon-o-no-symbol';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('bannable_type')
                    ->label('Type')
                    ->toggleable(),
                TextColumn::make('bannable')
                    ->label('Name')
                    ->searchable()
                    ->formatStateUsing(function ($record) {
                        return $record->bannable->getFilamentBanhammerTitleAttribute() ?? '-';
                    }),
                TextColumn::make('ip')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_by_id')
                    ->label('Banned by')
                    ->searchable()
                    ->formatStateUsing(function ($record) {
                        return $record->createdBy->name ?? '-';
                    }),
                TextColumn::make('comment')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('expired_at')
                    ->dateTime()
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->label('Banned at')
                    ->toggleable(),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                DateRangeFilter::make('expired_at'),
                DateRangeFilter::make('created_at'),
                DateRangeFilter::make('updated_at'),
            ])
            ->actions([
                ActionGroup::make([
                    EditBanAction::make(),
                    UnbanAction::make(),
                ])->tooltip('Actions'),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    ExportBulkAction::make()
                        ->visible(config('filament-banhammer.show_export')),
                    EditBanBulkAction::make(),
                    UnbanBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBanhammers::route('/'),
        ];
    }

    public static function getModel(): string
    {
        return config('ban.model');
    }
}
