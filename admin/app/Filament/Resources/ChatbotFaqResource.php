<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ChatbotFaqResource\Pages;
use App\Models\ChatbotFaq;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class ChatbotFaqResource extends Resource
{
    protected static ?string $model = ChatbotFaq::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-question-mark-circle';

    protected static string|\UnitEnum|null $navigationGroup = 'Chatbot';

    protected static ?string $navigationLabel = 'FAQ';

    protected static ?string $modelLabel = 'FAQ';
    protected static ?string $pluralModelLabel = 'FAQ';

    protected static ?int $navigationSort = 30;

    public static function canAccess(): bool
    {
        $admin = auth()->guard('admin')->user();
        return $admin && in_array($admin->role, ['superadmin', 'admin']);
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Question fréquente')
                ->description('Le bot privilégie une réponse exacte issue d\'une FAQ avant de générer une réponse libre.')
                ->schema([
                    TextInput::make('question')
                        ->label('Question')
                        ->required()
                        ->maxLength(255),
                    Textarea::make('answer')
                        ->label('Réponse exacte')
                        ->required()
                        ->rows(5),
                    TextInput::make('category')
                        ->label('Catégorie')
                        ->maxLength(60),
                    TagsInput::make('keywords')
                        ->label('Mots-clés (matching)')
                        ->placeholder('bacs, décret, seuil…'),
                    TextInput::make('sort_order')
                        ->label('Ordre d\'affichage')
                        ->numeric()
                        ->default(0),
                    Toggle::make('show_as_suggestion')
                        ->label('Afficher comme question suggérée à l\'ouverture')
                        ->default(false),
                    Toggle::make('is_active')
                        ->label('Actif')
                        ->default(true),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('question')->label('Question')->limit(60)->searchable(),
                Tables\Columns\TextColumn::make('category')->label('Catégorie')->badge(),
                Tables\Columns\IconColumn::make('show_as_suggestion')->label('Suggérée')->boolean(),
                Tables\Columns\IconColumn::make('is_active')->label('Active')->boolean(),
                Tables\Columns\TextColumn::make('sort_order')->label('Ordre')->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')->label('Active'),
                Tables\Filters\TernaryFilter::make('show_as_suggestion')->label('Suggestion'),
            ])
            ->defaultSort('sort_order')
            ->recordActions([
                \Filament\Actions\EditAction::make(),
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
            'index'  => Pages\ListChatbotFaqs::route('/'),
            'create' => Pages\CreateChatbotFaq::route('/create'),
            'edit'   => Pages\EditChatbotFaq::route('/{record}/edit'),
        ];
    }
}
