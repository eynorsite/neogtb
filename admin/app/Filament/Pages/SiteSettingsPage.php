<?php

namespace App\Filament\Pages;

use App\Models\GeneralSetting;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;

class SiteSettingsPage extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static string|\UnitEnum|null $navigationGroup = 'Réglages';

    protected static ?string $navigationLabel = 'Paramètres généraux';

    protected static ?string $title = 'Paramètres du site';

    protected static ?int $navigationSort = 50;

    protected string $view = 'filament.pages.site-settings';

    public ?array $data = [];

    public static function canAccess(): bool
    {
        $admin = auth()->guard('admin')->user();

        if (! $admin) {
            return false;
        }

        return in_array($admin->role, ['superadmin', 'admin', 'editeur']);
    }

    public function mount(): void
    {
        $settings = GeneralSetting::get()->fresh();
        $this->form->fill($settings->toArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Settings')
                    ->persistTabInQueryString()
                    ->tabs(array_filter([
                        $this->generalTab(),
                        $this->siteIdentityTab(),
                        $this->colorsTab(),
                        $this->typographyTab(),
                        $this->navigationTab(),
                        $this->homepageTab(),
                        $this->announcementTab(),
                        $this->socialTab(),
                        $this->seoTab(),
                        $this->trackingTab(),
                        $this->advancedTab(),
                        $this->labelsTab(),
                        $this->legalTab(),
                        $this->statusTab(),
                        $this->cataloguesTab(),
                        $this->emailTab(),
                        $this->canAccessSecurity() ? $this->securityTab() : null,
                        $this->rgpdTab(),
                        $this->statsTab(),
                    ])),
            ])
            ->statePath('data');
    }

    // ─── SAVE ──────────────────────────────────────────────

    public function save(): void
    {
        $data = $this->form->getState();

        // Supprimer les champs non-éditables
        unset($data['id'], $data['created_at'], $data['updated_at']);

        $settings = GeneralSetting::get()->fresh();
        $settings->update($data);
        GeneralSetting::clearCache();

        app(\App\Services\SiteConfigService::class)->clearCache();

        Notification::make()
            ->title('Paramètres enregistrés')
            ->success()
            ->send();
    }

    // ─── PRESETS ───────────────────────────────────────────

    public function applyPreset(string $preset): void
    {
        $values = config("neogtb.presets.{$preset}");

        if (! $values) {
            Notification::make()->title('Preset introuvable')->danger()->send();

            return;
        }

        foreach ($values as $key => $value) {
            $this->data[$key] = $value;
        }

        Notification::make()
            ->title('Preset appliqué')
            ->body('Les couleurs ont été mises à jour. Pensez à enregistrer.')
            ->success()
            ->send();
    }

    // ─── TEST EMAIL ────────────────────────────────────────

    public function sendTestEmail(): void
    {
        $to = $this->data['email_notification_to'] ?? null;
        $fromName = $this->data['email_from_name'] ?? config('mail.from.name');
        $fromAddress = $this->data['email_from_address'] ?? config('mail.from.address');

        if (! $to) {
            Notification::make()->title('Adresse de notification manquante')->danger()->send();

            return;
        }

        try {
            Mail::raw('Ceci est un email de test envoyé depuis NeoGTB Admin.', function ($message) use ($to, $fromName, $fromAddress) {
                $message->to($to)
                    ->from($fromAddress, $fromName)
                    ->subject('NeoGTB - Email de test');
            });

            Notification::make()
                ->title('Email de test envoyé')
                ->body("Un email a été envoyé à {$to}.")
                ->success()
                ->send();
        } catch (\Exception $e) {
            Notification::make()
                ->title('Erreur d\'envoi')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }

    // ─── CACHE ─────────────────────────────────────────────

    public function clearAllCache(): void
    {
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('view:clear');
        Artisan::call('route:clear');

        Notification::make()->title('Cache vidé avec succès')->success()->send();
    }

    public function optimize(): void
    {
        Artisan::call('optimize');

        Notification::make()->title('Application optimisée')->success()->send();
    }

    // ─── ROLE HELPERS ──────────────────────────────────────

    protected function getRole(): string
    {
        return auth()->guard('admin')->user()?->role ?? 'lecteur';
    }

    protected function canAccessSecurity(): bool
    {
        return $this->getRole() === 'superadmin';
    }

    protected function isEditor(): bool
    {
        return $this->getRole() === 'editeur';
    }

    // ─── TAB: GÉNÉRAL ──────────────────────────────────────

    protected function generalTab(): Tab
    {
        return Tab::make('Général')
            ->icon('heroicon-o-phone')
            ->schema([
                Section::make('Identité de l\'entreprise')->schema([
                    Grid::make(2)->schema([
                        TextInput::make('company_name')
                            ->label('Nom de l\'entreprise')
                            ->required()
                            ->maxLength(100),
                        TextInput::make('company_tagline')
                            ->label('Slogan')
                            ->maxLength(255),
                    ]),
                    TextInput::make('company_website')
                        ->label('Site web')
                        ->url(),
                    Textarea::make('company_description')
                        ->label('Description')
                        ->rows(3),
                ]),
                Section::make('Coordonnées')->schema([
                    Grid::make(2)->schema([
                        TextInput::make('company_email')
                            ->label('Email')
                            ->email(),
                        TextInput::make('company_phone')
                            ->label('Téléphone')
                            ->tel(),
                        TextInput::make('company_phone_2')
                            ->label('Téléphone secondaire')
                            ->tel(),
                        TextInput::make('company_whatsapp')
                            ->label('WhatsApp'),
                    ]),
                ]),
                Section::make('Adresse')->schema([
                    Textarea::make('company_address')
                        ->label('Adresse')
                        ->rows(2),
                    Grid::make(3)->schema([
                        TextInput::make('company_postal_code')
                            ->label('Code postal')
                            ->maxLength(10),
                        TextInput::make('company_city')
                            ->label('Ville'),
                        TextInput::make('company_country')
                            ->label('Pays'),
                    ]),
                    TextInput::make('company_google_maps_url')
                        ->label('URL Google Maps')
                        ->url(),
                    Textarea::make('company_google_maps_embed')
                        ->label('Code embed Google Maps')
                        ->rows(3)
                        ->helperText('Code iframe Google Maps'),
                ]),
                Section::make('Informations légales')->schema([
                    Grid::make(2)->schema([
                        TextInput::make('company_siret')
                            ->label('SIRET')
                            ->maxLength(20),
                        TextInput::make('company_siren')
                            ->label('SIREN')
                            ->maxLength(20),
                        TextInput::make('company_legal_form')
                            ->label('Forme juridique'),
                        TextInput::make('company_tva_number')
                            ->label('N° TVA'),
                        TextInput::make('company_rcs')
                            ->label('RCS'),
                        TextInput::make('company_capital')
                            ->label('Capital social'),
                        TextInput::make('legal_representative_name')
                            ->label('Représentant légal'),
                        TextInput::make('legal_representative_title')
                            ->label('Titre du représentant'),
                        TextInput::make('company_founding_year')
                            ->label('Année de création')
                            ->numeric()
                            ->minValue(1900)
                            ->maxValue(2100),
                    ]),
                ]),
            ]);
    }

    // ─── TAB: IDENTITÉ VISUELLE ────────────────────────────

    protected function siteIdentityTab(): Tab
    {
        return Tab::make('Identité visuelle')
            ->icon('heroicon-o-photo')
            ->schema([
                Section::make('Logos')->schema([
                    Grid::make(3)->schema([
                        FileUpload::make('company_logo')
                            ->label('Logo principal')
                            ->image()
                            ->directory('logos')
                            ->maxSize(2048),
                        FileUpload::make('company_logo_white')
                            ->label('Logo blanc (fond sombre)')
                            ->image()
                            ->directory('logos')
                            ->maxSize(2048),
                        FileUpload::make('company_logo_icon')
                            ->label('Logo icône (carré)')
                            ->image()
                            ->directory('logos')
                            ->maxSize(1024),
                    ]),
                ]),
                Section::make('Favicon & Open Graph')->schema([
                    Grid::make(2)->schema([
                        FileUpload::make('favicon')
                            ->label('Favicon')
                            ->image()
                            ->directory('logos')
                            ->maxSize(512)
                            ->helperText('32x32px recommandé'),
                        FileUpload::make('og_default_image')
                            ->label('Image Open Graph par défaut')
                            ->image()
                            ->directory('og')
                            ->maxSize(2048)
                            ->helperText('1200x630px recommandé'),
                    ]),
                ]),
            ]);
    }

    // ─── TAB: COULEURS ─────────────────────────────────────

    protected function colorsTab(): Tab
    {
        return Tab::make('Couleurs')
            ->icon('heroicon-o-swatch')
            ->schema([
                Section::make('Presets de thème')
                    ->description('Appliquer un preset puis enregistrer pour sauvegarder.')
                    ->schema([
                        Actions::make([
                            Action::make('preset_gtb_pro')
                                ->label('GTB Pro')
                                ->icon('heroicon-o-swatch')
                                ->color('primary')
                                ->requiresConfirmation()
                                ->modalHeading('Appliquer le preset GTB Pro ?')
                                ->modalDescription('Les couleurs actuelles seront remplacées.')
                                ->action(fn () => $this->applyPreset('gtb_pro')),
                            Action::make('preset_eco_green')
                                ->label('Éco Green')
                                ->icon('heroicon-o-swatch')
                                ->color('success')
                                ->requiresConfirmation()
                                ->modalHeading('Appliquer le preset Éco Green ?')
                                ->modalDescription('Les couleurs actuelles seront remplacées.')
                                ->action(fn () => $this->applyPreset('eco_green')),
                            Action::make('preset_tech_blue')
                                ->label('Tech Blue')
                                ->icon('heroicon-o-swatch')
                                ->color('info')
                                ->requiresConfirmation()
                                ->modalHeading('Appliquer le preset Tech Blue ?')
                                ->modalDescription('Les couleurs actuelles seront remplacées.')
                                ->action(fn () => $this->applyPreset('tech_blue')),
                        ]),
                    ]),
                Section::make('Couleurs principales')->schema([
                    Grid::make(3)->schema([
                        ColorPicker::make('primary_color')->label('Primaire'),
                        ColorPicker::make('secondary_color')->label('Secondaire'),
                        ColorPicker::make('accent_color')->label('Accent'),
                    ]),
                ]),
                Section::make('Header & Footer')->schema([
                    Grid::make(2)->schema([
                        ColorPicker::make('header_bg_color')->label('Header - Fond'),
                        ColorPicker::make('header_text_color')->label('Header - Texte'),
                        ColorPicker::make('footer_bg_color')->label('Footer - Fond'),
                        ColorPicker::make('footer_text_color')->label('Footer - Texte'),
                    ]),
                ]),
                Section::make('Corps & Hero')->schema([
                    Grid::make(3)->schema([
                        ColorPicker::make('body_bg_color')->label('Fond du body'),
                        ColorPicker::make('hero_overlay_color')->label('Overlay Hero'),
                        TextInput::make('hero_overlay_opacity')
                            ->label('Opacité Hero (%)')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100)
                            ->suffix('%'),
                    ]),
                ]),
                Section::make('Boutons CTA')->schema([
                    Grid::make(2)->schema([
                        ColorPicker::make('cta_bg_color')->label('Fond CTA'),
                        ColorPicker::make('cta_text_color')->label('Texte CTA'),
                    ]),
                ]),
            ]);
    }

    // ─── TAB: TYPOGRAPHIE ──────────────────────────────────

    protected function typographyTab(): Tab
    {
        return Tab::make('Typographie')
            ->icon('heroicon-o-language')
            ->schema([
                Section::make('Police & Style')->schema([
                    Grid::make(2)->schema([
                        Select::make('font_pair')
                            ->label('Paire de polices')
                            ->options([
                                'inter_dm_sans' => 'Inter + DM Sans',
                                'inter_merriweather' => 'Inter + Merriweather',
                                'poppins_lora' => 'Poppins + Lora',
                                'montserrat_roboto' => 'Montserrat + Roboto',
                                'dm_sans_dm_serif' => 'DM Sans + DM Serif',
                                'plus_jakarta_inter' => 'Plus Jakarta + Inter',
                                'outfit_inter' => 'Outfit + Inter',
                                'space_grotesk_inter' => 'Space Grotesk + Inter',
                            ]),
                        Select::make('font_size_base')
                            ->label('Taille de police')
                            ->options([
                                'sm' => 'Petit',
                                'md' => 'Moyen',
                                'lg' => 'Grand',
                            ]),
                        Select::make('border_radius_style')
                            ->label('Arrondi des bordures')
                            ->options([
                                'none' => 'Aucun',
                                'small' => 'Léger',
                                'medium' => 'Moyen',
                                'large' => 'Arrondi',
                                'full' => 'Très arrondi',
                            ]),
                        Select::make('shadow_style')
                            ->label('Ombres')
                            ->options([
                                'none' => 'Aucune',
                                'subtle' => 'Légère',
                                'medium' => 'Moyenne',
                                'strong' => 'Forte',
                            ]),
                    ]),
                ]),
            ]);
    }

    // ─── TAB: NAVIGATION ───────────────────────────────────

    protected function navigationTab(): Tab
    {
        return Tab::make('Navigation')
            ->icon('heroicon-o-bars-3')
            ->schema([
                Section::make('Items du menu')
                    ->description('Glissez-déposez pour réordonner les éléments du menu principal.')
                    ->schema([
                        Repeater::make('nav_items')
                            ->label('')
                            ->schema([
                                Grid::make(4)->schema([
                                    TextInput::make('label')
                                        ->label('Libellé')
                                        ->required()
                                        ->maxLength(30),
                                    TextInput::make('url')
                                        ->label('URL')
                                        ->required(),
                                    Select::make('type')
                                        ->label('Type')
                                        ->options(['link' => 'Lien simple', 'mega' => 'Mega menu'])
                                        ->default('link'),
                                    Toggle::make('visible')
                                        ->label('Visible')
                                        ->default(true),
                                ]),
                            ])
                            ->collapsible()
                            ->cloneable()
                            ->reorderable()
                            ->addActionLabel('Ajouter un lien')
                            ->defaultItems(0),
                    ]),
                Section::make('Style de navigation')->schema([
                    Grid::make(2)->schema([
                        Select::make('nav_style')
                            ->label('Style')
                            ->options([
                                'sticky' => 'Sticky',
                                'transparent' => 'Transparent',
                                'solid' => 'Solid',
                            ]),
                        Toggle::make('nav_sticky')
                            ->label('Navigation sticky'),
                    ]),
                ]),
                Section::make('Bouton CTA header')->schema([
                    Toggle::make('nav_cta_visible')
                        ->label('Afficher le CTA')
                        ->live(),
                    Grid::make(2)->schema([
                        TextInput::make('nav_cta_text')
                            ->label('Texte du CTA')
                            ->visible(fn ($get) => $get('nav_cta_visible')),
                        TextInput::make('nav_cta_url')
                            ->label('URL du CTA')
                            ->visible(fn ($get) => $get('nav_cta_visible')),
                    ]),
                ]),
                Section::make('Téléphone')->schema([
                    Toggle::make('nav_show_phone')
                        ->label('Afficher le téléphone dans la navigation')
                        ->helperText('Affiche le numéro de téléphone dans la barre de navigation'),
                ]),
            ]);
    }

    // ─── TAB: PAGE D'ACCUEIL ─────────────────────────────────

    protected function homepageTab(): Tab
    {
        return Tab::make('Page d\'accueil')
            ->icon('heroicon-o-home')
            ->schema([
                Section::make('Hero')
                    ->description('Configuration de la section hero de la page d\'accueil.')
                    ->columns(2)
                    ->schema([
                        Select::make('hero_style')
                            ->label('Style du hero')
                            ->options([
                                'static' => 'Image statique',
                                'gradient' => 'Dégradé',
                                'video' => 'Vidéo',
                            ])
                            ->default('static'),
                        FileUpload::make('hero_default_image')
                            ->label('Image hero')
                            ->image()
                            ->directory('hero')
                            ->columnSpanFull(),
                        TextInput::make('hero_title_line1')
                            ->label('Titre ligne 1')
                            ->maxLength(100),
                        TextInput::make('hero_title_line2')
                            ->label('Titre ligne 2')
                            ->maxLength(100),
                    ]),

                Section::make('Sections de la page d\'accueil')
                    ->description('Cochez les sections à afficher et réordonnez-les.')
                    ->schema([
                        \Filament\Forms\Components\CheckboxList::make('homepage_sections')
                            ->label('')
                            ->options([
                                'hero' => 'Hero',
                                'expertises' => 'Expertises GTB',
                                'chiffres' => 'Chiffres clés',
                                'comparatif' => 'Comparatif GTB/GTC',
                                'solutions' => 'Solutions & Technologies',
                                'temoignages' => 'Témoignages',
                                'faq' => 'FAQ',
                                'cta_audit' => 'CTA Audit',
                                'blog_recent' => 'Articles récents',
                            ])
                            ->columns(3),
                    ]),
            ]);
    }

    // ─── TAB: BANDEAU D'ANNONCE ────────────────────────────

    protected function announcementTab(): Tab
    {
        return Tab::make('Bandeau d\'annonce')
            ->icon('heroicon-o-megaphone')
            ->schema([
                Section::make('Configuration du bandeau')->schema([
                    Toggle::make('announcement_enabled')
                        ->label('Activer le bandeau')
                        ->live(),
                    Textarea::make('announcement_text')
                        ->label('Texte de l\'annonce')
                        ->rows(2)
                        ->visible(fn ($get) => $get('announcement_enabled')),
                    TextInput::make('announcement_url')
                        ->label('URL (optionnel)')
                        ->url()
                        ->visible(fn ($get) => $get('announcement_enabled')),
                    Grid::make(2)->schema([
                        ColorPicker::make('announcement_bg_color')
                            ->label('Couleur de fond'),
                        ColorPicker::make('announcement_text_color')
                            ->label('Couleur du texte'),
                    ])->visible(fn ($get) => $get('announcement_enabled')),
                ]),
            ]);
    }

    // ─── TAB: RÉSEAUX SOCIAUX ──────────────────────────────

    protected function socialTab(): Tab
    {
        return Tab::make('Réseaux sociaux')
            ->icon('heroicon-o-share')
            ->schema([
                Section::make('Liens sociaux')->schema([
                    Grid::make(2)->schema([
                        TextInput::make('social_linkedin')
                            ->label('LinkedIn')
                            ->url()
                            ->prefixIcon('heroicon-o-link'),
                        TextInput::make('social_facebook')
                            ->label('Facebook')
                            ->url()
                            ->prefixIcon('heroicon-o-link'),
                        TextInput::make('social_youtube')
                            ->label('YouTube')
                            ->url()
                            ->prefixIcon('heroicon-o-link'),
                        TextInput::make('social_instagram')
                            ->label('Instagram')
                            ->url()
                            ->prefixIcon('heroicon-o-link'),
                        TextInput::make('social_twitter_x')
                            ->label('Twitter / X')
                            ->url()
                            ->prefixIcon('heroicon-o-link'),
                        TextInput::make('social_tiktok')
                            ->label('TikTok')
                            ->url()
                            ->prefixIcon('heroicon-o-link'),
                    ]),
                ]),
                Section::make('Google Reviews')->schema([
                    Grid::make(3)->schema([
                        TextInput::make('social_google_reviews_url')
                            ->label('URL Google Reviews')
                            ->url(),
                        TextInput::make('social_google_reviews_count')
                            ->label('Nombre d\'avis'),
                        TextInput::make('social_google_reviews_score')
                            ->label('Note moyenne'),
                    ]),
                ]),
            ]);
    }

    // ─── TAB: SEO ──────────────────────────────────────────

    protected function seoTab(): Tab
    {
        return Tab::make('SEO')
            ->icon('heroicon-o-magnifying-glass')
            ->schema([
                Section::make('Paramètres SEO')->schema([
                    TextInput::make('seo_title_suffix')
                        ->label('Suffixe du titre')
                        ->helperText('Ajouté à la fin de chaque titre de page'),
                    Textarea::make('seo_default_description')
                        ->label('Description par défaut')
                        ->rows(3)
                        ->maxLength(160)
                        ->helperText('160 caractères max recommandés'),
                    Grid::make(2)->schema([
                        Select::make('seo_robots')
                            ->label('Directive robots')
                            ->options([
                                'index, follow' => 'index, follow',
                                'noindex, follow' => 'noindex, follow',
                                'index, nofollow' => 'index, nofollow',
                                'noindex, nofollow' => 'noindex, nofollow',
                            ]),
                        Select::make('seo_schema_type')
                            ->label('Type Schema.org')
                            ->options([
                                'Organization' => 'Organization',
                                'LocalBusiness' => 'LocalBusiness',
                                'ProfessionalService' => 'ProfessionalService',
                            ]),
                    ]),
                    TextInput::make('seo_canonical_url')
                        ->label('URL canonique')
                        ->url(),
                ]),
                Section::make('Vérifications')->schema([
                    Grid::make(2)->schema([
                        TextInput::make('seo_google_verification')
                            ->label('Google Search Console'),
                        TextInput::make('seo_bing_verification')
                            ->label('Bing Webmaster'),
                    ]),
                ]),
                Section::make('Aperçu Google')->schema([
                    Placeholder::make('google_preview')
                        ->label('')
                        ->content(function ($get) {
                            $title = 'NeoGTB' . ($get('seo_title_suffix') ?? '');
                            $desc = $get('seo_default_description') ?? 'Description...';

                            return new \Illuminate\Support\HtmlString(
                                '<div style="padding:16px;border:1px solid #E2E8F0;border-radius:12px;background:white;">
                                    <div style="font-size:12px;color:#94A3B8;">neogtb.fr</div>
                                    <div style="font-size:18px;color:#1a0dab;margin-top:4px;">' . e($title) . '</div>
                                    <div style="font-size:13px;color:#4d5156;margin-top:4px;line-height:1.5;">' . e(\Illuminate\Support\Str::limit($desc, 160)) . '</div>
                                </div>'
                            );
                        }),
                ]),
            ]);
    }

    // ─── TAB: TRACKING ─────────────────────────────────────

    protected function trackingTab(): Tab
    {
        return Tab::make('Tracking')
            ->icon('heroicon-o-chart-bar')
            ->schema([
                Section::make('Identifiants de tracking')->schema([
                    Grid::make(2)->schema([
                        TextInput::make('google_analytics_id')
                            ->label('Google Analytics (GA4)')
                            ->placeholder('G-XXXXXXXXXX'),
                        TextInput::make('google_tag_manager_id')
                            ->label('Google Tag Manager')
                            ->placeholder('GTM-XXXXXXX'),
                        TextInput::make('facebook_pixel_id')
                            ->label('Facebook Pixel')
                            ->placeholder('123456789'),
                        TextInput::make('hotjar_id')
                            ->label('Hotjar')
                            ->placeholder('1234567'),
                    ]),
                ]),
                Section::make('Bandeau cookies')->schema([
                    Toggle::make('cookie_banner_enabled')
                        ->label('Activer le bandeau cookies')
                        ->live(),
                    Textarea::make('cookie_banner_text')
                        ->label('Texte du bandeau')
                        ->rows(3)
                        ->visible(fn ($get) => $get('cookie_banner_enabled')),
                ]),
            ]);
    }

    // ─── TAB: AVANCÉ ───────────────────────────────────────

    protected function advancedTab(): Tab
    {
        return Tab::make('Avancé')
            ->icon('heroicon-o-wrench-screwdriver')
            ->visible(fn () => in_array($this->getRole(), ['superadmin', 'admin']))
            ->schema([
                Section::make('Mode maintenance')->schema([
                    Toggle::make('maintenance_enabled')
                        ->label('Activer le mode maintenance')
                        ->live(),
                    Textarea::make('maintenance_message')
                        ->label('Message de maintenance')
                        ->rows(3)
                        ->visible(fn ($get) => $get('maintenance_enabled')),
                    TextInput::make('maintenance_image')
                        ->label('Image de maintenance')
                        ->visible(fn ($get) => $get('maintenance_enabled')),
                ]),
                Section::make('Code personnalisé')
                    ->description('Injecté dans le HTML du site public.')
                    ->schema([
                        Textarea::make('custom_head_code')
                            ->label('Code <head> personnalisé')
                            ->rows(5)
                            ->helperText('CSS, scripts analytics, meta tags...'),
                        Textarea::make('custom_body_code')
                            ->label('Code <body> personnalisé')
                            ->rows(5)
                            ->helperText('Scripts avant la fermeture de </body>'),
                    ]),
                Section::make('Gestion du cache')->schema([
                    Actions::make([
                        Action::make('clear_cache')
                            ->label('Vider tout le cache')
                            ->icon('heroicon-o-trash')
                            ->color('danger')
                            ->requiresConfirmation()
                            ->action(fn () => $this->clearAllCache()),
                        Action::make('optimize_app')
                            ->label('Optimiser')
                            ->icon('heroicon-o-bolt')
                            ->color('success')
                            ->action(fn () => $this->optimize()),
                    ]),
                ]),
                Section::make('Santé du système')->schema([
                    Placeholder::make('system_health')
                        ->label('')
                        ->content(function () {
                            $debug = config('app.debug');
                            $env = config('app.env');

                            return new \Illuminate\Support\HtmlString(
                                '<div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">'
                                . '<div style="display:flex;align-items:center;gap:8px;padding:10px 14px;background:#FAFBFC;border-radius:10px;border:1px solid #F1F5F9;">'
                                . '<span>' . (! $debug ? '✅' : '❌') . '</span><span style="font-size:13px;">APP_DEBUG = ' . ($debug ? 'true' : 'false') . '</span></div>'
                                . '<div style="display:flex;align-items:center;gap:8px;padding:10px 14px;background:#FAFBFC;border-radius:10px;border:1px solid #F1F5F9;">'
                                . '<span>' . ($env === 'production' ? '✅' : '⚠️') . '</span><span style="font-size:13px;">Env : ' . e($env) . '</span></div>'
                                . '<div style="display:flex;align-items:center;gap:8px;padding:10px 14px;background:#FAFBFC;border-radius:10px;border:1px solid #F1F5F9;">'
                                . '<span>✅</span><span style="font-size:13px;">PHP ' . phpversion() . '</span></div>'
                                . '<div style="display:flex;align-items:center;gap:8px;padding:10px 14px;background:#FAFBFC;border-radius:10px;border:1px solid #F1F5F9;">'
                                . '<span>✅</span><span style="font-size:13px;">Laravel ' . app()->version() . '</span></div>'
                                . '</div>'
                            );
                        }),
                ]),
            ]);
    }

    // ─── TAB: LABELS D'INTERFACE ───────────────────────────

    protected function labelsTab(): Tab
    {
        return Tab::make('Labels d\'interface')
            ->icon('heroicon-o-tag')
            ->schema([
                Section::make('Formulaires')
                    ->description('Textes affichés dans les formulaires publics (contact, audit, newsletter).')
                    ->columns(2)
                    ->schema([
                        TextInput::make('ui_labels.forms.name')->label('Nom')->default('Nom'),
                        TextInput::make('ui_labels.forms.first_name')->label('Prénom')->default('Prénom'),
                        TextInput::make('ui_labels.forms.email')->label('Email')->default('Email'),
                        TextInput::make('ui_labels.forms.phone')->label('Téléphone')->default('Téléphone'),
                        TextInput::make('ui_labels.forms.company')->label('Entreprise')->default('Entreprise'),
                        TextInput::make('ui_labels.forms.subject')->label('Sujet')->default('Sujet'),
                        TextInput::make('ui_labels.forms.submit')->label('Bouton envoyer')->default('Envoyer'),
                        TextInput::make('ui_labels.forms.cancel')->label('Bouton annuler')->default('Annuler'),
                        Textarea::make('ui_labels.forms.success_message')->label('Message de succès')->rows(2)->columnSpanFull(),
                        Textarea::make('ui_labels.forms.error_message')->label('Message d\'erreur')->rows(2)->columnSpanFull(),
                        TextInput::make('ui_labels.forms.required_fields')->label('Champs obligatoires')->columnSpanFull(),
                    ]),

                Section::make('Formulaire Audit GTB')
                    ->description('Labels spécifiques au wizard d\'audit.')
                    ->columns(2)
                    ->schema([
                        TextInput::make('ui_labels.forms.building_type')->label('Type de bâtiment'),
                        TextInput::make('ui_labels.forms.surface')->label('Surface'),
                        TextInput::make('ui_labels.forms.building_year')->label('Année de construction'),
                        TextInput::make('ui_labels.forms.energy_bill')->label('Facture énergétique'),
                        TextInput::make('ui_labels.forms.gtb_level')->label('Niveau GTB actuel'),
                    ]),

                Section::make('En-tête')
                    ->description('Textes du header et de la navigation.')
                    ->columns(3)
                    ->schema([
                        TextInput::make('ui_labels.header.home')->label('Accueil'),
                        TextInput::make('ui_labels.header.gtb')->label('GTB'),
                        TextInput::make('ui_labels.header.gtc')->label('GTC'),
                        TextInput::make('ui_labels.header.solutions')->label('Solutions'),
                        TextInput::make('ui_labels.header.reglementation')->label('Réglementation'),
                        TextInput::make('ui_labels.header.blog')->label('Blog'),
                        TextInput::make('ui_labels.header.contact')->label('Contact'),
                        TextInput::make('ui_labels.header.audit_cta')->label('CTA Audit'),
                        TextInput::make('ui_labels.header.breadcrumb_label')->label('Fil d\'Ariane'),
                    ]),

                Section::make('Pied de page')
                    ->columns(2)
                    ->schema([
                        TextInput::make('ui_labels.footer.col1_title')->label('Colonne 1'),
                        TextInput::make('ui_labels.footer.col2_title')->label('Colonne 2'),
                        TextInput::make('ui_labels.footer.col3_title')->label('Colonne 3'),
                        TextInput::make('ui_labels.footer.col4_title')->label('Colonne 4'),
                        TextInput::make('ui_labels.footer.newsletter_placeholder')->label('Placeholder newsletter'),
                        TextInput::make('ui_labels.footer.newsletter_button')->label('Bouton newsletter'),
                        TextInput::make('ui_labels.footer.newsletter_subtitle')->label('Sous-titre newsletter'),
                        TextInput::make('ui_labels.footer.no_tracking')->label('Message no-tracking'),
                    ]),

                Section::make('Appels à l\'action')
                    ->columns(2)
                    ->schema([
                        TextInput::make('ui_labels.cta.audit_title')->label('Titre CTA audit'),
                        TextInput::make('ui_labels.cta.audit_button')->label('Bouton CTA audit'),
                        Textarea::make('ui_labels.cta.audit_subtitle')->label('Sous-titre CTA audit')->rows(2)->columnSpanFull(),
                        TextInput::make('ui_labels.cta.contact_us')->label('Contactez-nous'),
                        TextInput::make('ui_labels.cta.learn_more')->label('En savoir plus'),
                        TextInput::make('ui_labels.cta.download')->label('Télécharger'),
                        TextInput::make('ui_labels.cta.compare')->label('Comparer'),
                        TextInput::make('ui_labels.cta.back_to_blog')->label('Retour au blog'),
                    ]),

                Section::make('Cookies')
                    ->columns(2)
                    ->schema([
                        TextInput::make('ui_labels.cookie.title')->label('Titre bandeau'),
                        TextInput::make('ui_labels.cookie.accept')->label('Bouton accepter'),
                        TextInput::make('ui_labels.cookie.reject')->label('Bouton refuser'),
                        TextInput::make('ui_labels.cookie.customize')->label('Bouton personnaliser'),
                        TextInput::make('ui_labels.cookie.save_preferences')->label('Bouton enregistrer'),
                        Textarea::make('ui_labels.cookie.description')->label('Description')->rows(2)->columnSpanFull(),
                        TextInput::make('ui_labels.cookie.necessary_title')->label('Cookies nécessaires — titre'),
                        TextInput::make('ui_labels.cookie.necessary_desc')->label('Cookies nécessaires — desc'),
                        TextInput::make('ui_labels.cookie.analytics_title')->label('Cookies analytics — titre'),
                        TextInput::make('ui_labels.cookie.analytics_desc')->label('Cookies analytics — desc'),
                    ]),

                Section::make('Validation')
                    ->columns(2)
                    ->schema([
                        TextInput::make('ui_labels.validation.required')->label('Champ obligatoire'),
                        TextInput::make('ui_labels.validation.email_invalid')->label('Email invalide'),
                        TextInput::make('ui_labels.validation.phone_invalid')->label('Téléphone invalide'),
                        TextInput::make('ui_labels.validation.min_length')->label('Longueur min'),
                        TextInput::make('ui_labels.validation.max_length')->label('Longueur max'),
                    ]),

                Section::make('Pagination & Divers')
                    ->columns(3)
                    ->schema([
                        TextInput::make('ui_labels.pagination.previous')->label('Précédent'),
                        TextInput::make('ui_labels.pagination.next')->label('Suivant'),
                        TextInput::make('ui_labels.pagination.results')->label('Résultats'),
                        TextInput::make('ui_labels.misc.loading')->label('Chargement'),
                        TextInput::make('ui_labels.misc.no_data')->label('Aucune donnée'),
                        TextInput::make('ui_labels.misc.back')->label('Retour'),
                        TextInput::make('ui_labels.misc.close')->label('Fermer'),
                        TextInput::make('ui_labels.misc.share')->label('Partager'),
                        TextInput::make('ui_labels.misc.reading_time')->label('Temps de lecture'),
                    ]),
            ]);
    }

    // ─── TAB: TEXTES LÉGAUX ────────────────────────────────

    protected function legalTab(): Tab
    {
        return Tab::make('Textes légaux')
            ->icon('heroicon-o-scale')
            ->schema([
                Section::make('Mentions légales')
                    ->description('Obligatoires au titre de la LCEN. Éditeur, hébergeur, directeur de publication.')
                    ->schema([
                        RichEditor::make('legal_texts.mentions_legales')
                            ->label('')
                            ->toolbarButtons(['bold', 'italic', 'underline', 'h2', 'h3', 'bulletList', 'orderedList', 'link'])
                            ->columnSpanFull(),
                    ]),

                Section::make('Politique de confidentialité')
                    ->description('RGPD Art. 13 & 14. La modification crée automatiquement une nouvelle version.')
                    ->schema([
                        RichEditor::make('legal_texts.politique_confidentialite')
                            ->label('')
                            ->toolbarButtons(['bold', 'italic', 'underline', 'h2', 'h3', 'bulletList', 'orderedList', 'link'])
                            ->columnSpanFull(),
                    ]),

                Section::make('Conditions Générales d\'Utilisation')
                    ->schema([
                        RichEditor::make('legal_texts.cgu')
                            ->label('')
                            ->toolbarButtons(['bold', 'italic', 'underline', 'h2', 'h3', 'bulletList', 'orderedList', 'link'])
                            ->columnSpanFull(),
                    ]),

                Section::make('Bandeau cookies')
                    ->description('Configuration du consentement cookie (RGPD / CNIL).')
                    ->columns(2)
                    ->schema([
                        TextInput::make('legal_texts.cookie_consent.title')->label('Titre'),
                        TextInput::make('legal_texts.cookie_consent.accept')->label('Bouton accepter'),
                        TextInput::make('legal_texts.cookie_consent.reject')->label('Bouton refuser'),
                        TextInput::make('legal_texts.cookie_consent.customize')->label('Bouton personnaliser'),
                        Textarea::make('legal_texts.cookie_consent.description')->label('Description')->rows(3)->columnSpanFull(),
                    ]),
            ]);
    }

    // ─── TAB: STATUTS & WORKFLOWS ──────────────────────────

    protected function statusTab(): Tab
    {
        $statusRepeater = fn (string $entity, string $label) => Section::make($label)->schema([
            Repeater::make("status_configs.{$entity}")
                ->label('')
                ->schema([
                    Grid::make(4)->schema([
                        TextInput::make('key')
                            ->label('Clé')
                            ->required()
                            ->maxLength(30),
                        TextInput::make('label')
                            ->label('Label affiché')
                            ->required()
                            ->maxLength(50),
                        Select::make('color')
                            ->label('Couleur')
                            ->options([
                                'gray' => 'Gris',
                                'info' => 'Bleu info',
                                'primary' => 'Primaire',
                                'warning' => 'Orange',
                                'success' => 'Vert',
                                'danger' => 'Rouge',
                            ])
                            ->required(),
                        TextInput::make('icon')
                            ->label('Icône Heroicon')
                            ->placeholder('heroicon-o-...'),
                    ]),
                ])
                ->collapsible()
                ->cloneable()
                ->addActionLabel('Ajouter un statut')
                ->defaultItems(0),
        ]);

        return Tab::make('Statuts & Workflows')
            ->icon('heroicon-o-arrow-path')
            ->visible(fn () => in_array($this->getRole(), ['superadmin', 'admin']))
            ->schema([
                $statusRepeater('post', 'Articles de blog'),
                $statusRepeater('audit_lead', 'Leads Audit GTB'),
                $statusRepeater('cee_lead', 'Leads CEE'),
                $statusRepeater('contact_message', 'Messages de contact'),
                $statusRepeater('gdpr_request', 'Demandes RGPD'),
            ]);
    }

    // ─── TAB: CATALOGUES ───────────────────────────────────

    protected function cataloguesTab(): Tab
    {
        return Tab::make('Catalogues')
            ->icon('heroicon-o-rectangle-stack')
            ->visible(fn () => in_array($this->getRole(), ['superadmin', 'admin']))
            ->schema([
                Section::make('Catégories blog')
                    ->schema([
                        Repeater::make('blog_categories_config')
                            ->label('')
                            ->schema([
                                Grid::make(3)->schema([
                                    TextInput::make('slug')->required()->maxLength(30),
                                    TextInput::make('label')->required()->maxLength(50),
                                    ColorPicker::make('color'),
                                ]),
                                Grid::make(2)->schema([
                                    TextInput::make('icon')->placeholder('book-open'),
                                    TextInput::make('description')->maxLength(200),
                                ]),
                            ])
                            ->collapsible()
                            ->cloneable()
                            ->addActionLabel('Ajouter une catégorie'),
                    ]),

                Section::make('Protocoles GTB')
                    ->schema([
                        Repeater::make('gtb_protocols_config')
                            ->label('')
                            ->schema([
                                Grid::make(2)->schema([
                                    TextInput::make('slug')->required(),
                                    TextInput::make('label')->required(),
                                ]),
                                Textarea::make('description')->rows(2),
                            ])
                            ->collapsible()
                            ->addActionLabel('Ajouter un protocole'),
                    ]),

                Section::make('Niveaux EN 15232')
                    ->description('Classification des niveaux de GTB selon la norme européenne.')
                    ->schema([
                        Repeater::make('en15232_levels_config')
                            ->label('')
                            ->schema([
                                Grid::make(3)->schema([
                                    TextInput::make('key')->label('Classe')->required()->maxLength(1),
                                    TextInput::make('label')->required(),
                                    TextInput::make('savings')->label('Économies')->placeholder('30-40%'),
                                ]),
                                Textarea::make('description')->rows(2),
                            ])
                            ->collapsible()
                            ->addActionLabel('Ajouter un niveau'),
                    ]),

                Section::make('Paires de polices')
                    ->schema([
                        Repeater::make('font_pairs_config')
                            ->label('')
                            ->schema([
                                Grid::make(3)->schema([
                                    TextInput::make('key')->required()->maxLength(30),
                                    TextInput::make('label')->required(),
                                    TextInput::make('google_families')->label('Google Fonts families'),
                                ]),
                                Grid::make(2)->schema([
                                    TextInput::make('heading')->label('Police titres'),
                                    TextInput::make('body')->label('Police corps'),
                                ]),
                            ])
                            ->collapsible()
                            ->addActionLabel('Ajouter une paire'),
                    ]),
            ]);
    }

    // ─── TAB: EMAIL ────────────────────────────────────────

    protected function emailTab(): Tab
    {
        return Tab::make('Email')
            ->icon('heroicon-o-envelope')
            ->visible(fn () => in_array($this->getRole(), ['superadmin', 'admin']))
            ->schema([
                Section::make('Expéditeur')->schema([
                    Grid::make(2)->schema([
                        TextInput::make('email_from_name')
                            ->label('Nom de l\'expéditeur')
                            ->required(),
                        TextInput::make('email_from_address')
                            ->label('Adresse de l\'expéditeur')
                            ->email()
                            ->required(),
                    ]),
                ]),
                Section::make('Notifications admin')->schema([
                    Grid::make(2)->schema([
                        TextInput::make('email_notification_to')
                            ->label('Email de notification')
                            ->email(),
                        TextInput::make('email_notification_cc')
                            ->label('Email en copie (CC)')
                            ->email(),
                    ]),
                ]),
                Section::make('Test')->schema([
                    Actions::make([
                        Action::make('send_test_email')
                            ->label('Envoyer un email de test')
                            ->icon('heroicon-o-paper-airplane')
                            ->color('primary')
                            ->requiresConfirmation()
                            ->modalHeading('Envoyer un email de test ?')
                            ->modalDescription('Un email sera envoyé à l\'adresse de notification configurée.')
                            ->action(fn () => $this->sendTestEmail()),
                    ]),
                ]),
            ]);
    }

    // ─── TAB: SÉCURITÉ ─────────────────────────────────────

    protected function securityTab(): Tab
    {
        return Tab::make('Sécurité')
            ->icon('heroicon-o-shield-check')
            ->schema([
                Section::make('reCAPTCHA')->schema([
                    Grid::make(2)->schema([
                        TextInput::make('recaptcha_site_key')
                            ->label('Site Key')
                            ->password()
                            ->revealable(),
                        TextInput::make('recaptcha_secret_key')
                            ->label('Secret Key')
                            ->password()
                            ->revealable(),
                    ]),
                ]),
                Section::make('SMTP')->schema([
                    Grid::make(2)->schema([
                        TextInput::make('smtp_host')
                            ->label('Serveur SMTP'),
                        TextInput::make('smtp_port')
                            ->label('Port')
                            ->numeric(),
                        TextInput::make('smtp_user')
                            ->label('Utilisateur SMTP'),
                        TextInput::make('smtp_password')
                            ->label('Mot de passe SMTP')
                            ->password()
                            ->revealable(),
                        Select::make('smtp_encryption')
                            ->label('Chiffrement')
                            ->options([
                                'tls' => 'TLS',
                                'ssl' => 'SSL',
                                'none' => 'Aucun',
                            ]),
                    ]),
                ]),
            ]);
    }

    // ─── TAB: RGPD ─────────────────────────────────────────

    protected function rgpdTab(): Tab
    {
        $mins = config('neogtb.rgpd_min_retention', []);

        return Tab::make('RGPD')
            ->icon('heroicon-o-shield-exclamation')
            ->visible(fn () => in_array($this->getRole(), ['superadmin', 'admin']))
            ->schema([
                Section::make('Durées de rétention (jours)')
                    ->description('Durée après laquelle les données sont automatiquement supprimées.')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('rgpd_retention_contacts_days')
                                ->label('Contacts')
                                ->numeric()
                                ->suffix('jours')
                                ->minValue($mins['contacts'] ?? 90)
                                ->helperText('Minimum : ' . ($mins['contacts'] ?? 90) . ' jours'),
                            TextInput::make('rgpd_retention_leads_days')
                                ->label('Leads')
                                ->numeric()
                                ->suffix('jours')
                                ->minValue($mins['leads'] ?? 90)
                                ->helperText('Minimum : ' . ($mins['leads'] ?? 90) . ' jours'),
                            TextInput::make('rgpd_retention_cookies_days')
                                ->label('Cookies')
                                ->numeric()
                                ->suffix('jours')
                                ->minValue($mins['cookies'] ?? 30)
                                ->helperText('Minimum : ' . ($mins['cookies'] ?? 30) . ' jours'),
                            TextInput::make('rgpd_retention_newsletter_days')
                                ->label('Newsletter')
                                ->numeric()
                                ->suffix('jours')
                                ->minValue($mins['newsletter'] ?? 90)
                                ->helperText('Minimum : ' . ($mins['newsletter'] ?? 90) . ' jours'),
                        ]),
                    ]),
            ]);
    }

    // ─── TAB: STATISTIQUES ─────────────────────────────────

    protected function statsTab(): Tab
    {
        return Tab::make('Statistiques')
            ->icon('heroicon-o-presentation-chart-bar')
            ->schema([
                Section::make('Chiffres clés')
                    ->description('Affichés sur le site public (hero, pages, etc.).')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('stat_buildings_audited')
                                ->label('Bâtiments audités')
                                ->numeric()
                                ->suffix('bâtiments'),
                            Toggle::make('stat_buildings_auto')
                                ->label('Auto-calcul'),
                        ]),
                        Grid::make(2)->schema([
                            TextInput::make('stat_avg_savings_percent')
                                ->label('Économies moyennes')
                                ->numeric()
                                ->suffix('%'),
                            Toggle::make('stat_savings_auto')
                                ->label('Auto-calcul'),
                        ]),
                        Grid::make(2)->schema([
                            TextInput::make('stat_years_experience')
                                ->label('Années d\'expérience')
                                ->numeric()
                                ->suffix('ans'),
                            Toggle::make('stat_experience_auto')
                                ->label('Auto-calcul'),
                        ]),
                        Grid::make(2)->schema([
                            TextInput::make('stat_clients_count')
                                ->label('Nombre de clients')
                                ->numeric()
                                ->suffix('clients'),
                            Toggle::make('stat_clients_auto')
                                ->label('Auto-calcul'),
                        ]),
                    ]),
            ]);
    }
}
