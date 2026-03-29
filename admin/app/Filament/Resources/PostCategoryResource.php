<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostCategoryResource\Pages;
use App\Models\PostCategory;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class PostCategoryResource extends Resource
{
    protected static ?string $model = PostCategory::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-tag';

    protected static string|\UnitEnum|null $navigationGroup = 'Blog';

    protected static ?string $navigationLabel = 'Catégories';

    protected static ?string $modelLabel = 'Catégorie';
    protected static ?string $pluralModelLabel = 'Catégories';

    protected static ?int $navigationSort = 25;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nom de la catégorie')
                    ->helperText('Ex : Réglementation, Guides pratiques, Retours d\'expérience...')
                    ->required()
                    ->maxLength(255),

                TextInput::make('slug')
                    ->label('Adresse web')
                    ->helperText('Se remplit automatiquement. Apparaîtra dans l\'URL de la catégorie.')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->prefix('neogtb.fr/blog/'),

                Textarea::make('description')
                    ->label('Description')
                    ->helperText('Courte description de cette catégorie (optionnel).')
                    ->rows(2),

                ColorPicker::make('color')
                    ->label('Couleur du badge')
                    ->helperText('La couleur du petit badge affiché à côté du nom.'),

                TextInput::make('icon')
                    ->label('Icône (optionnel)')
                    ->helperText('Nom technique de l\'icône (ex : heroicon-o-bolt). Laissez vide si vous ne savez pas.'),

                TextInput::make('order')
                    ->label('Position dans la liste')
                    ->helperText('Numéro pour trier (0 = en premier).')
                    ->numeric()
                    ->default(0),

                Toggle::make('is_active')
                    ->label('Catégorie visible')
                    ->helperText('Désactivez pour masquer cette catégorie sur le site.')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ColorColumn::make('color')
                    ->label(''),

                Tables\Columns\TextColumn::make('name')
                    ->label('Nom')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('slug'),

                Tables\Columns\TextColumn::make('posts_count')
                    ->label('Articles')
                    ->counts('posts'),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean(),
            ])
            ->defaultSort('order')
            ->reorderable('order')
            ->actions([
                \Filament\Actions\EditAction::make(),
                \Filament\Actions\DeleteAction::make()
                    ->before(function ($record) {
                        if ($record->posts()->count() > 0) {
                            throw new \Exception("Impossible de supprimer : {$record->posts()->count()} article(s) utilisent cette catégorie.");
                        }
                    }),
            ])
            ->bulkActions([
                \Filament\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPostCategories::route('/'),
            'create' => Pages\CreatePostCategory::route('/create'),
            'edit' => Pages\EditPostCategory::route('/{record}/edit'),
        ];
    }
}
