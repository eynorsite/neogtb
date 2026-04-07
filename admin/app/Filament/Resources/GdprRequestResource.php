<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GdprRequestResource\Pages;
use App\Mail\GdprResponseMail;
use App\Models\GdprRequest;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Mail;

class GdprRequestResource extends Resource
{
    protected static ?string $model = GdprRequest::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-shield-check';

    protected static string|\UnitEnum|null $navigationGroup = 'Boîte de réception';

    protected static ?string $navigationLabel = 'Droits visiteurs (RGPD)';

    protected static ?string $modelLabel = 'Demande RGPD';
    protected static ?string $pluralModelLabel = 'Demandes RGPD';

    protected static ?int $navigationSort = 40;

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
        $count = GdprRequest::where('status', 'pending')->count();

        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        $hasOverdue = GdprRequest::where('status', 'pending')
            ->where('created_at', '<', now()->subDays(30))
            ->exists();

        return $hasOverdue ? 'danger' : 'warning';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Ce que demande le visiteur')
                    ->icon('heroicon-o-shield-check')
                    ->description('Les visiteurs ont le droit de demander l\'accès, la modification ou la suppression de leurs données. Vous avez 30 jours pour répondre.')
                    ->schema([
                        Select::make('type')
                            ->label('Type de demande')
                            ->options([
                                'access' => 'Voir ses données',
                                'deletion' => 'Supprimer ses données',
                                'portability' => 'Récupérer ses données',
                                'rectification' => 'Corriger ses données',
                                'opposition' => 'S\'opposer au traitement',
                            ])
                            ->disabled(),

                        TextInput::make('name')
                            ->label('Nom')
                            ->disabled(),

                        TextInput::make('email')
                            ->label('Email')
                            ->disabled(),

                        Textarea::make('message')
                            ->label('Sa demande')
                            ->disabled()
                            ->rows(4)
                            ->columnSpanFull(),
                    ])->columns(2),

                Section::make('Votre réponse')
                    ->icon('heroicon-o-chat-bubble-left-right')
                    ->schema([
                        Select::make('status')
                            ->label('Où en est le traitement ?')
                            ->options([
                                'pending' => 'En attente — pas encore traité',
                                'processing' => 'En cours de traitement',
                                'completed' => 'Terminé',
                                'rejected' => 'Refusé',
                            ])
                            ->required(),

                        Textarea::make('response_content')
                            ->label('Réponse au visiteur')
                            ->rows(4)
                            ->columnSpanFull()
                            ->helperText('Ce texte sera envoyé par email au visiteur quand vous cliquerez sur « Envoyer réponse ».'),

                        Textarea::make('admin_notes')
                            ->label('Notes personnelles')
                            ->helperText('Visible uniquement par vous.')
                            ->rows(2)
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('type')
                    ->label('Type')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'access' => 'Accès',
                        'deletion' => 'Effacement',
                        'portability' => 'Portabilité',
                        'rectification' => 'Rectification',
                        'opposition' => 'Opposition',
                        default => $state,
                    })
                    ->badge()
                    ->colors([
                        'info' => 'access',
                        'danger' => 'deletion',
                        'warning' => 'portability',
                        'primary' => 'rectification',
                        'gray' => 'opposition',
                    ]),

                Tables\Columns\TextColumn::make('status')
                    ->label('Statut')
                    ->badge()
                    ->colors([
                        'danger' => 'pending',
                        'warning' => 'processing',
                        'success' => 'completed',
                        'gray' => 'rejected',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'En attente',
                        'processing' => 'En cours',
                        'completed' => 'Traitée',
                        'rejected' => 'Rejetée',
                        default => $state,
                    }),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->formatStateUsing(fn ($record) => $record->getMaskedEmail())
                    ->searchable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Reçue le')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->description(fn ($record) => $record->isOverdue() ? 'DÉLAI DÉPASSÉ' : null)
                    ->color(fn ($record) => $record->isOverdue() ? 'danger' : null),

                Tables\Columns\TextColumn::make('processed_at')
                    ->label('Traitée le')
                    ->dateTime('d/m/Y H:i')
                    ->placeholder('—'),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Statut')
                    ->options([
                        'pending' => 'En attente',
                        'processing' => 'En cours',
                        'completed' => 'Traitée',
                        'rejected' => 'Rejetée',
                    ]),
                Tables\Filters\SelectFilter::make('type')
                    ->label('Type')
                    ->options([
                        'access' => 'Accès',
                        'deletion' => 'Effacement',
                        'portability' => 'Portabilité',
                        'rectification' => 'Rectification',
                        'opposition' => 'Opposition',
                    ]),
            ])
            ->actions([
                \Filament\Actions\EditAction::make(),
                \Filament\Actions\Action::make('markProcessing')
                    ->label('Prendre en charge')
                    ->icon('heroicon-o-play')
                    ->color('warning')
                    ->action(function ($record) {
                        $record->update([
                            'status' => 'processing',
                            'processed_by' => auth()->guard('admin')->id(),
                        ]);
                    })
                    ->visible(fn ($record) => $record->status === 'pending'),
                \Filament\Actions\Action::make('sendResponse')
                    ->label('Envoyer réponse')
                    ->icon('heroicon-o-paper-airplane')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Envoyer la réponse RGPD par email')
                    ->action(function ($record) {
                        Mail::to($record->email)->send(new GdprResponseMail($record));
                        $record->update([
                            'status' => 'completed',
                            'processed_at' => now(),
                            'response_sent_at' => now(),
                            'processed_by' => auth()->guard('admin')->id(),
                        ]);
                    })
                    ->visible(fn ($record) => filled($record->response_content) && $record->status !== 'completed'),
                \Filament\Actions\Action::make('markCompleted')
                    ->label('Marquer traitée')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->action(function ($record) {
                        $record->update([
                            'status' => 'completed',
                            'processed_at' => now(),
                            'processed_by' => auth()->guard('admin')->id(),
                        ]);
                    })
                    ->visible(fn ($record) => in_array($record->status, ['pending', 'processing'])),
            ])
            ->bulkActions([
                \Filament\Actions\BulkAction::make('markProcessing')
                    ->label('Prendre en charge')
                    ->icon('heroicon-o-play')
                    ->action(fn ($records) => $records->each(fn ($r) => $r->update([
                        'status' => 'processing',
                        'processed_by' => auth()->guard('admin')->id(),
                    ]))),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGdprRequests::route('/'),
            'edit' => Pages\EditGdprRequest::route('/{record}/edit'),
        ];
    }
}
