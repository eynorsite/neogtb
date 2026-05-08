<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chatbot_conversations', function (Blueprint $table) {
            $table->id();
            $table->string('session_id', 64)->unique();
            $table->string('ip_hash', 64)->nullable();
            $table->string('user_agent_hash', 64)->nullable();
            $table->string('referrer_url')->nullable();
            $table->string('landing_page')->nullable();
            $table->string('status')->default('active');
            $table->boolean('consent_given')->default(false);
            $table->timestamp('consent_given_at')->nullable();
            $table->boolean('is_lead')->default(false);
            $table->string('lead_email')->nullable();
            $table->string('lead_name')->nullable();
            $table->text('lead_note')->nullable();
            $table->timestamp('lead_captured_at')->nullable();
            $table->unsignedInteger('messages_count')->default(0);
            $table->unsignedBigInteger('total_tokens_in')->default(0);
            $table->unsignedBigInteger('total_tokens_out')->default(0);
            $table->float('total_cost_eur', 10, 6)->default(0);
            $table->timestamp('last_activity_at')->nullable();
            $table->timestamps();

            $table->index('status');
            $table->index('is_lead');
            $table->index('last_activity_at');
            $table->index('ip_hash');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chatbot_conversations');
    }
};
