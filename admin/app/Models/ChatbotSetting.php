<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatbotSetting extends Model
{
    protected $table = 'chatbot_settings';

    protected $guarded = [];

    protected $casts = [
        'enabled' => 'boolean',
        'require_consent' => 'boolean',
        'lead_webhook_enabled' => 'boolean',
        'suggested_questions' => 'array',
        'lead_keywords' => 'array',
        'temperature' => 'float',
        'monthly_budget_eur' => 'float',
        'current_month_cost_eur' => 'float',
        'budget_reset_at' => 'date',
    ];

    public static function current(): self
    {
        return static::firstOrCreate(['id' => 1], [
            'enabled' => false,
            'model' => 'claude-haiku-4-5',
            'max_tokens' => 800,
            'temperature' => 0.3,
            'widget_position' => 'bottom-right',
            'widget_color' => '#0E7490',
            'widget_title' => 'Assistant NeoGTB',
            'widget_subtitle' => 'Conseil GTB & décret BACS',
            'welcome_message' => 'Bonjour, je suis l\'assistant NeoGTB. Je peux répondre à vos questions sur le décret BACS, la GTB, et nos services. En quoi puis-je vous aider ?',
            'suggested_questions' => [
                'Quelles sont les obligations du décret BACS pour mon bâtiment ?',
                'Quelle différence entre GTB et GTC ?',
                'Comment se déroule un audit NeoGTB ?',
            ],
            'persona_tone' => 'vouvoiement_chaleureux',
            'rate_limit_per_ip_per_day' => 30,
            'rate_limit_per_session' => 20,
            'monthly_budget_eur' => 30,
            'require_consent' => true,
            'consent_text' => 'En utilisant cet assistant, vous acceptez que vos messages soient traités pour vous répondre. Vos conversations sont conservées 30 jours puis supprimées.',
            'retention_days' => 30,
            'fallback_action' => 'contact_form',
            'fallback_url' => '/contact',
            'fallback_message' => 'Pour une réponse personnalisée, je vous invite à nous contacter via notre formulaire.',
            'lead_keywords' => ['devis', 'audit', 'rendez-vous', 'tarif', 'contact', 'rappel'],
        ]);
    }

    public function isWithinBudget(): bool
    {
        return $this->current_month_cost_eur < $this->monthly_budget_eur;
    }

    public function addCost(float $cost): void
    {
        $this->increment('current_month_cost_eur', $cost);
    }
}
