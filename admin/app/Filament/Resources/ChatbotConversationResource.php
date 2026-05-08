<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ChatbotConversationResource\Pages;
use App\Models\ChatbotConversation;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class ChatbotConversationResource extends Resource
{
    protected static ?string $model = ChatbotConversation::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-chat-bubble-bottom-center-text';

    protected static string|\UnitEnum|null $navigationGroup = 'Chatbot';

    protected static ?string $navigationLabel = 'Conversations';

    protected static ?string $modelLabel = 'Conversation';
    protected static ?string $pluralModelLabel = 'Conversations';

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

    public static function getNavigationBadge(): ?string
    {
        $count = ChatbotConversation::where('is_lead', true)
            ->where('lead_captured_at', '>=', now()->subDays(7))
            ->count();
        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'success';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Conversation')
                ->schema([
                    TextInput::make('session_id')->label('Session ID')->disabled(),
                    TextInput::make('messages_count')->label('Messages')->disabled(),
                    TextInput::make('total_cost_eur')->label('Coût (€)')->disabled(),
                    TextInput::make('referrer_url')->label('Page d\'origine')->disabled(),
                    TextInput::make('last_activity_at')->label('Dernière activité')->disabled(),
                ])->columns(2),

            Section::make('Lead')
                ->schema([
                    Toggle::make('is_lead')->label('Marquer comme lead'),
                    TextInput::make('lead_email')->label('Email')->email(),
                    TextInput::make('lead_name')->label('Nom'),
                    Textarea::make('lead_note')->label('Note interne')->rows(3),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('#')->sortable(),
                Tables\Columns\IconColumn::make('is_lead')
                    ->label('Lead')
                    ->boolean()
                    ->trueColor('success'),
                Tables\Columns\TextColumn::make('messages_count')->label('Msg')->sortable(),
                Tables\Columns\TextColumn::make('total_cost_eur')
                    ->label('Coût')
                    ->money('EUR', divideBy: 1)
                    ->formatStateUsing(fn ($state) => number_format((float) $state, 4) . ' €')
                    ->sortable(),
                Tables\Columns\TextColumn::make('lead_email')
                    ->label('Email lead')
                    ->placeholder('—'),
                Tables\Columns\TextColumn::make('referrer_url')
                    ->label('Page d\'origine')
                    ->limit(35)
                    ->placeholder('—'),
                Tables\Columns\TextColumn::make('last_activity_at')
                    ->label('Activité')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_lead')->label('Lead seulement'),
                Tables\Filters\Filter::make('has_email')
                    ->label('Avec email')
                    ->query(fn ($q) => $q->whereNotNull('lead_email')),
            ])
            ->defaultSort('last_activity_at', 'desc')
            ->recordActions([
                \Filament\Actions\ViewAction::make()->label('Voir'),
                \Filament\Actions\EditAction::make()->label('Lead'),
                \Filament\Actions\DeleteAction::make(),
            ])
            ->toolbarActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListChatbotConversations::route('/'),
            'view'  => Pages\ViewChatbotConversation::route('/{record}'),
            'edit'  => Pages\EditChatbotConversation::route('/{record}/edit'),
        ];
    }
}
