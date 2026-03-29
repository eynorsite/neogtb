<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NavigationMenuResource\Pages;
use App\Models\NavigationMenu;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class NavigationMenuResource extends Resource
{
    protected static ?string $model = NavigationMenu::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-bars-3';

    protected static string|\UnitEnum|null $navigationGroup = 'Mon site';

    protected static ?string $navigationLabel = 'Menus du site';

    protected static ?string $modelLabel = 'Menu';
    protected static ?string $pluralModelLabel = 'Menus';

    protected static ?int $navigationSort = 40;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Quel menu modifier ?')
                    ->description('Chaque menu correspond à un endroit du site : le haut de page, le bas de page ou le menu mobile.')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nom du menu')
                            ->helperText('Un nom pour vous repérer (ex : « Menu principal »).')
                            ->required(),

                        Select::make('location')
                            ->label('Où s\'affiche ce menu ?')
                            ->options([
                                'header' => 'En haut du site (barre de navigation)',
                                'footer' => 'En bas du site (pied de page)',
                                'mobile' => 'Menu mobile (hamburger)',
                            ])
                            ->required(),

                        Toggle::make('is_active')
                            ->label('Menu activé')
                            ->helperText('Désactivez pour masquer ce menu sans le supprimer.')
                            ->default(true),
                    ])->columns(2),

                Section::make('Liens du menu')
                    ->description('Ajoutez, réorganisez ou supprimez les liens. Glissez-déposez pour changer l\'ordre.')
                    ->schema([
                        Repeater::make('allItems')
                            ->label('')
                            ->relationship()
                            ->schema([
                                TextInput::make('label')
                                    ->label('Texte affiché')
                                    ->helperText('Le texte que le visiteur verra.')
                                    ->required(),

                                TextInput::make('url')
                                    ->label('Lien vers')
                                    ->required()
                                    ->helperText('Une page du site (ex : /gtb) ou un lien externe (ex : https://...).'),

                                Select::make('target')
                                    ->label('Ouvrir dans')
                                    ->options([
                                        '_self' => 'La même page',
                                        '_blank' => 'Un nouvel onglet',
                                    ])
                                    ->default('_self'),

                                TextInput::make('icon')
                                    ->label('Icône (optionnel)'),

                                TextInput::make('order')
                                    ->label('Position')
                                    ->numeric()
                                    ->default(0),

                                Toggle::make('is_active')
                                    ->label('Visible')
                                    ->default(true),
                            ])
                            ->columns(3)
                            ->collapsible()
                            ->orderColumn('order')
                            ->addActionLabel('Ajouter un lien')
                            ->itemLabel(fn (array $state) => ($state['label'] ?? '') . ' → ' . ($state['url'] ?? '')),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nom')
                    ->searchable(),

                Tables\Columns\TextColumn::make('location')
                    ->label('Affiché où ?')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'header' => 'Haut du site',
                        'footer' => 'Bas du site',
                        'mobile' => 'Menu mobile',
                        default => $state,
                    }),

                Tables\Columns\TextColumn::make('all_items_count')
                    ->label('Éléments')
                    ->counts('allItems'),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Actif')
                    ->boolean(),
            ])
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
            'index' => Pages\ListNavigationMenus::route('/'),
            'create' => Pages\CreateNavigationMenu::route('/create'),
            'edit' => Pages\EditNavigationMenu::route('/{record}/edit'),
        ];
    }
}
