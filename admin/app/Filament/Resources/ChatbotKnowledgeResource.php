<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ChatbotKnowledgeResource\Pages;
use App\Models\ChatbotKnowledgeSnippet;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class ChatbotKnowledgeResource extends Resource
{
    protected static ?string $model = ChatbotKnowledgeSnippet::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-book-open';

    protected static string|\UnitEnum|null $navigationGroup = 'Chatbot';

    protected static ?string $navigationLabel = 'Base de connaissances';

    protected static ?string $modelLabel = 'Snippet';
    protected static ?string $pluralModelLabel = 'Snippets';

    protected static ?int $navigationSort = 20;

    public static function canAccess(): bool
    {
        $admin = auth()->guard('admin')->user();
        return $admin && in_array($admin->role, ['superadmin', 'admin']);
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Snippet de connaissances')
                ->description('Bloc de texte injecté dans le prompt système du bot. Plus il y a de snippets actifs, plus le bot a de matière. Garder concis (max 500 mots par snippet).')
                ->schema([
                    TextInput::make('title')
                        ->label('Titre')
                        ->required()
                        ->maxLength(120)
                        ->placeholder('ex: Décret BACS — résumé'),
                    TextInput::make('category')
                        ->label('Catégorie')
                        ->placeholder('Décret / Services / Technique / Tarifs…')
                        ->maxLength(60),
                    Textarea::make('content')
                        ->label('Contenu')
                        ->required()
                        ->rows(10)
                        ->placeholder('Texte que le bot pourra citer dans ses réponses.'),
                    TagsInput::make('tags')
                        ->label('Tags (recherche)')
                        ->placeholder('Ajouter un tag…'),
                    TextInput::make('priority')
                        ->label('Priorité (0-100)')
                        ->numeric()
                        ->default(0)
                        ->helperText('Plus la priorité est haute, plus le snippet apparaît tôt dans le prompt.'),
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
                Tables\Columns\TextColumn::make('title')
                    ->label('Titre')
                    ->searchable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('category')
                    ->label('Catégorie')
                    ->badge()
                    ->searchable(),
                Tables\Columns\TextColumn::make('priority')
                    ->label('Priorité')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Actif')
                    ->boolean(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('MAJ')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')->label('Actif'),
                Tables\Filters\SelectFilter::make('category')
                    ->options(fn () => ChatbotKnowledgeSnippet::query()
                        ->whereNotNull('category')
                        ->distinct()
                        ->pluck('category', 'category')
                        ->toArray()),
            ])
            ->defaultSort('priority', 'desc')
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
            'index'  => Pages\ListChatbotKnowledge::route('/'),
            'create' => Pages\CreateChatbotKnowledge::route('/create'),
            'edit'   => Pages\EditChatbotKnowledge::route('/{record}/edit'),
        ];
    }
}
