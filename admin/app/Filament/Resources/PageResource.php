<?php

/**
 * PageResource — édite les SitePage (slug, hero_*, meta_*, og_*)
 * et la liste de leurs PageBrick via un Repeater (relationship 'bricks').
 *
 * Pour l'édition fine du contenu d'un brick (schema dynamique selon le type
 * via BrickRegistry::get($type)->schema()), un éditeur dédié existe :
 * App\Filament\Pages\BrickEditorPage (route /admin/pages/{id}/bricks),
 * accessible depuis l'action "Modifier le contenu" dans la table.
 *
 * Le Repeater "Contenu (blocs)" présent ici permet une gestion rapide :
 * réorder, ajouter, supprimer, renommer, masquer, et éditer le content/settings
 * via Textarea JSON. Le Select brick_type pioche dans BrickRegistry::types().
 */

namespace App\Filament\Resources;

use App\Filament\Bricks\BrickRegistry;
use App\Filament\Resources\PageResource\Pages;
use App\Models\SitePage;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
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

class PageResource extends Resource
{
    protected static ?string $model = SitePage::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-document-text';

    protected static string|\UnitEnum|null $navigationGroup = 'Mon site';

    protected static ?string $navigationLabel = 'Pages';

    protected static ?string $modelLabel = 'Page';
    protected static ?string $pluralModelLabel = 'Pages';

    protected static ?int $navigationSort = 10;

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

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Tabs')
                    ->tabs([
                        Tabs\Tab::make('Informations')
                            ->icon('heroicon-o-document-text')
                            ->schema([
                                TextInput::make('name')
                                    ->label('Nom de la page')
                                    ->helperText('Ce nom apparaît dans la liste de vos pages (pas visible sur le site).')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),

                                TextInput::make('slug')
                                    ->label('Adresse web')
                                    ->helperText('L\'adresse de la page. Ex : « gtb » donnera neogtb.fr/gtb. Se remplit automatiquement.')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(255)
                                    ->prefix('neogtb.fr/'),

                                Toggle::make('is_published')
                                    ->label('Page visible sur le site')
                                    ->helperText('Désactivez pour masquer cette page aux visiteurs sans la supprimer.')
                                    ->default(true),

                                TextInput::make('order')
                                    ->label('Position dans la liste')
                                    ->helperText('Numéro pour trier vos pages (0 = en premier).')
                                    ->numeric()
                                    ->default(0),
                            ]),

                        Tabs\Tab::make('Référencement Google')
                            ->icon('heroicon-o-magnifying-glass')
                            ->schema([
                                TextInput::make('meta_title')
                                    ->label('Titre pour Google')
                                    ->maxLength(70)
                                    ->helperText('Le titre qui apparaît dans les résultats Google. Max 70 caractères.'),

                                Textarea::make('meta_description')
                                    ->label('Description pour Google')
                                    ->rows(2)
                                    ->helperText('Le petit texte sous le titre dans Google. Max 160 caractères.'),

                                TextInput::make('meta_keywords')
                                    ->label('Mots-clés')
                                    ->helperText('Mots-clés séparés par des virgules (ex : GTB, bâtiment, énergie).'),

                                TextInput::make('og_title')
                                    ->label('Titre pour les réseaux sociaux')
                                    ->helperText('Le titre affiché quand quelqu\'un partage votre page sur LinkedIn, Facebook, etc.'),

                                Textarea::make('og_description')
                                    ->label('Description pour les réseaux sociaux')
                                    ->rows(2),

                                FileUpload::make('og_image')
                                    ->label('Image de partage')
                                    ->helperText('L\'image affichée quand on partage la page sur les réseaux sociaux. Format idéal : 1200x630px.')
                                    ->image()
                                    ->directory('og'),
                            ]),

                        Tabs\Tab::make('Hero')
                            ->icon('heroicon-o-photo')
                            ->schema([
                                TextInput::make('hero_title')
                                    ->label('Titre du hero')
                                    ->maxLength(255),
                                TextInput::make('hero_subtitle')
                                    ->label('Sous-titre du hero')
                                    ->maxLength(255),
                                Textarea::make('hero_description')
                                    ->label('Description du hero')
                                    ->rows(3),
                                TextInput::make('hero_cta_text')
                                    ->label('Texte du bouton (CTA)')
                                    ->maxLength(255),
                                TextInput::make('hero_cta_url')
                                    ->label('Lien du bouton (CTA)')
                                    ->maxLength(255),
                                FileUpload::make('hero_image')
                                    ->label('Image du hero')
                                    ->image()
                                    ->directory('hero'),
                            ]),

                        Tabs\Tab::make('Contenu (blocs)')
                            ->icon('heroicon-o-squares-2x2')
                            ->schema([
                                Repeater::make('bricks')
                                    ->label('Blocs de la page')
                                    ->relationship('bricks')
                                    ->orderColumn('order')
                                    ->reorderable()
                                    ->collapsible()
                                    ->cloneable()
                                    ->itemLabel(fn (array $state): ?string => ($state['brick_name'] ?? null) ?: ($state['brick_type'] ?? 'Bloc'))
                                    ->addActionLabel('Ajouter un bloc')
                                    ->helperText('Pour une édition avancée du contenu d\'un bloc (formulaires dédiés par type), utilisez l\'action "Modifier le contenu" depuis la liste des pages.')
                                    ->schema([
                                        Select::make('brick_type')
                                            ->label('Type de bloc')
                                            ->options(fn () => collect(BrickRegistry::types())
                                                ->mapWithKeys(fn ($t) => [$t => $t])
                                                ->all())
                                            ->required()
                                            ->searchable()
                                            ->live()
                                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                                if (!$state) {
                                                    return;
                                                }
                                                $def = BrickRegistry::get($state);
                                                if (!$def) {
                                                    return;
                                                }
                                                if (!$get('brick_name')) {
                                                    $set('brick_name', $def->name());
                                                }
                                                if (!$get('content')) {
                                                    $set('content', json_encode($def->defaultContent(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
                                                }
                                                if (!$get('settings')) {
                                                    $set('settings', json_encode($def->defaultSettings(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
                                                }
                                            }),
                                        TextInput::make('brick_name')
                                            ->label('Nom interne')
                                            ->maxLength(255),
                                        Toggle::make('is_visible')
                                            ->label('Visible')
                                            ->default(true),
                                        Textarea::make('content')
                                            ->label('Contenu (JSON)')
                                            ->rows(6)
                                            ->helperText('JSON brut. Pour l\'édition guidée, utilisez "Modifier le contenu".')
                                            ->formatStateUsing(fn ($state) => is_array($state) ? json_encode($state, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) : $state)
                                            ->dehydrateStateUsing(fn ($state) => is_string($state) && $state !== '' ? (json_decode($state, true) ?? []) : []),
                                        Textarea::make('settings')
                                            ->label('Réglages (JSON)')
                                            ->rows(4)
                                            ->formatStateUsing(fn ($state) => is_array($state) ? json_encode($state, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) : $state)
                                            ->dehydrateStateUsing(fn ($state) => is_string($state) && $state !== '' ? (json_decode($state, true) ?? []) : []),
                                    ])
                                    ->columnSpanFull(),
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
                    ->label('Modifier le contenu')
                    ->icon('heroicon-o-pencil-square')
                    ->color('success')
                    ->url(fn ($record) => url('/admin/pages/' . $record->id . '/bricks')),
                \Filament\Actions\EditAction::make()
                    ->label('Réglages de la page'),
                \Filament\Actions\Action::make('viewOnSite')
                    ->label('Voir sur le site')
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->color('gray')
                    ->url(fn ($record) => "https://neogtb.fr/{$record->slug}", shouldOpenInNewTab: true)
                    ->visible(fn ($record) => $record->is_published),
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
