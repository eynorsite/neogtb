<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageResource\Pages;
use App\Models\SitePage;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class PageResource extends Resource
{
    protected static ?string $model = SitePage::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-document-text';

    protected static string|\UnitEnum|null $navigationGroup = 'Contenu';

    protected static ?string $navigationLabel = 'Pages';

    protected static ?string $modelLabel = 'Page';

    protected static ?int $navigationSort = 10;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Tabs')
                    ->tabs([
                        Tabs\Tab::make('Contenu')
                            ->schema([
                                TextInput::make('name')
                                    ->label('Nom de la page')
                                    ->required()
                                    ->maxLength(255),

                                TextInput::make('slug')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(255),

                                TextInput::make('hero_title')
                                    ->label('Titre Hero')
                                    ->maxLength(255),

                                TextInput::make('hero_subtitle')
                                    ->label('Sous-titre Hero')
                                    ->maxLength(255),

                                Textarea::make('hero_description')
                                    ->label('Description Hero')
                                    ->rows(3),

                                TextInput::make('hero_cta_text')
                                    ->label('Texte du bouton CTA')
                                    ->maxLength(255),

                                TextInput::make('hero_cta_url')
                                    ->label('URL du bouton CTA')
                                    ->maxLength(255),

                                FileUpload::make('hero_image')
                                    ->label('Image Hero')
                                    ->image()
                                    ->directory('pages'),

                                Toggle::make('is_published')
                                    ->label('Publiée')
                                    ->default(true),

                                TextInput::make('order')
                                    ->label('Ordre')
                                    ->numeric()
                                    ->default(0),
                            ]),

                        Tabs\Tab::make('Sections')
                            ->schema([
                                Repeater::make('sections')
                                    ->relationship()
                                    ->schema([
                                        TextInput::make('section_key')
                                            ->label('Clé de section')
                                            ->required(),

                                        TextInput::make('title')
                                            ->label('Titre'),

                                        TextInput::make('subtitle')
                                            ->label('Sous-titre'),

                                        RichEditor::make('content')
                                            ->label('Contenu'),

                                        FileUpload::make('image')
                                            ->image()
                                            ->directory('sections'),

                                        TextInput::make('order')
                                            ->label('Ordre')
                                            ->numeric()
                                            ->default(0),

                                        Toggle::make('is_visible')
                                            ->label('Visible')
                                            ->default(true),
                                    ])
                                    ->columns(2)
                                    ->collapsible()
                                    ->orderColumn('order')
                                    ->itemLabel(fn (array $state) => $state['title'] ?? $state['section_key'] ?? 'Section'),
                            ]),

                        Tabs\Tab::make('SEO')
                            ->schema([
                                TextInput::make('meta_title')
                                    ->label('Meta Title')
                                    ->maxLength(70)
                                    ->helperText('Max 70 caractères'),

                                Textarea::make('meta_description')
                                    ->label('Meta Description')
                                    ->rows(2)
                                    ->helperText('Max 160 caractères'),

                                TextInput::make('meta_keywords')
                                    ->label('Meta Keywords'),

                                TextInput::make('og_title')
                                    ->label('OG Title'),

                                Textarea::make('og_description')
                                    ->label('OG Description')
                                    ->rows(2),

                                FileUpload::make('og_image')
                                    ->label('OG Image')
                                    ->image()
                                    ->directory('og'),
                            ]),
                    ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Page')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),

                Tables\Columns\IconColumn::make('is_published')
                    ->label('Publiée')
                    ->boolean(),

                Tables\Columns\TextColumn::make('order')
                    ->label('Ordre')
                    ->sortable(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Modifiée le')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('order')
            ->reorderable('order')
            ->actions([
                \Filament\Actions\EditAction::make(),
            ])
            ->bulkActions([
                \Filament\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
        ];
    }
}
