<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactMessageResource\Pages;
use App\Mail\ContactReplyMail;
use App\Models\ContactMessage;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Mail;

class ContactMessageResource extends Resource
{
    protected static ?string $model = ContactMessage::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-envelope';

    protected static string|\UnitEnum|null $navigationGroup = 'Boîte de réception';

    protected static ?string $navigationLabel = 'Messages';

    protected static ?string $modelLabel = 'Message';
    protected static ?string $pluralModelLabel = 'Messages';

    protected static ?int $navigationSort = 30;

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
                Section::make('Le visiteur a écrit :')
                    ->icon('heroicon-o-envelope')
                    ->schema([
                        TextInput::make('name')->label('Nom')->disabled(),
                        TextInput::make('email')->label('Email')->disabled(),
                        TextInput::make('phone')->label('Téléphone')->disabled(),
                        TextInput::make('company')->label('Société')->disabled(),
                        TextInput::make('subject')->label('Sujet')->disabled(),
                        Textarea::make('message')->label('Message')->disabled()->rows(5)->columnSpanFull(),
                    ])->columns(2),

                Section::make('Votre réponse')
                    ->icon('heroicon-o-chat-bubble-left-right')
                    ->description('Rédigez votre réponse ici, puis cliquez sur « Envoyer réponse » dans la liste des messages.')
                    ->schema([
                        Select::make('status')
                            ->label('État du message')
                            ->helperText('Permet de savoir où en est le traitement de ce message.')
                            ->options([
                                'new' => 'Nouveau — pas encore lu',
                                'read' => 'Lu — en attente de réponse',
                                'replied' => 'Répondu',
                                'archived' => 'Archivé',
                                'spam' => 'Indésirable (spam)',
                            ])
                            ->required(),

                        Textarea::make('reply_content')
                            ->label('Votre réponse')
                            ->helperText('Ce texte sera envoyé par email au visiteur.')
                            ->rows(4)
                            ->columnSpanFull(),

                        Textarea::make('admin_notes')
                            ->label('Notes personnelles')
                            ->helperText('Visible uniquement par vous, jamais par le visiteur.')
                            ->rows(2)
                            ->columnSpanFull(),
                    ]),

                Section::make('Informations techniques')
                    ->description('D\'où vient ce message.')
                    ->schema([
                        TextInput::make('source_page')->label('Page d\'origine')->disabled(),
                        TextInput::make('ip_address')->label('Adresse IP')->disabled(),
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
                        'read' => 'Lu',
                        'replied' => 'Répondu',
                        'archived' => 'Archivé',
                        'spam' => 'Spam',
                        default => $state,
                    })
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
                \Filament\Actions\Action::make('sendReply')
                    ->label('Envoyer réponse')
                    ->icon('heroicon-o-paper-airplane')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Envoyer la réponse par email')
                    ->modalDescription(fn ($record) => "Un email sera envoyé à {$record->email}")
                    ->action(function ($record) {
                        Mail::to($record->email)->send(new ContactReplyMail($record));
                        $record->update(['status' => 'replied', 'replied_at' => now()]);
                    })
                    ->visible(fn ($record) => filled($record->reply_content) && $record->status !== 'replied'),
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
                \Filament\Actions\BulkAction::make('markRead')
                    ->label('Marquer lus')
                    ->icon('heroicon-o-eye')
                    ->action(fn ($records) => $records->each->update(['status' => 'read'])),
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
            'index' => Pages\ListContactMessages::route('/'),
            'edit' => Pages\EditContactMessage::route('/{record}/edit'),
        ];
    }
}
