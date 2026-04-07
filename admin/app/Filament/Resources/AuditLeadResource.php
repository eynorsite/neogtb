<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AuditLeadResource\Pages;
use App\Models\AuditLead;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class AuditLeadResource extends Resource
{
    protected static ?string $model = AuditLead::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-clipboard-document-check';

    protected static string|\UnitEnum|null $navigationGroup = 'Boîte de réception';

    protected static ?string $navigationLabel = 'Leads diagnostic GTB';

    protected static ?string $modelLabel = 'Lead diagnostic';
    protected static ?string $pluralModelLabel = 'Leads diagnostic';

    protected static ?int $navigationSort = 31;

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
        $count = AuditLead::where('status', 'new')->count();

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
                Section::make('Informations du visiteur')
                    ->icon('heroicon-o-user')
                    ->schema([
                        TextInput::make('email')->label('Email')->disabled(),
                        TextInput::make('name')->label('Nom')->disabled(),
                        TextInput::make('company')->label('Société')->disabled(),
                    ])->columns(3),

                Section::make('Résultat du diagnostic')
                    ->icon('heroicon-o-chart-bar')
                    ->schema([
                        TextInput::make('score')->label('Score / 100')->disabled(),
                        TextInput::make('level_label')->label('Niveau')->disabled(),
                        TextInput::make('building_type')->label('Type de bâtiment')->disabled(),
                        TextInput::make('surface')->label('Surface (m²)')->disabled(),
                        TextInput::make('savings_euro')->label('Économies estimées (€/an)')->disabled(),
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
                Tables\Columns\TextColumn::make('name')->label('Nom')->searchable(),
                Tables\Columns\TextColumn::make('company')->label('Société')->searchable(),
                Tables\Columns\TextColumn::make('score')->label('Score')->sortable(),
                Tables\Columns\TextColumn::make('savings_euro')->label('Éco. €/an')->money('EUR')->sortable(),
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
            'index' => Pages\ListAuditLeads::route('/'),
            'edit' => Pages\EditAuditLead::route('/{record}/edit'),
        ];
    }
}
