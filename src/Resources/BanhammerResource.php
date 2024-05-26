<?php

namespace Gerenuk\FilamentBanhammer\Resources;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
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
            ->schema([
                Section::make('Fields')
                    ->schema([
                        TextInput::make('comment')
                            ->nullable()
                            ->columnSpanFull(),
                        DateTimePicker::make('expired_at')
                            ->label('Expires at')
                            ->nullable()
                            ->columnSpanFull(),
                    ])
                    ->columns()
                    ->columnSpan(3)
                    ->collapsible(),
                Section::make('Meta')
                    ->schema([
                        // TOOD: add meta ability.
                    ])
                    ->columns()
                    ->columnSpan(2)
                    ->collapsible(),
            ])->columns(5);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->toggleable(isToggledHiddenByDefault: true),
                //                TextColumn::make('bannable_type')
                //                    ->label('Type'), // Only banning users for now
                TextColumn::make('bannable.name')
                    ->label('Name')
                    ->searchable(),
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
                    ->toggleable(isToggledHiddenByDefault: true),
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
                    EditAction::make(),
                    Action::make('unban')
                        ->requiresConfirmation()
                        ->action(function (Model $record): void {
                            $record->bannable->unban();

                            Notification::make()
                                ->success()
                                ->title('Unbanned')
                                ->send();
                        })
                        ->color('warning')
                        ->icon('heroicon-o-no-symbol'),
                ])->tooltip('Actions'),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    ExportBulkAction::make(),
                    BulkAction::make('unban')
                        ->requiresConfirmation()
                        ->action(function (Collection $records): void {
                            foreach ($records as $record) {
                                $record->bannable->unban();
                            }

                            Notification::make()
                                ->success()
                                ->title('Unbanned')
                                ->send();
                        })
                        ->deselectRecordsAfterCompletion()
                        ->color('warning')
                        ->icon('heroicon-o-no-symbol'),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBanhammers::route('/'),
            'edit' => Pages\EditBanhammer::route('/{record}/edit'),
        ];
    }

    public static function getModel(): string
    {
        return config('ban.model');
    }
}
