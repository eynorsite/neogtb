<?php

namespace App\Filament\Pages;

use App\Models\ChatbotSetting;
use App\Services\ChatbotService;
use Filament\Actions\Action;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class ChatbotSettingsPage extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static string|\UnitEnum|null $navigationGroup = 'Chatbot';

    protected static ?string $navigationLabel = 'Configuration';

    protected static ?string $title = 'Configuration du chatbot';

    protected static ?int $navigationSort = 10;

    protected string $view = 'filament.pages.chatbot-settings';

    public ?array $data = [];

    public ?string $testMessage = null;

    public ?array $testResult = null;

    public static function canAccess(): bool
    {
        $admin = auth()->guard('admin')->user();

        return $admin && in_array($admin->role, ['superadmin', 'admin']);
    }

    public function mount(): void
    {
        $settings = ChatbotSetting::current()->fresh();
        $this->form->fill($settings->toArray());
    }

    public function form(Schema $form): Schema
    {
        return $form->schema([
            Tabs::make('chatbot_settings')
                ->persistTabInQueryString()
                ->tabs([
                    Tab::make('Général')
                        ->icon('heroicon-o-cog-6-tooth')
                        ->schema([
                            Section::make('Activation')
                                ->schema([
                                    Toggle::make('enabled')
                                        ->label('Activer le chatbot sur le site public')
                                        ->helperText('Désactive instantanément l\'affichage du widget pour tous les visiteurs.'),
                                ]),

                            Section::make('Modèle Claude & coût')
                                ->schema([
                                    Select::make('model')
                                        ->label('Modèle')
                                        ->options([
                                            'claude-haiku-4-5' => 'Haiku 4.5 (rapide, ~0,001€/réponse)',
                                            'claude-sonnet-4-6' => 'Sonnet 4.6 (qualité, ~0,005€/réponse)',
                                        ])
                                        ->default('claude-haiku-4-5')
                                        ->required(),
                                    TextInput::make('max_tokens')
                                        ->label('Tokens max par réponse')
                                        ->numeric()
                                        ->default(800)
                                        ->minValue(100)
                                        ->maxValue(4000),
                                    TextInput::make('temperature')
                                        ->label('Température (0 = factuel, 1 = créatif)')
                                        ->numeric()
                                        ->default(0.3)
                                        ->minValue(0)
                                        ->maxValue(1),
                                    TextInput::make('monthly_budget_eur')
                                        ->label('Budget mensuel (€)')
                                        ->numeric()
                                        ->default(30)
                                        ->helperText('Au-delà, le bot retourne un message d\'indisponibilité.'),
                                    TextInput::make('current_month_cost_eur')
                                        ->label('Coût cumulé du mois (€)')
                                        ->numeric()
                                        ->disabled()
                                        ->dehydrated(false),
                                ])->columns(2),

                            Section::make('Limites anti-abus')
                                ->schema([
                                    TextInput::make('rate_limit_per_ip_per_day')
                                        ->label('Messages max / IP / jour')
                                        ->numeric()
                                        ->default(30),
                                    TextInput::make('rate_limit_per_session')
                                        ->label('Messages max / session')
                                        ->numeric()
                                        ->default(20),
                                ])->columns(2),
                        ]),

                    Tab::make('Apparence')
                        ->icon('heroicon-o-paint-brush')
                        ->schema([
                            Section::make('Widget')
                                ->schema([
                                    Select::make('widget_position')
                                        ->label('Position')
                                        ->options([
                                            'bottom-right' => 'Bas droite',
                                            'bottom-left' => 'Bas gauche',
                                        ])
                                        ->default('bottom-right'),
                                    ColorPicker::make('widget_color')
                                        ->label('Couleur principale')
                                        ->default('#0E7490'),
                                    TextInput::make('widget_title')
                                        ->label('Titre du widget')
                                        ->default('Assistant NeoGTB')
                                        ->maxLength(40),
                                    TextInput::make('widget_subtitle')
                                        ->label('Sous-titre')
                                        ->maxLength(60),
                                ])->columns(2),

                            Section::make('Message d\'accueil et suggestions')
                                ->schema([
                                    Textarea::make('welcome_message')
                                        ->label('Message d\'accueil')
                                        ->rows(3)
                                        ->maxLength(500),
                                    TagsInput::make('suggested_questions')
                                        ->label('Questions suggérées (boutons rapides)')
                                        ->placeholder('Ajouter une question…')
                                        ->helperText('3 à 5 questions affichées dès l\'ouverture du widget.'),
                                ]),
                        ]),

                    Tab::make('Persona & prompt')
                        ->icon('heroicon-o-sparkles')
                        ->schema([
                            Section::make('Ton et comportement')
                                ->schema([
                                    Select::make('persona_tone')
                                        ->label('Ton du bot')
                                        ->options([
                                            'vouvoiement_chaleureux' => 'Vouvoiement chaleureux (recommandé)',
                                            'tutoiement' => 'Tutoiement décontracté',
                                            'formel' => 'Formel / institutionnel',
                                        ])
                                        ->default('vouvoiement_chaleureux'),
                                ]),

                            Section::make('Prompt système (avancé)')
                                ->description('Laisser vide pour utiliser le prompt par défaut généré automatiquement à partir des règles NeoGTB. Le contenu de la base de connaissances et des FAQ y sera ajouté automatiquement.')
                                ->schema([
                                    Textarea::make('system_prompt')
                                        ->label('Prompt système custom')
                                        ->rows(15)
                                        ->placeholder('Laisser vide pour le prompt par défaut'),
                                ]),
                        ]),

                    Tab::make('Fallback & leads')
                        ->icon('heroicon-o-flag')
                        ->schema([
                            Section::make('Quand le bot ne sait pas')
                                ->schema([
                                    Select::make('fallback_action')
                                        ->label('Action de fallback')
                                        ->options([
                                            'contact_form' => 'Rediriger vers /contact',
                                            'audit_form' => 'Rediriger vers /audit',
                                            'custom_url' => 'URL personnalisée',
                                        ])
                                        ->default('contact_form'),
                                    TextInput::make('fallback_url')
                                        ->label('URL de redirection')
                                        ->default('/contact'),
                                    Textarea::make('fallback_message')
                                        ->label('Message de fallback')
                                        ->rows(2),
                                ])->columns(2),

                            Section::make('Détection de leads commerciaux')
                                ->schema([
                                    Toggle::make('lead_webhook_enabled')
                                        ->label('Notifier par email quand un lead est détecté'),
                                    TextInput::make('lead_webhook_email')
                                        ->label('Email destinataire')
                                        ->email()
                                        ->placeholder('hello@neogtb.fr'),
                                    TagsInput::make('lead_keywords')
                                        ->label('Mots-clés déclencheurs')
                                        ->placeholder('ex: devis, audit, rappel…')
                                        ->helperText('Si un message du visiteur contient un de ces mots, la conversation est marquée comme lead.'),
                                ]),
                        ]),

                    Tab::make('RGPD')
                        ->icon('heroicon-o-shield-check')
                        ->schema([
                            Section::make('Consentement et conservation')
                                ->schema([
                                    Toggle::make('require_consent')
                                        ->label('Demander un consentement explicite avant le 1er message')
                                        ->default(true),
                                    Textarea::make('consent_text')
                                        ->label('Texte de consentement')
                                        ->rows(4),
                                    TextInput::make('retention_days')
                                        ->label('Durée de conservation (jours)')
                                        ->numeric()
                                        ->default(30)
                                        ->helperText('Les conversations sont supprimées automatiquement au-delà.'),
                                ]),
                        ]),
                ])
                ->columnSpanFull(),
        ])->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();
        unset($data['current_month_cost_eur']);
        ChatbotSetting::current()->update($data);

        Notification::make()
            ->title('Configuration enregistrée')
            ->success()
            ->send();
    }

    public function runTest(): void
    {
        if (empty($this->testMessage)) {
            $this->testResult = ['error' => 'Saisis une question pour tester.'];

            return;
        }

        $this->save();
        $this->testResult = app(ChatbotService::class)->testReply($this->testMessage);
    }

    public function resetMonthlyCost(): void
    {
        $admin = auth()->guard('admin')->user();
        if (! $admin || $admin->role !== 'superadmin') {
            return;
        }

        ChatbotSetting::current()->update([
            'current_month_cost_eur' => 0,
            'budget_reset_at' => now(),
        ]);

        Notification::make()
            ->title('Compteur de coût remis à zéro')
            ->success()
            ->send();

        $this->mount();
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('save')
                ->label('Enregistrer')
                ->icon('heroicon-o-check')
                ->action('save'),
            Action::make('reset_cost')
                ->label('Réinitialiser le compteur de coût')
                ->icon('heroicon-o-arrow-path')
                ->color('warning')
                ->visible(fn () => auth()->guard('admin')->user()?->role === 'superadmin')
                ->requiresConfirmation()
                ->action('resetMonthlyCost'),
        ];
    }
}
