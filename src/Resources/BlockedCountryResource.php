<?php

namespace Gerenuk\FilamentBanhammer\Resources;

use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Gerenuk\FilamentBanhammer\Models\BlockedCountry;
use Gerenuk\FilamentBanhammer\Resources\BlockedCountryResource\Pages;

class BlockedCountryResource extends Resource
{
    protected static ?string $model = BlockedCountry::class;

    protected static ?string $modelLabel = 'Blocked Country';

    protected static ?string $pluralModelLabel = 'Blocked Countries';

    protected static ?string $slug = 'blocked-countries';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-globe-alt';

    public static function getNavigationGroup(): ?string
    {
        return config('filament-banhammer.navigation_group');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components(static::codeField());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code'),
                TextColumn::make('created_at')->dateTime(),
            ])
            ->headerActions([
                Action::make('add')
                    ->label('Add country')
                    ->modalHeading('Block a country')
                    ->modalSubmitActionLabel('Add')
                    ->schema(static::codeField())
                    ->action(fn (array $data) => BlockedCountry::create($data)),
            ])
            ->recordActions([
                DeleteAction::make(),
            ])
            ->toolbarActions([
                DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBlockedCountries::route('/'),
        ];
    }

    protected static function codeField(): array
    {
        return [
            TextInput::make('code')
                ->label('Country code')
                ->helperText('The 2-letter ISO 3166-1 alpha-2 code, e.g. "US" or "GB".')
                ->required()
                ->length(2)
                ->alpha()
                // Normalize before validating, so uniqueness is checked against
                // the same casing the BlockedCountry model persists.
                ->live(onBlur: true)
                ->afterStateUpdated(fn (?string $state, callable $set) => $set('code', strtoupper((string) $state)))
                ->unique(table: BlockedCountry::class, ignoreRecord: true),
        ];
    }
}
