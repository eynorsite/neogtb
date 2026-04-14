<?php

namespace App\Filament\Pages;

use App\Models\GeneralSetting;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Actions\Action;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
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

    public function form(Schema $form): Schema
    {
        return $form
            ->schema([
                Tabs::make('Settings')
                    ->persistTabInQueryString()
                    ->tabs(array_filter([
                        // ─── GROUPE 1 : IDENTITÉ & MARQUE ──────────────
                        $this->generalTab(),
                        $this->siteIdentityTab(),

                        // ─── GROUPE 2 : APPARENCE & THÈME ──────────────
                        $this->colorsTab(),
                        $this->typographyTab(),
                        $this->announcementTab(),

                        // ─── GROUPE 3 : NAVIGATION ─────────────────────
                        $this->navigationTab(),

                        // ─── GROUPE 4 : PAGE D'ACCUEIL & CONTENU ───────
                        $this->homepageTab(),

                        // ─── GROUPE 5 : SEO & TRACKING ─────────────────
                        $this->seoTab(),
                        $this->trackingTab(),

                        // ─── GROUPE 6 : TEXTES & LABELS (CRUCIAL) ──────
                        $this->labelsTab(),
                        $this->legalTab(),

                        // ─── GROUPE 7 : COMMUNICATION ──────────────────
                        $this->socialTab(),
                        $this->emailTab(),

                        // ─── GROUPE 8 : SYSTÈME ────────────────────────
                        $this->advancedTab(),
                        $this->statusTab(),
                        $this->cataloguesTab(),
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

    // ─── DEFAULTS ──────────────────────────────────────────

    /**
     * Paires de polices par défaut (fallback si font_pairs_config vide).
     *
     * @return array<int, array{key: string, label: string, heading: string, body: string, google_families: string}>
     */
    public static function defaultFontPairs(): array
    {
        return [
            ['key' => 'inter_dm_sans', 'label' => 'Inter + DM Sans', 'heading' => 'Inter', 'body' => 'DM Sans', 'google_families' => 'Inter:wght@400;500;600;700&family=DM+Sans:wght@400;500;700'],
            ['key' => 'inter_merriweather', 'label' => 'Inter + Merriweather', 'heading' => 'Inter', 'body' => 'Merriweather', 'google_families' => 'Inter:wght@400;500;600;700&family=Merriweather:wght@400;700'],
            ['key' => 'poppins_lora', 'label' => 'Poppins + Lora', 'heading' => 'Poppins', 'body' => 'Lora', 'google_families' => 'Poppins:wght@400;500;600;700&family=Lora:wght@400;700'],
            ['key' => 'montserrat_roboto', 'label' => 'Montserrat + Roboto', 'heading' => 'Montserrat', 'body' => 'Roboto', 'google_families' => 'Montserrat:wght@500;600;700&family=Roboto:wght@400;500'],
            ['key' => 'dm_sans_dm_serif', 'label' => 'DM Sans + DM Serif', 'heading' => 'DM Serif Display', 'body' => 'DM Sans', 'google_families' => 'DM+Sans:wght@400;500;700&family=DM+Serif+Display:wght@400'],
        ];
    }

    /**
     * Statuts par défaut (fallback si status_configs vide).
     *
     * @return array<string, array<int, array<string, string>>>
     */
    public static function defaultStatusConfigs(): array
    {
        return [
            'post' => [
                ['key' => 'draft', 'label' => 'Brouillon', 'color' => 'gray', 'icon' => 'heroicon-o-pencil'],
                ['key' => 'published', 'label' => 'Publié', 'color' => 'success', 'icon' => 'heroicon-o-check-circle'],
                ['key' => 'archived', 'label' => 'Archivé', 'color' => 'warning', 'icon' => 'heroicon-o-archive-box'],
            ],
            'audit_lead' => [
                ['key' => 'new', 'label' => 'Nouveau', 'color' => 'info', 'icon' => 'heroicon-o-sparkles'],
                ['key' => 'contacted', 'label' => 'Contacté', 'color' => 'primary', 'icon' => 'heroicon-o-phone'],
                ['key' => 'qualified', 'label' => 'Qualifié', 'color' => 'warning', 'icon' => 'heroicon-o-star'],
                ['key' => 'converted', 'label' => 'Converti', 'color' => 'success', 'icon' => 'heroicon-o-check-badge'],
                ['key' => 'lost', 'label' => 'Perdu', 'color' => 'danger', 'icon' => 'heroicon-o-x-circle'],
            ],
            'cee_lead' => [
                ['key' => 'new', 'label' => 'Nouveau', 'color' => 'info', 'icon' => 'heroicon-o-sparkles'],
                ['key' => 'processing', 'label' => 'En traitement', 'color' => 'warning', 'icon' => 'heroicon-o-clock'],
                ['key' => 'sent', 'label' => 'Dossier envoyé', 'color' => 'primary', 'icon' => 'heroicon-o-paper-airplane'],
                ['key' => 'signed', 'label' => 'Signé', 'color' => 'success', 'icon' => 'heroicon-o-check-circle'],
            ],
            'contact_message' => [
                ['key' => 'new', 'label' => 'Nouveau', 'color' => 'info', 'icon' => 'heroicon-o-envelope'],
                ['key' => 'read', 'label' => 'Lu', 'color' => 'gray', 'icon' => 'heroicon-o-eye'],
                ['key' => 'replied', 'label' => 'Répondu', 'color' => 'success', 'icon' => 'heroicon-o-check-circle'],
                ['key' => 'archived', 'label' => 'Archivé', 'color' => 'warning', 'icon' => 'heroicon-o-archive-box'],
            ],
        ];
    }

    /**
     * Sections d'accueil par défaut (fallback si homepage_sections vide).
     *
     * @return array<int, string>
     */
    public static function defaultHomepageSections(): array
    {
        return ['hero', 'expertises', 'chiffres', 'comparatif', 'solutions', 'temoignages', 'faq', 'cta_audit', 'blog_recent'];
    }

    // ─── RE-SEED DEFAULTS ──────────────────────────────────

    public function reseedDefaults(): void
    {
        $settings = GeneralSetting::get()->fresh();
        $applied = [];

        $defaults = [
            'font_pairs_config' => static::defaultFontPairs(),
            'status_configs' => static::defaultStatusConfigs(),
            'homepage_sections' => static::defaultHomepageSections(),
        ];

        foreach ($defaults as $field => $value) {
            $current = $settings->{$field};
            if (empty($current)) {
                $settings->{$field} = $value;
                $applied[] = $field;
            }
        }

        if (empty($applied)) {
            Notification::make()
                ->title('Rien à restaurer')
                ->body('Toutes les configurations critiques ont déjà des valeurs.')
                ->info()
                ->send();

            return;
        }

        $settings->save();
        GeneralSetting::clearCache();
        app(\App\Services\SiteConfigService::class)->clearCache();

        Notification::make()
            ->title('Configurations restaurées')
            ->body('Champs remplis : ' . implode(', ', $applied) . '. Rafraîchis la page pour voir les nouvelles options.')
            ->success()
            ->send();
    }

    // ─── BACKUP BDD ────────────────────────────────────────

    public function backupDatabase()
    {
        $dbPath = config('database.connections.sqlite.database');

        if (! $dbPath || ! is_file($dbPath)) {
            Notification::make()->title('BDD introuvable')->body('Seul SQLite est pris en charge.')->danger()->send();

            return null;
        }

        $filename = 'neogtb-backup-' . now()->format('Ymd-His') . '.sqlite.gz';
        $tmpPath = storage_path('app/' . $filename);

        $in = fopen($dbPath, 'rb');
        $out = gzopen($tmpPath, 'wb9');
        if (! $in || ! $out) {
            Notification::make()->title('Erreur backup')->body('Lecture/écriture impossible.')->danger()->send();

            return null;
        }
        while (! feof($in)) {
            gzwrite($out, fread($in, 8192));
        }
        fclose($in);
        gzclose($out);

        return response()->download($tmpPath, $filename, [
            'Content-Type' => 'application/gzip',
        ])->deleteFileAfterSend();
    }

    // ─── TEST LIENS NAVIGATION ─────────────────────────────

    public function testNavigationLinks(): void
    {
        $items = \App\Models\NavigationItem::where('is_active', true)
            ->whereNotNull('url')
            ->where('url', '!=', '')
            ->get(['id', 'label', 'url']);

        if ($items->isEmpty()) {
            Notification::make()->title('Aucun lien à tester')->warning()->send();

            return;
        }

        $base = rtrim(config('app.url'), '/');
        $results = [];
        $ok = 0;
        $ko = 0;

        foreach ($items as $item) {
            $url = $item->url;
            if (! str_starts_with($url, 'http')) {
                $url = $base . '/' . ltrim($url, '/');
            }

            try {
                $response = \Illuminate\Support\Facades\Http::timeout(3)
                    ->connectTimeout(2)
                    ->withUserAgent('NeoGTB-Admin-LinkChecker')
                    ->head($url);
                $status = $response->status();
                if ($status >= 200 && $status < 400) {
                    $ok++;
                    $results[] = "✅ <code>$status</code> — " . e($item->label) . ' (' . e($url) . ')';
                } else {
                    $ko++;
                    $results[] = "❌ <code>$status</code> — " . e($item->label) . ' (' . e($url) . ')';
                }
            } catch (\Throwable $e) {
                $ko++;
                $results[] = '⏱ <em>timeout</em> — ' . e($item->label) . ' (' . e($url) . ')';
            }
        }

        $body = '<div style="font-size:12px;line-height:1.6;">' . implode('<br>', $results) . '</div>';

        Notification::make()
            ->title("Liens testés : $ok OK / $ko KO")
            ->body(new \Illuminate\Support\HtmlString($body))
            ->{$ko === 0 ? 'success' : 'warning'}()
            ->persistent()
            ->send();
    }

    // ─── PURGE SESSIONS EXPIRÉES ───────────────────────────

    public function purgeExpiredSessions(): void
    {
        $lifetime = (int) config('session.lifetime', 120);
        $cutoff = now()->subMinutes($lifetime)->timestamp;

        $deleted = \Illuminate\Support\Facades\DB::table('sessions')
            ->where('last_activity', '<', $cutoff)
            ->delete();

        Notification::make()
            ->title('Sessions purgées')
            ->body("$deleted sessions expirées supprimées (seuil : $lifetime min).")
            ->success()
            ->send();
    }

    // ─── QUEUE RESTART ─────────────────────────────────────

    public function restartQueue(): void
    {
        Artisan::call('queue:restart');

        Notification::make()
            ->title('Queue redémarrée')
            ->body('Les workers Supervisor vont recharger le code à leur prochain job.')
            ->success()
            ->send();
    }

    // ─── LOGOUT OTHER SESSIONS ─────────────────────────────

    public function logoutOtherSessions(): void
    {
        $admin = auth()->guard('admin')->user();
        if (! $admin) {
            return;
        }

        $currentId = session()->getId();
        $deleted = \Illuminate\Support\Facades\DB::table('sessions')
            ->where('user_id', $admin->id)
            ->where('id', '!=', $currentId)
            ->delete();

        Notification::make()
            ->title('Autres sessions déconnectées')
            ->body("$deleted session(s) fermée(s) sur les autres appareils.")
            ->success()
            ->send();
    }

    // ─── DONNÉES POUR AFFICHAGE ────────────────────────────

    protected function getSystemStats(): array
    {
        $dbPath = config('database.connections.sqlite.database');
        $dbSize = is_file($dbPath) ? filesize($dbPath) : 0;

        $storagePath = storage_path('app');
        $storageSize = 0;
        if (is_dir($storagePath)) {
            $it = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($storagePath, \FilesystemIterator::SKIP_DOTS));
            foreach ($it as $file) {
                if ($file->isFile()) {
                    $storageSize += $file->getSize();
                }
            }
        }

        return [
            'db_size' => $dbSize,
            'storage_size' => $storageSize,
            'admin_count' => \App\Models\Admin::count(),
            'active_sessions' => \Illuminate\Support\Facades\DB::table('sessions')->count(),
            'auth_sessions' => \Illuminate\Support\Facades\DB::table('sessions')->whereNotNull('user_id')->count(),
            'posts_count' => \App\Models\Post::count(),
            'messages_count' => \App\Models\ContactMessage::count(),
            'leads_count' => \App\Models\AuditLead::count(),
        ];
    }

    protected function getRecentErrorLogs(int $lines = 50): string
    {
        $logFile = storage_path('logs/laravel.log');
        if (! is_file($logFile)) {
            return 'Fichier log introuvable.';
        }

        $size = filesize($logFile);
        if ($size === 0) {
            return 'Aucun log pour le moment.';
        }

        // Lit les N dernières lignes de façon efficace
        $handle = fopen($logFile, 'r');
        $chunk = 8192;
        $readSize = min($size, 64 * 1024); // max 64 KB en fin de fichier
        fseek($handle, -$readSize, SEEK_END);
        $content = fread($handle, $readSize);
        fclose($handle);

        $allLines = preg_split('/\r?\n/', $content);
        $tail = array_slice($allLines, -$lines);

        return implode("\n", $tail);
    }

    /**
     * @return array<int, object>
     */
    protected function getActiveSessionsForAdmin(): array
    {
        $admin = auth()->guard('admin')->user();
        if (! $admin) {
            return [];
        }

        return \Illuminate\Support\Facades\DB::table('sessions')
            ->where('user_id', $admin->id)
            ->orderByDesc('last_activity')
            ->limit(20)
            ->get(['id', 'ip_address', 'user_agent', 'last_activity'])
            ->toArray();
    }

    /**
     * @return array<int, \App\Models\Admin>
     */
    protected function getAdminsLoginJournal(): \Illuminate\Support\Collection
    {
        return \App\Models\Admin::select(['id', 'name', 'email', 'role', 'last_login_at', 'last_login_ip', 'is_active'])
            ->orderByDesc('last_login_at')
            ->limit(15)
            ->get();
    }

    protected function formatBytes(int $bytes): string
    {
        if ($bytes < 1024) {
            return "$bytes o";
        }
        if ($bytes < 1048576) {
            return round($bytes / 1024, 1) . ' Ko';
        }
        if ($bytes < 1073741824) {
            return round($bytes / 1048576, 1) . ' Mo';
        }

        return round($bytes / 1073741824, 2) . ' Go';
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
            ->id('identite-visuelle')
            ->icon('heroicon-o-photo')
            ->schema([
                Section::make('Logos')->schema([
                    Grid::make(3)->schema([
                        FileUpload::make('company_logo')
                            ->label('Logo principal')
                            ->image()
                            ->disk('public')
                            ->visibility('public')
                            ->directory('logos')
                            ->maxSize(2048),
                        FileUpload::make('company_logo_white')
                            ->label('Logo blanc (fond sombre)')
                            ->image()
                            ->disk('public')
                            ->visibility('public')
                            ->directory('logos')
                            ->maxSize(2048),
                        FileUpload::make('company_logo_icon')
                            ->label('Logo icône (carré)')
                            ->image()
                            ->disk('public')
                            ->visibility('public')
                            ->directory('logos')
                            ->maxSize(1024),
                    ]),
                ]),
                Section::make('Favicon & Open Graph')->schema([
                    Grid::make(2)->schema([
                        FileUpload::make('favicon')
                            ->label('Favicon')
                            ->image()
                            ->disk('public')
                            ->visibility('public')
                            ->directory('logos')
                            ->maxSize(512)
                            ->helperText('32x32px recommandé'),
                        FileUpload::make('og_default_image')
                            ->label('Image Open Graph par défaut')
                            ->image()
                            ->disk('public')
                            ->visibility('public')
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
                            ->options(function () {
                                $pairs = GeneralSetting::first()?->font_pairs_config ?? [];
                                if (empty($pairs)) {
                                    $pairs = static::defaultFontPairs();
                                }

                                return collect($pairs)->pluck('label', 'key')->toArray();
                            }),
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
                            ->disk('public')
                            ->visibility('public')
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
            ->id('seo')
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
                Section::make('Maintenance & diagnostics')
                    ->description('Outils de cache, tests, backup, redémarrage de la queue.')
                    ->schema([
                        Actions::make([
                            Action::make('clear_cache')
                                ->label('Vider le cache')
                                ->icon('heroicon-o-trash')
                                ->color('danger')
                                ->requiresConfirmation()
                                ->action(fn () => $this->clearAllCache()),
                            Action::make('optimize_app')
                                ->label('Optimiser')
                                ->icon('heroicon-o-bolt')
                                ->color('success')
                                ->action(fn () => $this->optimize()),
                            Action::make('backup_db')
                                ->label('Sauvegarder la BDD')
                                ->icon('heroicon-o-arrow-down-tray')
                                ->color('primary')
                                ->action(fn () => $this->backupDatabase()),
                            Action::make('test_email')
                                ->label('Envoyer un email de test')
                                ->icon('heroicon-o-envelope')
                                ->color('info')
                                ->requiresConfirmation()
                                ->modalDescription(fn () => 'Envoi à l\'adresse de notification : ' . ($this->data['email_notification_to'] ?? '— (champ vide, Communication → Email)'))
                                ->action(fn () => $this->sendTestEmail()),
                            Action::make('test_links')
                                ->label('Tester les liens du menu')
                                ->icon('heroicon-o-link')
                                ->color('gray')
                                ->action(fn () => $this->testNavigationLinks()),
                            Action::make('purge_sessions')
                                ->label('Purger sessions expirées')
                                ->icon('heroicon-o-finger-print')
                                ->color('warning')
                                ->requiresConfirmation()
                                ->action(fn () => $this->purgeExpiredSessions()),
                            Action::make('restart_queue')
                                ->label('Redémarrer la queue')
                                ->icon('heroicon-o-arrow-path')
                                ->color('gray')
                                ->requiresConfirmation()
                                ->modalDescription('Les workers Supervisor rechargent le code à leur prochain job.')
                                ->action(fn () => $this->restartQueue()),
                            Action::make('reseed_defaults')
                                ->label('Restaurer configs par défaut')
                                ->icon('heroicon-o-arrow-uturn-left')
                                ->color('warning')
                                ->requiresConfirmation()
                                ->modalDescription('Repeuple les champs critiques vides (polices, statuts, sections accueil). N\'écrase jamais de valeur existante.')
                                ->action(fn () => $this->reseedDefaults()),
                        ]),
                    ]),

                Section::make('Santé du système')
                    ->description('État de l\'environnement et indicateurs de volume.')
                    ->schema([
                        Placeholder::make('system_health')
                            ->label('')
                            ->content(function () {
                                $debug = config('app.debug');
                                $env = config('app.env');
                                $stats = $this->getSystemStats();

                                $card = fn (string $icon, string $label, string $value) => '<div style="display:flex;align-items:center;gap:10px;padding:12px 14px;background:#FAFBFC;border-radius:10px;border:1px solid #F1F5F9;">'
                                    . '<span style="font-size:16px;">' . $icon . '</span>'
                                    . '<div style="flex:1;"><div style="font-size:11px;color:#6B7280;font-weight:500;text-transform:uppercase;letter-spacing:0.5px;">' . $label . '</div>'
                                    . '<div style="font-size:13px;color:#111827;font-weight:600;margin-top:2px;">' . $value . '</div></div>'
                                    . '</div>';

                                $items = [
                                    $card(! $debug ? '✅' : '❌', 'APP_DEBUG', $debug ? 'true (⚠ prod)' : 'false'),
                                    $card($env === 'production' ? '✅' : '⚠️', 'Environnement', e($env)),
                                    $card('🐘', 'PHP', phpversion()),
                                    $card('🦴', 'Laravel', app()->version()),
                                    $card('💾', 'Taille BDD', $this->formatBytes($stats['db_size'])),
                                    $card('📁', 'Poids storage/', $this->formatBytes($stats['storage_size'])),
                                    $card('👥', 'Admins', (string) $stats['admin_count']),
                                    $card('🍪', 'Sessions (total / authent.)', $stats['active_sessions'] . ' / ' . $stats['auth_sessions']),
                                    $card('📝', 'Articles', (string) $stats['posts_count']),
                                    $card('✉️', 'Messages contact', (string) $stats['messages_count']),
                                    $card('🏢', 'Demandes d\'audit', (string) $stats['leads_count']),
                                ];

                                return new \Illuminate\Support\HtmlString(
                                    '<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:10px;">'
                                    . implode('', $items)
                                    . '</div>'
                                );
                            }),
                    ]),

                Section::make('Sessions actives')
                    ->description('Tes connexions en cours. Tu peux fermer les autres appareils.')
                    ->collapsible()
                    ->collapsed()
                    ->schema([
                        Actions::make([
                            Action::make('logout_others')
                                ->label('Déconnecter les autres appareils')
                                ->icon('heroicon-o-power')
                                ->color('warning')
                                ->requiresConfirmation()
                                ->action(fn () => $this->logoutOtherSessions()),
                        ]),
                        Placeholder::make('active_sessions_list')
                            ->label('')
                            ->content(function () {
                                $sessions = $this->getActiveSessionsForAdmin();
                                if (empty($sessions)) {
                                    return new \Illuminate\Support\HtmlString('<div style="padding:16px;color:#6B7280;font-size:13px;">Aucune session active enregistrée.</div>');
                                }

                                $currentId = session()->getId();
                                $rows = [];
                                foreach ($sessions as $s) {
                                    $isCurrent = $s->id === $currentId;
                                    $ua = mb_strimwidth($s->user_agent ?? '—', 0, 80, '…');
                                    $when = \Carbon\Carbon::createFromTimestamp($s->last_activity)->diffForHumans();
                                    $rows[] = '<tr style="border-bottom:1px solid #F1F5F9;">'
                                        . '<td style="padding:8px;font-size:12px;">' . ($isCurrent ? '🟢 <b>actuel</b>' : '⚪') . '</td>'
                                        . '<td style="padding:8px;font-size:12px;font-family:monospace;">' . e($s->ip_address ?? '—') . '</td>'
                                        . '<td style="padding:8px;font-size:12px;color:#6B7280;">' . e($ua) . '</td>'
                                        . '<td style="padding:8px;font-size:12px;">' . e($when) . '</td>'
                                        . '</tr>';
                                }

                                return new \Illuminate\Support\HtmlString(
                                    '<table style="width:100%;border-collapse:collapse;font-size:13px;">'
                                    . '<thead><tr style="border-bottom:2px solid #E5E7EB;text-align:left;">'
                                    . '<th style="padding:8px;font-size:11px;text-transform:uppercase;color:#6B7280;">État</th>'
                                    . '<th style="padding:8px;font-size:11px;text-transform:uppercase;color:#6B7280;">IP</th>'
                                    . '<th style="padding:8px;font-size:11px;text-transform:uppercase;color:#6B7280;">User-Agent</th>'
                                    . '<th style="padding:8px;font-size:11px;text-transform:uppercase;color:#6B7280;">Activité</th>'
                                    . '</tr></thead><tbody>' . implode('', $rows) . '</tbody></table>'
                                );
                            }),
                    ]),

                Section::make('Dernières connexions admin')
                    ->description('Qui s\'est connecté récemment et depuis quelle IP.')
                    ->collapsible()
                    ->collapsed()
                    ->schema([
                        Placeholder::make('admin_login_journal')
                            ->label('')
                            ->content(function () {
                                $admins = $this->getAdminsLoginJournal();
                                if ($admins->isEmpty()) {
                                    return new \Illuminate\Support\HtmlString('<div style="padding:16px;color:#6B7280;">Aucun admin.</div>');
                                }

                                $rows = [];
                                foreach ($admins as $a) {
                                    $when = $a->last_login_at ? $a->last_login_at->diffForHumans() : '<em style="color:#9CA3AF;">jamais</em>';
                                    $statusIcon = $a->is_active ? '🟢' : '⚫';
                                    $rows[] = '<tr style="border-bottom:1px solid #F1F5F9;">'
                                        . '<td style="padding:8px;font-size:12px;">' . $statusIcon . ' ' . e($a->name) . '</td>'
                                        . '<td style="padding:8px;font-size:12px;font-family:monospace;">' . e($a->email) . '</td>'
                                        . '<td style="padding:8px;font-size:12px;"><span style="padding:2px 8px;background:#EDE9FE;color:#6C3AED;border-radius:6px;font-weight:600;">' . e($a->role) . '</span></td>'
                                        . '<td style="padding:8px;font-size:12px;">' . $when . '</td>'
                                        . '<td style="padding:8px;font-size:12px;font-family:monospace;color:#6B7280;">' . e($a->last_login_ip ?? '—') . '</td>'
                                        . '</tr>';
                                }

                                return new \Illuminate\Support\HtmlString(
                                    '<table style="width:100%;border-collapse:collapse;font-size:13px;">'
                                    . '<thead><tr style="border-bottom:2px solid #E5E7EB;text-align:left;">'
                                    . '<th style="padding:8px;font-size:11px;text-transform:uppercase;color:#6B7280;">Nom</th>'
                                    . '<th style="padding:8px;font-size:11px;text-transform:uppercase;color:#6B7280;">Email</th>'
                                    . '<th style="padding:8px;font-size:11px;text-transform:uppercase;color:#6B7280;">Rôle</th>'
                                    . '<th style="padding:8px;font-size:11px;text-transform:uppercase;color:#6B7280;">Dernière connexion</th>'
                                    . '<th style="padding:8px;font-size:11px;text-transform:uppercase;color:#6B7280;">IP</th>'
                                    . '</tr></thead><tbody>' . implode('', $rows) . '</tbody></table>'
                                );
                            }),
                    ]),

                Section::make('Logs récents')
                    ->description('50 dernières lignes de storage/logs/laravel.log.')
                    ->collapsible()
                    ->collapsed()
                    ->schema([
                        Placeholder::make('recent_logs')
                            ->label('')
                            ->content(function () {
                                $logs = $this->getRecentErrorLogs(50);

                                return new \Illuminate\Support\HtmlString(
                                    '<pre style="background:#0F172A;color:#E2E8F0;padding:16px;border-radius:10px;font-size:11px;line-height:1.5;max-height:400px;overflow:auto;white-space:pre-wrap;word-break:break-all;">'
                                    . e($logs)
                                    . '</pre>'
                                );
                            }),
                    ]),
            ]);
    }

    // ─── TAB: LABELS D'INTERFACE ───────────────────────────

    /**
     * Helper: génère un TextInput ou Textarea selon la longueur probable du texte.
     */
    protected function labelField(string $path, string $label, bool $long = false, int $rows = 2, bool $full = false)
    {
        $field = $long
            ? Textarea::make($path)->label($label)->rows($rows)
            : TextInput::make($path)->label($label);

        if ($full || $long) {
            $field->columnSpanFull();
        }

        return $field;
    }

    protected function labelsTab(): Tab
    {
        return Tab::make('Textes du site')
            ->id('textes-du-site')
            ->icon('heroicon-o-tag')
            ->schema([
                // ─── NAVIGATION (header + menu mobile) ──────────
                Section::make('Navigation (header)')
                    ->description('Libellés du menu principal et des éléments de navigation.')
                    ->collapsible()
                    ->columns(3)
                    ->schema([
                        TextInput::make('ui_labels.nav.home')->label('Accueil'),
                        TextInput::make('ui_labels.nav.blog')->label('Blog / Perspectives'),
                        TextInput::make('ui_labels.nav.explorer')->label('Explorer'),
                        TextInput::make('ui_labels.nav.about')->label('À propos'),
                        TextInput::make('ui_labels.nav.faq')->label('FAQ'),
                        TextInput::make('ui_labels.nav.contact')->label('Contact'),
                        TextInput::make('ui_labels.nav.search')->label('Rechercher (bouton)'),
                        TextInput::make('ui_labels.nav.search_placeholder')->label('Rechercher (placeholder)'),
                        TextInput::make('ui_labels.nav.open_menu')->label('Ouvrir le menu (a11y)'),
                        TextInput::make('ui_labels.nav.close_menu')->label('Fermer le menu (a11y)'),
                        TextInput::make('ui_labels.nav.help_prompt')->label('Besoin d\'aide'),
                        TextInput::make('ui_labels.nav.help_cta')->label('CTA aide (expert)'),
                        TextInput::make('ui_labels.nav.mobile_rgpd')->label('Lien RGPD mobile'),
                    ]),

                // ─── LAYOUT & BREADCRUMB ───────────────────────
                Section::make('Layout & fil d\'Ariane')
                    ->collapsible()
                    ->collapsed()
                    ->columns(2)
                    ->schema([
                        TextInput::make('ui_labels.layout.skip_link')->label('Skip link (accessibilité)'),
                        TextInput::make('ui_labels.layout.breadcrumb_label')->label('Label du fil d\'Ariane'),
                        TextInput::make('ui_labels.breadcrumb.home')->label('Breadcrumb — Accueil'),
                        TextInput::make('ui_labels.breadcrumb.tools')->label('Breadcrumb — Outils'),
                    ]),

                // ─── PIED DE PAGE ──────────────────────────────
                Section::make('Pied de page')
                    ->description('Colonnes, newsletter et liens du footer.')
                    ->collapsible()
                    ->collapsed()
                    ->columns(2)
                    ->schema([
                        Textarea::make('ui_labels.footer.brand_description')->label('Description de marque')->rows(3)->columnSpanFull(),
                        TextInput::make('ui_labels.footer.col1_title')->label('Colonne 1 — Titre'),
                        TextInput::make('ui_labels.footer.col2_title')->label('Colonne 2 — Titre'),
                        TextInput::make('ui_labels.footer.col3_title')->label('Colonne 3 — Titre'),
                        TextInput::make('ui_labels.footer.newsletter_subtitle')->label('Newsletter — sous-titre'),
                        TextInput::make('ui_labels.footer.newsletter_placeholder')->label('Newsletter — placeholder'),
                        TextInput::make('ui_labels.footer.newsletter_button')->label('Newsletter — bouton'),
                        TextInput::make('ui_labels.footer.newsletter_sr_label')->label('Newsletter — label a11y'),
                        TextInput::make('ui_labels.footer.newsletter_aria')->label('Newsletter — aria'),
                        Textarea::make('ui_labels.footer.newsletter_success')->label('Newsletter — succès')->rows(2)->columnSpanFull(),
                        Textarea::make('ui_labels.footer.newsletter_consent')->label('Newsletter — consentement')->rows(2)->columnSpanFull(),
                        TextInput::make('ui_labels.footer.newsletter_frequency')->label('Newsletter — fréquence'),
                        TextInput::make('ui_labels.footer.nav_gtb')->label('Lien GTB'),
                        TextInput::make('ui_labels.footer.nav_gtc')->label('Lien GTC'),
                        TextInput::make('ui_labels.footer.nav_solutions')->label('Lien Solutions'),
                        TextInput::make('ui_labels.footer.nav_comparateur')->label('Lien Comparateur'),
                        TextInput::make('ui_labels.footer.nav_reglementation')->label('Lien Réglementation'),
                        TextInput::make('ui_labels.footer.nav_blog')->label('Lien Blog'),
                        TextInput::make('ui_labels.footer.nav_audit')->label('Lien Audit / Pré-diagnostic'),
                        TextInput::make('ui_labels.footer.nav_generateur_cee')->label('Lien Générateur CEE'),
                        TextInput::make('ui_labels.footer.nav_tables_modbus')->label('Lien Tables Modbus'),
                        TextInput::make('ui_labels.footer.nav_contact')->label('Lien Contact'),
                        TextInput::make('ui_labels.footer.nav_faq')->label('Lien FAQ'),
                        TextInput::make('ui_labels.footer.nav_mentions')->label('Lien Mentions légales'),
                        TextInput::make('ui_labels.footer.nav_confidentialite')->label('Lien Confidentialité'),
                        TextInput::make('ui_labels.footer.nav_cookies')->label('Lien Cookies'),
                        TextInput::make('ui_labels.footer.nav_rgpd')->label('Lien RGPD'),
                        TextInput::make('ui_labels.footer.manage_cookies')->label('Bouton "Gérer les cookies"'),
                    ]),

                // ─── FORMULAIRES ───────────────────────────────
                Section::make('Formulaires')
                    ->description('Libellés communs aux formulaires (contact, newsletter, audit).')
                    ->collapsible()
                    ->collapsed()
                    ->columns(2)
                    ->schema([
                        TextInput::make('ui_labels.forms.name')->label('Nom'),
                        TextInput::make('ui_labels.forms.name_placeholder')->label('Nom — placeholder'),
                        TextInput::make('ui_labels.forms.email')->label('Email'),
                        TextInput::make('ui_labels.forms.email_placeholder')->label('Email — placeholder'),
                        TextInput::make('ui_labels.forms.company')->label('Entreprise'),
                        TextInput::make('ui_labels.forms.company_placeholder')->label('Entreprise — placeholder'),
                        TextInput::make('ui_labels.forms.optional')->label('Mention optionnelle'),
                        TextInput::make('ui_labels.forms.subject')->label('Sujet'),
                        TextInput::make('ui_labels.forms.subject_placeholder')->label('Sujet — placeholder'),
                        TextInput::make('ui_labels.forms.subject_quote')->label('Sujet — devis'),
                        TextInput::make('ui_labels.forms.subject_tech')->label('Sujet — technique'),
                        TextInput::make('ui_labels.forms.subject_regulation')->label('Sujet — réglementaire'),
                        TextInput::make('ui_labels.forms.subject_audit')->label('Sujet — audit'),
                        TextInput::make('ui_labels.forms.subject_other')->label('Sujet — autre'),
                        TextInput::make('ui_labels.forms.message')->label('Message'),
                        TextInput::make('ui_labels.forms.message_placeholder')->label('Message — placeholder'),
                        TextInput::make('ui_labels.forms.submit')->label('Bouton envoyer'),
                        TextInput::make('ui_labels.forms.sending')->label('Bouton — en cours'),
                        TextInput::make('ui_labels.forms.cancel')->label('Bouton annuler'),
                        TextInput::make('ui_labels.forms.continue')->label('Bouton continuer'),
                        TextInput::make('ui_labels.forms.previous')->label('Bouton précédent'),
                        TextInput::make('ui_labels.forms.next')->label('Bouton suivant'),
                        TextInput::make('ui_labels.forms.yes')->label('Oui'),
                        TextInput::make('ui_labels.forms.no')->label('Non'),
                        TextInput::make('ui_labels.forms.building_type')->label('Type de bâtiment'),
                        TextInput::make('ui_labels.forms.surface')->label('Surface utile'),
                        TextInput::make('ui_labels.forms.building_age')->label('Année de construction'),
                        TextInput::make('ui_labels.forms.climate_zone')->label('Zone climatique'),
                        TextInput::make('ui_labels.forms.select_placeholder')->label('Sélecteur — placeholder'),
                        Textarea::make('ui_labels.forms.rgpd_consent')->label('Consentement RGPD')->rows(2)->columnSpanFull(),
                        TextInput::make('ui_labels.forms.privacy_link')->label('Lien "Politique"'),
                        TextInput::make('ui_labels.forms.rights_link')->label('Lien "Exercer vos droits"'),
                    ]),

                // ─── VALIDATION ────────────────────────────────
                Section::make('Messages de validation')
                    ->collapsible()
                    ->collapsed()
                    ->columns(2)
                    ->schema([
                        TextInput::make('ui_labels.validation.required')->label('Champ obligatoire'),
                        TextInput::make('ui_labels.validation.email_invalid')->label('Email invalide'),
                        TextInput::make('ui_labels.validation.phone_invalid')->label('Téléphone invalide'),
                        TextInput::make('ui_labels.validation.min_length')->label('Longueur min'),
                        TextInput::make('ui_labels.validation.max_length')->label('Longueur max'),
                    ]),

                // ─── CTA GLOBAUX ───────────────────────────────
                Section::make('Appels à l\'action (CTA globaux)')
                    ->collapsible()
                    ->collapsed()
                    ->columns(2)
                    ->schema([
                        TextInput::make('ui_labels.cta.start_diagnostic')->label('Lancer le diagnostic'),
                        TextInput::make('ui_labels.cta.contact_me')->label('Me contacter'),
                        TextInput::make('ui_labels.cta.back_to_blog')->label('Retour au blog'),
                    ]),

                // ─── STICKY CTA ────────────────────────────────
                Section::make('Sticky CTA (bouton flottant)')
                    ->collapsible()
                    ->collapsed()
                    ->columns(2)
                    ->schema([
                        TextInput::make('ui_labels.sticky_cta.aria_label')->label('Aria label'),
                        TextInput::make('ui_labels.sticky_cta.badge')->label('Badge'),
                        TextInput::make('ui_labels.sticky_cta.title')->label('Titre'),
                        TextInput::make('ui_labels.sticky_cta.button')->label('Bouton'),
                        TextInput::make('ui_labels.sticky_cta.dismiss')->label('Fermer'),
                    ]),

                // ─── COOKIES BANDEAU ───────────────────────────
                Section::make('Bandeau cookies')
                    ->collapsible()
                    ->collapsed()
                    ->columns(2)
                    ->schema([
                        TextInput::make('ui_labels.cookie.title')->label('Titre'),
                        Textarea::make('ui_labels.cookie.description')->label('Description')->rows(2)->columnSpanFull(),
                        TextInput::make('ui_labels.cookie.accept')->label('Bouton accepter'),
                        TextInput::make('ui_labels.cookie.reject')->label('Bouton refuser'),
                        TextInput::make('ui_labels.cookie.customize')->label('Bouton personnaliser'),
                        TextInput::make('ui_labels.cookie.save_preferences')->label('Bouton enregistrer'),
                        TextInput::make('ui_labels.cookie.necessary_title')->label('Cookies nécessaires — titre'),
                        TextInput::make('ui_labels.cookie.necessary_desc')->label('Cookies nécessaires — desc'),
                        TextInput::make('ui_labels.cookie.analytics_title')->label('Cookies analytics — titre'),
                        TextInput::make('ui_labels.cookie.analytics_desc')->label('Cookies analytics — desc'),
                    ]),

                // ─── PAGINATION & DIVERS ───────────────────────
                Section::make('Pagination & divers')
                    ->collapsible()
                    ->collapsed()
                    ->columns(3)
                    ->schema([
                        TextInput::make('ui_labels.pagination.previous')->label('Précédent'),
                        TextInput::make('ui_labels.pagination.next')->label('Suivant'),
                        TextInput::make('ui_labels.pagination.showing')->label('Affichage de'),
                        TextInput::make('ui_labels.pagination.to')->label('à'),
                        TextInput::make('ui_labels.pagination.of')->label('sur'),
                        TextInput::make('ui_labels.pagination.results')->label('Résultats'),
                        TextInput::make('ui_labels.misc.reading_time_unit')->label('Unité temps (min)'),
                        TextInput::make('ui_labels.misc.reading_time')->label('Temps de lecture'),
                        TextInput::make('ui_labels.misc.views')->label('Vues'),
                        TextInput::make('ui_labels.misc.share')->label('Partager'),
                        TextInput::make('ui_labels.misc.link_copied')->label('Lien copié'),
                        TextInput::make('ui_labels.misc.copy_link')->label('Copier le lien'),
                        TextInput::make('ui_labels.search.placeholder')->label('Recherche blog — placeholder'),
                    ]),

                // ─── PAGE CONTACT ──────────────────────────────
                Section::make('Page Contact')
                    ->collapsible()
                    ->collapsed()
                    ->columns(2)
                    ->schema([
                        TextInput::make('ui_labels.contact.info_email')->label('Bloc — Email'),
                        TextInput::make('ui_labels.contact.info_phone')->label('Bloc — Téléphone'),
                        TextInput::make('ui_labels.contact.info_response_time')->label('Bloc — Temps de réponse'),
                        TextInput::make('ui_labels.contact.response_time_value')->label('Valeur du temps de réponse'),
                        TextInput::make('ui_labels.contact.trust_badge')->label('Badge de confiance')->columnSpanFull(),
                        TextInput::make('ui_labels.contact.success_title')->label('Succès — titre'),
                        Textarea::make('ui_labels.contact.success_message')->label('Succès — message')->rows(2)->columnSpanFull(),
                    ]),

                // ─── PAGE FAQ ──────────────────────────────────
                Section::make('Page FAQ')
                    ->description('Textes du hero et du CTA de la page /faq (les Q/R se gèrent dans Mon Site → Pages).')
                    ->collapsible()
                    ->collapsed()
                    ->columns(2)
                    ->schema([
                        TextInput::make('ui_labels.faq.eyebrow')->label('Eyebrow'),
                        TextInput::make('ui_labels.faq.title')->label('Titre H1'),
                        Textarea::make('ui_labels.faq.subtitle')->label('Sous-titre')->rows(2)->columnSpanFull(),
                        TextInput::make('ui_labels.faq.cta_text')->label('Texte CTA final'),
                        TextInput::make('ui_labels.faq.cta_button')->label('Bouton CTA final'),
                    ]),

                // ─── PAGE BLOG ─────────────────────────────────
                Section::make('Page Blog / Perspectives')
                    ->collapsible()
                    ->collapsed()
                    ->columns(2)
                    ->schema([
                        TextInput::make('ui_labels.blog.all_articles')->label('Lien "Tous les articles"'),
                        TextInput::make('ui_labels.blog.no_articles')->label('Aucun article'),
                        TextInput::make('ui_labels.blog.cta_title')->label('CTA — titre'),
                        Textarea::make('ui_labels.blog.cta_description')->label('CTA — description')->rows(2)->columnSpanFull(),
                        TextInput::make('ui_labels.blog.also_read')->label('À lire aussi'),
                        TextInput::make('ui_labels.blog.related_articles')->label('Articles similaires'),
                    ]),

                // ─── PAGE ABOUT ────────────────────────────────
                Section::make('Page À propos')
                    ->collapsible()
                    ->collapsed()
                    ->columns(2)
                    ->schema([
                        TextInput::make('ui_labels.about.hero.eyebrow')->label('Hero — eyebrow'),
                        Textarea::make('ui_labels.about.hero.title')->label('Hero — titre (HTML autorisé)')->rows(2)->columnSpanFull(),
                        Textarea::make('ui_labels.about.hero.subtitle')->label('Hero — sous-titre')->rows(3)->columnSpanFull(),
                        TextInput::make('ui_labels.about.founder.name')->label('Fondateur — nom'),
                        TextInput::make('ui_labels.about.founder.role')->label('Fondateur — rôle'),
                        TextInput::make('ui_labels.about.founder.company')->label('Fondateur — société'),
                        TextInput::make('ui_labels.about.story.title')->label('Story — titre')->columnSpanFull(),
                        RichEditor::make('ui_labels.about.story.content')
                            ->label('Story — contenu (HTML riche)')
                            ->toolbarButtons(['bold', 'italic', 'h2', 'h3', 'bulletList', 'orderedList', 'link'])
                            ->columnSpanFull(),
                        TextInput::make('ui_labels.about.method.title')->label('Méthode — titre'),
                        Textarea::make('ui_labels.about.method.subtitle')->label('Méthode — sous-titre')->rows(2)->columnSpanFull(),
                        TextInput::make('ui_labels.about.cta.title')->label('CTA — titre'),
                        Textarea::make('ui_labels.about.cta.subtitle')->label('CTA — sous-titre')->rows(2)->columnSpanFull(),
                        TextInput::make('ui_labels.about.cta.button')->label('CTA — bouton'),
                    ]),

                // ─── PAGE POSITIONNEMENT ───────────────────────
                Section::make('Page Positionnement / Indépendance')
                    ->collapsible()
                    ->collapsed()
                    ->columns(2)
                    ->schema([
                        TextInput::make('ui_labels.positionnement.problem.eyebrow')->label('Problème — eyebrow'),
                        TextInput::make('ui_labels.positionnement.problem.title')->label('Problème — titre')->columnSpanFull(),
                        TextInput::make('ui_labels.positionnement.verify.eyebrow')->label('Vérification — eyebrow'),
                        TextInput::make('ui_labels.positionnement.verify.title')->label('Vérification — titre')->columnSpanFull(),
                        TextInput::make('ui_labels.positionnement.model.eyebrow')->label('Modèle — eyebrow'),
                        TextInput::make('ui_labels.positionnement.model.title')->label('Modèle — titre'),
                        Textarea::make('ui_labels.positionnement.model.subtitle')->label('Modèle — sous-titre')->rows(2)->columnSpanFull(),
                        Textarea::make('ui_labels.positionnement.model.footer')->label('Modèle — footer (HTML)')->rows(2)->columnSpanFull(),
                        TextInput::make('ui_labels.positionnement.cta.title')->label('CTA — titre'),
                        Textarea::make('ui_labels.positionnement.cta.subtitle')->label('CTA — sous-titre')->rows(2)->columnSpanFull(),
                    ]),

                // ─── PAGE AUDIT — HERO & ÉTAPES ────────────────
                Section::make('Page Audit — Hero & étapes')
                    ->description('Labels du wizard de pré-diagnostic GTB (/audit).')
                    ->collapsible()
                    ->collapsed()
                    ->columns(2)
                    ->schema([
                        TextInput::make('ui_labels.audit.breadcrumb')->label('Fil d\'Ariane'),
                        TextInput::make('ui_labels.audit.hero.eyebrow')->label('Hero — eyebrow'),
                        Textarea::make('ui_labels.audit.hero.title')->label('Hero — titre (HTML)')->rows(2)->columnSpanFull(),
                        Textarea::make('ui_labels.audit.hero.subtitle')->label('Hero — sous-titre')->rows(3)->columnSpanFull(),
                        TextInput::make('ui_labels.audit.hero.badge1')->label('Hero — badge 1'),
                        TextInput::make('ui_labels.audit.hero.badge2')->label('Hero — badge 2'),
                        TextInput::make('ui_labels.audit.trust_badge')->label('Badge de confiance')->columnSpanFull(),
                        TextInput::make('ui_labels.audit.step1_title')->label('Étape 1 — titre'),
                        Textarea::make('ui_labels.audit.step1_subtitle')->label('Étape 1 — sous-titre')->rows(2)->columnSpanFull(),
                        TextInput::make('ui_labels.audit.age_before1975')->label('Âge — avant 1975'),
                        TextInput::make('ui_labels.audit.age_1975_2000')->label('Âge — 1975/2000'),
                        TextInput::make('ui_labels.audit.age_2000_2012')->label('Âge — 2000/2012'),
                        TextInput::make('ui_labels.audit.age_after2012')->label('Âge — après 2012'),
                        TextInput::make('ui_labels.audit.step2_title')->label('Étape 2 — titre'),
                        Textarea::make('ui_labels.audit.step2_subtitle')->label('Étape 2 — sous-titre')->rows(2)->columnSpanFull(),
                        TextInput::make('ui_labels.audit.see_results')->label('Bouton "voir mes résultats"'),
                    ]),

                // ─── PAGE AUDIT — LOTS TECHNIQUES ──────────────
                Section::make('Page Audit — Lots techniques')
                    ->collapsible()
                    ->collapsed()
                    ->columns(2)
                    ->schema([
                        TextInput::make('ui_labels.audit.lot_heating')->label('Chauffage'),
                        Textarea::make('ui_labels.audit.lot_heating_desc')->label('Chauffage — desc')->rows(2)->columnSpanFull(),
                        TextInput::make('ui_labels.audit.heated_surface')->label('Surface chauffée'),
                        TextInput::make('ui_labels.audit.lot_ecs')->label('ECS'),
                        Textarea::make('ui_labels.audit.lot_ecs_desc')->label('ECS — desc')->rows(2)->columnSpanFull(),
                        TextInput::make('ui_labels.audit.has_ecs_question')->label('ECS — question'),
                        TextInput::make('ui_labels.audit.ecs_surface')->label('ECS — surface'),
                        TextInput::make('ui_labels.audit.lot_cooling')->label('Climatisation'),
                        Textarea::make('ui_labels.audit.lot_cooling_desc')->label('Climatisation — desc')->rows(2)->columnSpanFull(),
                        TextInput::make('ui_labels.audit.has_cooling_question')->label('Climatisation — question'),
                        TextInput::make('ui_labels.audit.cooled_surface')->label('Surface climatisée'),
                        TextInput::make('ui_labels.audit.lot_lighting')->label('Éclairage'),
                        Textarea::make('ui_labels.audit.lot_lighting_desc')->label('Éclairage — desc')->rows(2)->columnSpanFull(),
                        TextInput::make('ui_labels.audit.has_lighting_question')->label('Éclairage — question'),
                        TextInput::make('ui_labels.audit.lit_surface')->label('Surface éclairée'),
                        TextInput::make('ui_labels.audit.lighting_type')->label('Type de gestion'),
                        TextInput::make('ui_labels.audit.lighting_manual')->label('Manuel'),
                        TextInput::make('ui_labels.audit.lighting_timer')->label('Minuteries'),
                        TextInput::make('ui_labels.audit.lighting_presence')->label('Détection présence'),
                        TextInput::make('ui_labels.audit.lighting_smart')->label('Gestion intelligente'),
                        TextInput::make('ui_labels.audit.lot_auxiliary')->label('Auxiliaires'),
                        Textarea::make('ui_labels.audit.lot_auxiliary_desc')->label('Auxiliaires — desc')->rows(2)->columnSpanFull(),
                        TextInput::make('ui_labels.audit.has_auxiliary_question')->label('Auxiliaires — question'),
                        TextInput::make('ui_labels.audit.auxiliary_surface')->label('Surface auxiliaires'),
                    ]),

                // ─── PAGE AUDIT — RÉSULTATS ────────────────────
                Section::make('Page Audit — Résultats')
                    ->collapsible()
                    ->collapsed()
                    ->columns(2)
                    ->schema([
                        TextInput::make('ui_labels.audit.results.score_label')->label('Score — label'),
                        TextInput::make('ui_labels.audit.results.savings_label')->label('Économies — label'),
                        TextInput::make('ui_labels.audit.results.cee_title')->label('CEE — titre'),
                        TextInput::make('ui_labels.audit.results.cee_cta')->label('CEE — CTA'),
                        TextInput::make('ui_labels.audit.results.iso_class')->label('Classe ISO'),
                        TextInput::make('ui_labels.audit.results.days_left')->label('Jours restants'),
                        TextInput::make('ui_labels.audit.results.benchmark_title')->label('Benchmark — titre'),
                        Textarea::make('ui_labels.audit.results.benchmark_subtitle')->label('Benchmark — sous-titre')->rows(2)->columnSpanFull(),
                        TextInput::make('ui_labels.audit.results.benchmark_good')->label('Performant'),
                        TextInput::make('ui_labels.audit.results.benchmark_avg')->label('Moyen'),
                        TextInput::make('ui_labels.audit.results.benchmark_bad')->label('Énergivore'),
                        TextInput::make('ui_labels.audit.results.your_building')->label('Votre bâtiment'),
                        Textarea::make('ui_labels.audit.results.benchmark_sources')->label('Sources benchmark')->rows(2)->columnSpanFull(),
                        TextInput::make('ui_labels.audit.results.energy_title')->label('Conso — titre'),
                        TextInput::make('ui_labels.audit.results.total')->label('Total'),
                        TextInput::make('ui_labels.audit.results.reco_title')->label('Recommandations — titre'),
                    ]),

                // ─── PAGE AUDIT — PREMIUM & MODAL ──────────────
                Section::make('Page Audit — Premium & modal PDF')
                    ->collapsible()
                    ->collapsed()
                    ->columns(2)
                    ->schema([
                        TextInput::make('ui_labels.audit.premium.badge')->label('Badge'),
                        TextInput::make('ui_labels.audit.premium.title')->label('Titre')->columnSpanFull(),
                        Textarea::make('ui_labels.audit.premium.desc')->label('Description')->rows(3)->columnSpanFull(),
                        TextInput::make('ui_labels.audit.premium.online_title')->label('En ligne — titre'),
                        TextInput::make('ui_labels.audit.premium.online_subtitle')->label('En ligne — sous-titre'),
                        TextInput::make('ui_labels.audit.premium.online_1')->label('En ligne — point 1'),
                        TextInput::make('ui_labels.audit.premium.online_2')->label('En ligne — point 2'),
                        TextInput::make('ui_labels.audit.premium.online_3')->label('En ligne — point 3'),
                        TextInput::make('ui_labels.audit.premium.online_4')->label('En ligne — point 4'),
                        TextInput::make('ui_labels.audit.premium.online_price')->label('En ligne — prix'),
                        TextInput::make('ui_labels.audit.premium.onsite_title')->label('Sur site — titre'),
                        TextInput::make('ui_labels.audit.premium.onsite_subtitle')->label('Sur site — sous-titre'),
                        TextInput::make('ui_labels.audit.premium.onsite_1')->label('Sur site — point 1'),
                        TextInput::make('ui_labels.audit.premium.onsite_2')->label('Sur site — point 2'),
                        TextInput::make('ui_labels.audit.premium.onsite_3')->label('Sur site — point 3'),
                        TextInput::make('ui_labels.audit.premium.onsite_4')->label('Sur site — point 4'),
                        TextInput::make('ui_labels.audit.premium.onsite_5')->label('Sur site — point 5'),
                        TextInput::make('ui_labels.audit.premium.onsite_6')->label('Sur site — point 6'),
                        TextInput::make('ui_labels.audit.premium.onsite_cta')->label('Sur site — CTA'),
                        TextInput::make('ui_labels.audit.disclaimer.title')->label('Disclaimer — titre'),
                        Textarea::make('ui_labels.audit.disclaimer.text')->label('Disclaimer — texte')->rows(3)->columnSpanFull(),
                        TextInput::make('ui_labels.audit.actions.download_pdf')->label('Action — téléchargement PDF'),
                        TextInput::make('ui_labels.audit.actions.contact_expert')->label('Action — contacter expert'),
                        TextInput::make('ui_labels.audit.actions.compare')->label('Action — comparer'),
                        TextInput::make('ui_labels.audit.actions.estimate_cee')->label('Action — estimer CEE'),
                        TextInput::make('ui_labels.audit.actions.new_diag')->label('Action — nouveau diagnostic'),
                        TextInput::make('ui_labels.audit.modal.title')->label('Modal — titre'),
                        Textarea::make('ui_labels.audit.modal.subtitle')->label('Modal — sous-titre')->rows(2)->columnSpanFull(),
                        TextInput::make('ui_labels.audit.modal.email_placeholder')->label('Modal — email placeholder'),
                        TextInput::make('ui_labels.audit.modal.name_placeholder')->label('Modal — nom placeholder'),
                        TextInput::make('ui_labels.audit.modal.company_placeholder')->label('Modal — société placeholder'),
                        Textarea::make('ui_labels.audit.modal.consent_text')->label('Modal — texte consentement')->rows(3)->columnSpanFull(),
                        Textarea::make('ui_labels.audit.modal.consent_error')->label('Modal — erreur consentement')->rows(2)->columnSpanFull(),
                        TextInput::make('ui_labels.audit.modal.rgpd_title')->label('Modal — RGPD titre'),
                        Textarea::make('ui_labels.audit.modal.rgpd_text')->label('Modal — RGPD texte (HTML)')->rows(4)->columnSpanFull(),
                        TextInput::make('ui_labels.audit.modal.download_btn')->label('Modal — bouton télécharger'),
                        TextInput::make('ui_labels.audit.modal.success')->label('Modal — succès'),
                        TextInput::make('ui_labels.audit.related.title')->label('Pages associées — titre'),
                        TextInput::make('ui_labels.audit.related.comparateur')->label('Lien comparateur'),
                        Textarea::make('ui_labels.audit.related.comparateur_desc')->label('Comparateur — desc')->rows(2)->columnSpanFull(),
                        TextInput::make('ui_labels.audit.related.cee')->label('Lien CEE'),
                        Textarea::make('ui_labels.audit.related.cee_desc')->label('CEE — desc')->rows(2)->columnSpanFull(),
                        TextInput::make('ui_labels.audit.related.reglementation')->label('Lien réglementation'),
                        Textarea::make('ui_labels.audit.related.reglementation_desc')->label('Réglementation — desc')->rows(2)->columnSpanFull(),
                    ]),

                // ─── NEWSLETTER CONFIRMÉE ──────────────────────
                Section::make('Newsletter — page confirmée')
                    ->collapsible()
                    ->collapsed()
                    ->columns(2)
                    ->schema([
                        TextInput::make('ui_labels.newsletter.confirmed.title')->label('Titre'),
                        Textarea::make('ui_labels.newsletter.confirmed.text')->label('Texte')->rows(3)->columnSpanFull(),
                        TextInput::make('ui_labels.newsletter.confirmed.cta')->label('CTA'),
                    ]),

                // ─── PAGES LÉGALES (hero) ──────────────────────
                Section::make('Pages légales — hero')
                    ->description('Eyebrow et titre des pages légales (le contenu est dans « Mentions & RGPD »).')
                    ->collapsible()
                    ->collapsed()
                    ->columns(2)
                    ->schema([
                        TextInput::make('ui_labels.legal.mentions_legales.eyebrow')->label('Mentions légales — eyebrow'),
                        TextInput::make('ui_labels.legal.mentions_legales.title')->label('Mentions légales — titre'),
                        TextInput::make('ui_labels.legal.cookies.eyebrow')->label('Cookies — eyebrow'),
                        TextInput::make('ui_labels.legal.cookies.title')->label('Cookies — titre'),
                        TextInput::make('ui_labels.legal.politique_confidentialite.eyebrow')->label('Politique — eyebrow'),
                        TextInput::make('ui_labels.legal.politique_confidentialite.title')->label('Politique — titre'),
                        TextInput::make('ui_labels.legal.rgpd.eyebrow')->label('RGPD — eyebrow'),
                        TextInput::make('ui_labels.legal.rgpd.title')->label('RGPD — titre'),
                        Textarea::make('ui_labels.legal.rgpd.subtitle')->label('RGPD — sous-titre')->rows(2)->columnSpanFull(),
                        TextInput::make('ui_labels.legal.rgpd.security_title')->label('RGPD — sécurité titre'),
                        Textarea::make('ui_labels.legal.rgpd.security_text')->label('RGPD — sécurité texte')->rows(3)->columnSpanFull(),
                        TextInput::make('ui_labels.legal.rgpd.success_title')->label('RGPD — succès titre'),
                        Textarea::make('ui_labels.legal.rgpd.success_text')->label('RGPD — succès texte')->rows(3)->columnSpanFull(),
                        TextInput::make('ui_labels.legal.rgpd.back_link')->label('RGPD — lien retour'),
                    ]),
            ]);
    }

    // ─── TAB: TEXTES LÉGAUX ────────────────────────────────

    protected function legalTab(): Tab
    {
        return Tab::make('Mentions & RGPD')
            ->id('mentions-rgpd')
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

                Section::make('Politique cookies')
                    ->description('Page /cookies — Détail des cookies utilisés sur le site.')
                    ->schema([
                        RichEditor::make('legal_texts.cookies')
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
                    ->description('Liste des protocoles de communication GTB affichés sur la page Solutions.')
                    ->schema([
                        Repeater::make('gtb_protocols_config')
                            ->label('')
                            ->schema([
                                Grid::make(2)->schema([
                                    TextInput::make('slug')->required()->placeholder('bacnet'),
                                    TextInput::make('label')->required()->placeholder('BACnet'),
                                ]),
                                Grid::make(3)->schema([
                                    TextInput::make('standard')->placeholder('ISO 16484-5'),
                                    Select::make('category')
                                        ->options([
                                            'terrain' => 'Terrain (bus)',
                                            'IP'      => 'IP (Ethernet)',
                                            'sans-fil' => 'Sans-fil',
                                        ])
                                        ->native(false),
                                    TextInput::make('icon')->placeholder('🌐 ou heroicon-o-globe-alt'),
                                ]),
                                Textarea::make('description')
                                    ->rows(4)
                                    ->helperText('HTML autorisé (balises <strong>, <em>)'),
                                KeyValue::make('tags')
                                    ->label('Tags (liste)')
                                    ->helperText('Clé = position (1, 2, 3), Valeur = tag affiché')
                                    ->keyLabel('#')
                                    ->valueLabel('Tag'),
                            ])
                            ->collapsible()
                            ->cloneable()
                            ->itemLabel(fn (array $state): ?string => $state['label'] ?? null)
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
