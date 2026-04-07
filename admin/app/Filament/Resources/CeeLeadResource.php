<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CeeLeadResource\Pages;
use App\Models\CeeLead;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class CeeLeadResource extends Resource
{
    protected static ?string $model = CeeLead::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-banknotes';

    protected static string|\UnitEnum|null $navigationGroup = 'Boîte de réception';

    protected static ?string $navigationLabel = 'Leads CEE';

    protected static ?string $modelLabel = 'Lead CEE';
    protected static ?string $pluralModelLabel = 'Leads CEE';

    protected static ?int $navigationSort = 32;

    public static function canAccess(): bool
    {
        $admin = auth()->guard('admin')->user();
        return $admin && in_array($admin->role, ['superadmin', 'admin']);
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit(\Illuminate\Database\Eloquent\Model $record): bool
    {
        $admin = auth()->guard('admin')->user();
        return $admin && in_array($admin->role, ['superadmin', 'admin']);
    }

    public static function canDelete(\Illuminate\Database\Eloquent\Model $record): bool
    {
        $admin = auth()->guard('admin')->user();
        return $admin && $admin->role === 'superadmin';
    }

    public static function getNavigationBadge(): ?string
    {
        $count = CeeLead::where('status', 'new')->count();

        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'danger';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Visiteur')
                    ->icon('heroicon-o-user')
                    ->schema([
                        TextInput::make('email')->label('Email')->disabled(),
                    ]),

                Section::make('Estimation CEE')
                    ->icon('heroicon-o-calculator')
                    ->schema([
                        TextInput::make('th116_mwh')->label('TH-116 (MWh cumac)')->disabled(),
                        TextInput::make('th116_value')->label('Valeur (€)')->disabled(),
                        TextInput::make('sector')->label('Secteur')->disabled(),
                        TextInput::make('surface')->label('Surface (m²)')->disabled(),
                        TextInput::make('climate_zone')->label('Zone climatique')->disabled(),
                    ])->columns(3),

                Section::make('Suivi commercial')
                    ->icon('heroicon-o-flag')
                    ->schema([
                        Select::make('status')
                            ->label('État')
                            ->options([
                                'new' => 'Nouveau',
                                'contacted' => 'Contacté',
                                'qualified' => 'Qualifié',
                                'won' => 'Gagné',
                                'lost' => 'Perdu',
                                'archived' => 'Archivé',
                            ])
                            ->required(),
                    ]),

                Section::make('Données techniques')
                    ->schema([
                        TextInput::make('ip_address')->label('Adresse IP')->disabled(),
                        Textarea::make('payload')
                            ->label('Payload complet (JSON)')
                            ->disabled()
                            ->rows(8)
                            ->formatStateUsing(fn ($state) => is_array($state) ? json_encode($state, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) : $state)
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->collapsed(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('status')
                    ->label('État')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'new' => 'Nouveau',
                        'contacted' => 'Contacté',
                        'qualified' => 'Qualifié',
                        'won' => 'Gagné',
                        'lost' => 'Perdu',
                        'archived' => 'Archivé',
                        default => $state,
                    })
                    ->colors([
                        'danger' => 'new',
                        'warning' => 'contacted',
                        'primary' => 'qualified',
                        'success' => 'won',
                        'gray' => ['lost', 'archived'],
                    ]),

                Tables\Columns\TextColumn::make('email')->searchable(),
                Tables\Columns\TextColumn::make('sector')->label('Secteur')->searchable(),
                Tables\Columns\TextColumn::make('surface')->label('Surface m²')->sortable(),
                Tables\Columns\TextColumn::make('th116_value')->label('Valeur CEE')->money('EUR')->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Reçu le')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'new' => 'Nouveau',
                        'contacted' => 'Contacté',
                        'qualified' => 'Qualifié',
                        'won' => 'Gagné',
                        'lost' => 'Perdu',
                        'archived' => 'Archivé',
                    ]),
            ])
            ->actions([
                \Filament\Actions\EditAction::make(),
                \Filament\Actions\Action::make('markContacted')
                    ->label('Marquer contacté')
                    ->icon('heroicon-o-phone')
                    ->action(fn ($record) => $record->update(['status' => 'contacted']))
                    ->visible(fn ($record) => $record->status === 'new'),
            ])
            ->bulkActions([
                \Filament\Actions\BulkAction::make('archive')
                    ->label('Archiver')
                    ->icon('heroicon-o-archive-box')
                    ->action(fn ($records) => $records->each->update(['status' => 'archived'])),
                \Filament\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCeeLeads::route('/'),
            'edit' => Pages\EditCeeLead::route('/{record}/edit'),
        ];
    }
}
