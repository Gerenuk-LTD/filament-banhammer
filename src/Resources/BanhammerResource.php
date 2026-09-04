<?php

namespace Gerenuk\FilamentBanhammer\Resources;

use BackedEnum;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\ExportBulkAction;
use Filament\Forms\Components\DatePicker;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Gerenuk\FilamentBanhammer\Resources\Actions\EditBanAction;
use Gerenuk\FilamentBanhammer\Resources\Actions\EditBanBulkAction;
use Gerenuk\FilamentBanhammer\Resources\Actions\UnbanAction;
use Gerenuk\FilamentBanhammer\Resources\Actions\UnbanBulkAction;
use Gerenuk\FilamentBanhammer\Resources\BanhammerResource\Pages;
use Illuminate\Database\Eloquent\Builder;

class BanhammerResource extends Resource
{
    protected static ?string $modelLabel = 'Ban';

    protected static ?string $pluralModelLabel = 'Bans';

    protected static ?string $slug = 'bans';

    public static function getNavigationGroup(): ?string
    {
        return config('filament-banhammer.navigation_group');
    }

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-no-symbol';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->with(['bannable', 'createdBy']))
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
                        return $record->bannable?->getFilamentBanhammerTitleAttribute() ?? '-';
                    }),
                TextColumn::make('ip')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_by_id')
                    ->label('Banned by')
                    ->searchable()
                    ->formatStateUsing(function ($record) {
                        return $record->createdBy?->name ?? '-';
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
                Filter::make('expired_at')
                    ->schema([
                        DatePicker::make('unbanned_at'),
                    ])
                    ->query(function (Builder $query, array $data) {
                        return $query
                            ->when($data['unbanned_at'],
                                fn (Builder $query, $date): Builder => $query->whereDate('expired_at', '=', $date));
                    }),
                Filter::make('created_at')
                    ->schema([
                        DatePicker::make('banned_at'),
                    ])
                    ->query(function (Builder $query, array $data) {
                        return $query
                            ->when($data['banned_at'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '=', $date));
                    }),
            ])
            ->recordActions([
                ActionGroup::make([
                    EditBanAction::make(),
                    UnbanAction::make(),
                ])->tooltip('Actions'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    ExportBulkAction::make()
                        ->exporter(config('filament-banhammer.exporter'))
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
