<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Models\Post;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-newspaper';

    protected static string|\UnitEnum|null $navigationGroup = 'Blog';

    protected static ?string $navigationLabel = 'Articles';

    protected static ?string $modelLabel = 'Article';
    protected static ?string $pluralModelLabel = 'Articles';

    protected static ?int $navigationSort = 20;

    public static function canAccess(): bool
    {
        $admin = auth()->guard('admin')->user();
        return $admin && in_array($admin->role, ['superadmin', 'admin', 'editeur']);
    }

    public static function canCreate(): bool
    {
        $admin = auth()->guard('admin')->user();
        return $admin && in_array($admin->role, ['superadmin', 'admin', 'editeur']);
    }

    public static function canEdit(\Illuminate\Database\Eloquent\Model $record): bool
    {
        $admin = auth()->guard('admin')->user();
        return $admin && in_array($admin->role, ['superadmin', 'admin', 'editeur']);
    }

    public static function canDelete(\Illuminate\Database\Eloquent\Model $record): bool
    {
        $admin = auth()->guard('admin')->user();
        return $admin && in_array($admin->role, ['superadmin', 'admin']);
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()->with(['category', 'author', 'tags']);
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Tabs')
                    ->tabs([
                        Tabs\Tab::make('Rédaction')
                            ->icon('heroicon-o-pencil')
                            ->schema([
                                TextInput::make('title')
                                    ->label('Titre de l\'article')
                                    ->helperText('Le titre principal visible par vos lecteurs.')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),

                                TextInput::make('slug')
                                    ->label('Adresse web')
                                    ->helperText('Se remplit automatiquement à partir du titre.')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(255)
                                    ->prefix('neogtb.fr/blog/'),

                                Textarea::make('excerpt')
                                    ->label('Résumé')
                                    ->rows(3)
                                    ->helperText('2-3 phrases qui donnent envie de lire l\'article. Apparaît dans la liste du blog.'),

                                RichEditor::make('content')
                                    ->label('Contenu de l\'article')
                                    ->columnSpanFull(),
                            ]),

                        Tabs\Tab::make('Images')
                            ->icon('heroicon-o-photo')
                            ->schema([
                                FileUpload::make('featured_image')
                                    ->disk('public')
                                    ->label('Image principale')
                                    ->helperText('L\'image affichée en haut de l\'article et dans la liste du blog.')
                                    ->image()
                                    ->directory('posts')
                                    ->maxSize(5120),

                                FileUpload::make('og_image')
                                    ->disk('public')
                                    ->label('Image de partage (réseaux sociaux)')
                                    ->helperText('Si vide, l\'image principale sera utilisée. Format idéal : 1200x630px.')
                                    ->image()
                                    ->directory('og'),
                            ]),

                        Tabs\Tab::make('Classement')
                            ->icon('heroicon-o-tag')
                            ->schema([
                                Select::make('category_id')
                                    ->label('Catégorie')
                                    ->helperText('Dans quelle rubrique classer cet article.')
                                    ->relationship('category', 'name')
                                    ->preload()
                                    ->createOptionForm([
                                        TextInput::make('name')->label('Nom')->required(),
                                        TextInput::make('slug')->label('Adresse web')->required(),
                                    ]),

                                Select::make('tags')
                                    ->label('Étiquettes')
                                    ->helperText('Mots-clés pour retrouver l\'article plus facilement.')
                                    ->relationship('tags', 'name')
                                    ->multiple()
                                    ->preload()
                                    ->createOptionForm([
                                        TextInput::make('name')->label('Nom')->required(),
                                        TextInput::make('slug')->label('Adresse web')->required(),
                                    ]),
                            ]),

                        Tabs\Tab::make('Référencement Google')
                            ->icon('heroicon-o-magnifying-glass')
                            ->schema([
                                TextInput::make('meta_title')
                                    ->label('Titre pour Google')
                                    ->helperText('Le titre affiché dans les résultats de recherche. Max 70 caractères.')
                                    ->maxLength(70),

                                Textarea::make('meta_description')
                                    ->label('Description pour Google')
                                    ->helperText('Le texte sous le titre dans Google. Max 160 caractères.')
                                    ->rows(2),
                            ]),

                        Tabs\Tab::make('Publication')
                            ->icon('heroicon-o-arrow-up-on-square')
                            ->schema([
                                Select::make('status')
                                    ->label('État')
                                    ->helperText('Brouillon = visible uniquement ici. Publié = visible sur le site.')
                                    ->options([
                                        'draft' => 'Brouillon',
                                        'published' => 'Publié',
                                        'archived' => 'Archivé',
                                    ])
                                    ->required()
                                    ->default('draft'),

                                DateTimePicker::make('published_at')
                                    ->label('Date de publication')
                                    ->helperText('Se remplit automatiquement quand vous publiez.'),

                                Select::make('author_id')
                                    ->label('Auteur')
                                    ->relationship('author', 'name')
                                    ->default(fn () => auth()->guard('admin')->id()),

                                Toggle::make('is_featured')
                                    ->label('Mettre en avant')
                                    ->helperText('L\'article apparaîtra en premier sur la page blog.'),
                            ]),
                    ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('featured_image')
                    ->label('Image')
                    ->circular(),

                Tables\Columns\TextColumn::make('title')
                    ->label('Titre')
                    ->searchable()
                    ->sortable()
                    ->limit(50),

                Tables\Columns\TextColumn::make('category.name')
                    ->label('Catégorie')
                    ->badge(),

                Tables\Columns\TextColumn::make('status')
                    ->label('État')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'draft' => 'Brouillon',
                        'published' => 'En ligne',
                        'archived' => 'Archivé',
                        default => $state,
                    })
                    ->colors([
                        'gray' => 'draft',
                        'success' => 'published',
                        'warning' => 'archived',
                    ]),

                Tables\Columns\TextColumn::make('author.name')
                    ->label('Auteur'),

                Tables\Columns\TextColumn::make('reading_time')
                    ->label('Lecture')
                    ->suffix(' min')
                    ->sortable(),

                Tables\Columns\TextColumn::make('views_count')
                    ->label('Vues')
                    ->sortable(),

                Tables\Columns\TextColumn::make('published_at')
                    ->label('Publié le')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->placeholder('Non publié'),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'draft' => 'Brouillon',
                        'published' => 'Publié',
                        'archived' => 'Archivé',
                    ]),
                Tables\Filters\SelectFilter::make('category_id')
                    ->label('Catégorie')
                    ->relationship('category', 'name'),
            ])
            ->actions([
                \Filament\Actions\EditAction::make()
                    ->label('Modifier'),
                \Filament\Actions\Action::make('viewOnSite')
                    ->label('Voir sur le site')
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->color('gray')
                    ->url(fn ($record) => "https://neogtb.fr/blog/{$record->slug}", shouldOpenInNewTab: true)
                    ->visible(fn ($record) => $record->status === 'published'),
                \Filament\Actions\ReplicateAction::make()
                    ->label('Dupliquer')
                    ->excludeAttributes(['slug', 'views_count', 'published_at'])
                    ->beforeReplicaSaved(function ($replica) {
                        $replica->slug = $replica->slug . '-copie-' . now()->timestamp;
                        $replica->status = 'draft';
                        $replica->title = $replica->title . ' (copie)';
                    }),
            ])
            ->bulkActions([
                \Filament\Actions\BulkAction::make('publish')
                    ->label('Publier')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->action(fn ($records) => $records->each->update(['status' => 'published', 'published_at' => now()])),
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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
