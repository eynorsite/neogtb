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

    protected static ?int $navigationSort = 20;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Tabs')
                    ->tabs([
                        Tabs\Tab::make('Rédaction')
                            ->schema([
                                TextInput::make('title')
                                    ->label('Titre')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),

                                TextInput::make('slug')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(255),

                                Textarea::make('excerpt')
                                    ->label('Extrait')
                                    ->rows(3)
                                    ->helperText('Résumé court affiché dans les listes'),

                                RichEditor::make('content')
                                    ->label('Contenu')
                                    ->columnSpanFull(),
                            ]),

                        Tabs\Tab::make('Médias')
                            ->schema([
                                FileUpload::make('featured_image')
                                    ->label('Image mise en avant')
                                    ->image()
                                    ->directory('posts')
                                    ->maxSize(5120),

                                FileUpload::make('og_image')
                                    ->label('Image OG (réseaux sociaux)')
                                    ->image()
                                    ->directory('og'),
                            ]),

                        Tabs\Tab::make('Catégorie & Tags')
                            ->schema([
                                Select::make('category_id')
                                    ->label('Catégorie')
                                    ->relationship('category', 'name')
                                    ->preload()
                                    ->createOptionForm([
                                        TextInput::make('name')->required(),
                                        TextInput::make('slug')->required(),
                                    ]),

                                Select::make('tags')
                                    ->label('Tags')
                                    ->relationship('tags', 'name')
                                    ->multiple()
                                    ->preload()
                                    ->createOptionForm([
                                        TextInput::make('name')->required(),
                                        TextInput::make('slug')->required(),
                                    ]),
                            ]),

                        Tabs\Tab::make('SEO')
                            ->schema([
                                TextInput::make('meta_title')
                                    ->label('Meta Title')
                                    ->maxLength(70),

                                Textarea::make('meta_description')
                                    ->label('Meta Description')
                                    ->rows(2),
                            ]),

                        Tabs\Tab::make('Publication')
                            ->schema([
                                Select::make('status')
                                    ->label('Statut')
                                    ->options([
                                        'draft' => 'Brouillon',
                                        'published' => 'Publié',
                                        'archived' => 'Archivé',
                                    ])
                                    ->required()
                                    ->default('draft'),

                                DateTimePicker::make('published_at')
                                    ->label('Date de publication'),

                                Select::make('author_id')
                                    ->label('Auteur')
                                    ->relationship('author', 'name')
                                    ->default(fn () => auth()->guard('admin')->id()),

                                Toggle::make('is_featured')
                                    ->label('Article en vedette'),
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
                    ->label('Statut')
                    ->badge()
                    ->colors([
                        'gray' => 'draft',
                        'success' => 'published',
                        'warning' => 'archived',
                    ]),

                Tables\Columns\TextColumn::make('author.name')
                    ->label('Auteur'),

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
                \Filament\Actions\EditAction::make(),
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
