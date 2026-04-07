<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('newsletter_subscribers', function (Blueprint $table) {
            $table->id();
            $table->text('email'); // encrypted
            $table->string('confirmation_token', 64)->nullable()->unique();
            $table->boolean('is_confirmed')->default(false);
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('unsubscribed_at')->nullable();
            $table->string('ip_hash', 64)->nullable();
            $table->timestamps();
            $table->index('is_confirmed');
            $table->index('confirmed_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('newsletter_subscribers');
    }
};
