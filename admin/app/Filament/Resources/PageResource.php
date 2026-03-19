<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageResource\Pages;
use App\Models\SitePage;
use Filament\Forms\Components\FileUpload;
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
    protected static ?string $pluralModelLabel = 'Pages';

    protected static ?int $navigationSort = 10;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Tabs')
                    ->tabs([
                        Tabs\Tab::make('Page')
                            ->schema([
                                TextInput::make('name')
                                    ->label('Nom de la page')
                                    ->required()
                                    ->maxLength(255),

                                TextInput::make('slug')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(255),

                                Toggle::make('is_published')
                                    ->label('Publiée')
                                    ->default(true),

                                TextInput::make('order')
                                    ->label('Ordre')
                                    ->numeric()
                                    ->default(0),
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
                \Filament\Actions\Action::make('edit_content')
                    ->label('Contenu')
                    ->icon('heroicon-o-pencil-square')
                    ->color('success')
                    ->url(fn ($record) => url('/admin/pages/' . $record->id . '/bricks-editor')),
                \Filament\Actions\EditAction::make()
                    ->label('Paramètres'),
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
