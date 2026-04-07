<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('audit_leads', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->string('name')->nullable();
            $table->string('company')->nullable();
            $table->unsignedInteger('score')->nullable();
            $table->string('level_label')->nullable();
            $table->string('building_type')->nullable();
            $table->unsignedInteger('surface')->nullable();
            $table->unsignedInteger('savings_euro')->nullable();
            $table->json('payload')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->string('status')->default('new');
            $table->timestamps();
            $table->index('status');
            $table->index('created_at');
        });

        Schema::create('cee_leads', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->decimal('th116_mwh', 12, 2)->nullable();
            $table->decimal('th116_value', 12, 2)->nullable();
            $table->string('sector')->nullable();
            $table->unsignedInteger('surface')->nullable();
            $table->string('climate_zone')->nullable();
            $table->json('payload')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->string('status')->default('new');
            $table->timestamps();
            $table->index('status');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cee_leads');
        Schema::dropIfExists('audit_leads');
    }
};
