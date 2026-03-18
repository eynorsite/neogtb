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

    protected static string|\UnitEnum|null $navigationGroup = 'Configuration';

    protected static ?string $navigationLabel = 'Navigation';

    protected static ?string $modelLabel = 'Menu';
    protected static ?string $pluralModelLabel = 'Menus';

    protected static ?int $navigationSort = 40;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Menu')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nom du menu')
                            ->required(),

                        Select::make('location')
                            ->label('Emplacement')
                            ->options([
                                'header' => 'Header (navigation principale)',
                                'footer' => 'Footer',
                                'mobile' => 'Menu mobile',
                            ])
                            ->required(),

                        Toggle::make('is_active')
                            ->label('Actif')
                            ->default(true),
                    ])->columns(2),

                Section::make('Éléments du menu')
                    ->schema([
                        Repeater::make('allItems')
                            ->relationship()
                            ->schema([
                                TextInput::make('label')
                                    ->label('Libellé')
                                    ->required(),

                                TextInput::make('url')
                                    ->label('URL')
                                    ->required()
                                    ->helperText('Ex: /gtb, /blog, ou https://...'),

                                Select::make('target')
                                    ->label('Ouverture')
                                    ->options([
                                        '_self' => 'Même fenêtre',
                                        '_blank' => 'Nouvelle fenêtre',
                                    ])
                                    ->default('_self'),

                                TextInput::make('icon')
                                    ->label('Icône'),

                                TextInput::make('order')
                                    ->label('Ordre')
                                    ->numeric()
                                    ->default(0),

                                Toggle::make('is_active')
                                    ->label('Actif')
                                    ->default(true),
                            ])
                            ->columns(3)
                            ->collapsible()
                            ->orderColumn('order')
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
                    ->label('Emplacement')
                    ->badge(),

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
