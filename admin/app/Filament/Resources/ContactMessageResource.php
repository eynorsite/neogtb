<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactMessageResource\Pages;
use App\Models\ContactMessage;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class ContactMessageResource extends Resource
{
    protected static ?string $model = ContactMessage::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-envelope';

    protected static string|\UnitEnum|null $navigationGroup = 'Communication';

    protected static ?string $navigationLabel = 'Messages';

    protected static ?string $modelLabel = 'Message';

    protected static ?int $navigationSort = 30;

    public static function getNavigationBadge(): ?string
    {
        $count = ContactMessage::where('status', 'new')->count();

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
                Section::make('Message')
                    ->schema([
                        TextInput::make('name')->label('Nom')->disabled(),
                        TextInput::make('email')->disabled(),
                        TextInput::make('phone')->label('Téléphone')->disabled(),
                        TextInput::make('company')->label('Société')->disabled(),
                        TextInput::make('subject')->label('Sujet')->disabled(),
                        Textarea::make('message')->disabled()->rows(5)->columnSpanFull(),
                    ])->columns(2),

                Section::make('Gestion')
                    ->schema([
                        Select::make('status')
                            ->label('Statut')
                            ->options([
                                'new' => 'Nouveau',
                                'read' => 'Lu',
                                'replied' => 'Répondu',
                                'archived' => 'Archivé',
                                'spam' => 'Spam',
                            ])
                            ->required(),

                        Textarea::make('reply_content')
                            ->label('Réponse')
                            ->rows(4)
                            ->columnSpanFull(),

                        Textarea::make('admin_notes')
                            ->label('Notes internes')
                            ->rows(2)
                            ->columnSpanFull(),
                    ]),

                Section::make('Métadonnées')
                    ->schema([
                        TextInput::make('source_page')->label('Page source')->disabled(),
                        TextInput::make('ip_address')->label('IP')->disabled(),
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
                    ->label('Statut')
                    ->badge()
                    ->colors([
                        'danger' => 'new',
                        'warning' => 'read',
                        'success' => 'replied',
                        'gray' => 'archived',
                        'primary' => 'spam',
                    ]),

                Tables\Columns\TextColumn::make('name')
                    ->label('Nom')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('email')
                    ->searchable(),

                Tables\Columns\TextColumn::make('subject')
                    ->label('Sujet')
                    ->limit(40),

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
                        'read' => 'Lu',
                        'replied' => 'Répondu',
                        'archived' => 'Archivé',
                        'spam' => 'Spam',
                    ]),
            ])
            ->actions([
                \Filament\Actions\EditAction::make(),
                \Filament\Actions\Action::make('markRead')
                    ->label('Marquer lu')
                    ->icon('heroicon-o-eye')
                    ->action(fn ($record) => $record->update(['status' => 'read']))
                    ->visible(fn ($record) => $record->status === 'new'),
                \Filament\Actions\Action::make('markSpam')
                    ->label('Spam')
                    ->icon('heroicon-o-x-mark')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->action(fn ($record) => $record->update(['status' => 'spam'])),
            ])
            ->bulkActions([
                \Filament\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContactMessages::route('/'),
            'edit' => Pages\EditContactMessage::route('/{record}/edit'),
        ];
    }
}
