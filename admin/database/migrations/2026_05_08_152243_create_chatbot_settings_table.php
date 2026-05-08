<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chatbot_settings', function (Blueprint $table) {
            $table->id();

            $table->boolean('enabled')->default(false);
            $table->string('model')->default('claude-haiku-4-5');
            $table->unsignedInteger('max_tokens')->default(800);
            $table->float('temperature')->default(0.3);

            $table->string('widget_position')->default('bottom-right');
            $table->string('widget_color')->default('#0E7490');
            $table->string('widget_title')->default('Assistant NeoGTB');
            $table->string('widget_subtitle')->nullable();
            $table->text('welcome_message')->nullable();
            $table->json('suggested_questions')->nullable();

            $table->string('persona_tone')->default('vouvoiement_chaleureux');
            $table->longText('system_prompt')->nullable();

            $table->unsignedInteger('rate_limit_per_ip_per_day')->default(30);
            $table->unsignedInteger('rate_limit_per_session')->default(20);
            $table->float('monthly_budget_eur')->default(30);
            $table->float('current_month_cost_eur')->default(0);
            $table->date('budget_reset_at')->nullable();

            $table->boolean('require_consent')->default(true);
            $table->text('consent_text')->nullable();
            $table->unsignedInteger('retention_days')->default(30);

            $table->string('fallback_action')->default('contact_form');
            $table->string('fallback_url')->nullable();
            $table->text('fallback_message')->nullable();

            $table->boolean('lead_webhook_enabled')->default(false);
            $table->string('lead_webhook_email')->nullable();
            $table->json('lead_keywords')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chatbot_settings');
    }
};
