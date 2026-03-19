<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('privacy_policy_versions', function (Blueprint $table) {
            $table->id();
            $table->string('version', 10);
            $table->longText('content');
            $table->timestamp('published_at')->nullable();
            $table->boolean('is_current')->default(false);
            $table->foreignId('created_by')->constrained('admins');
            $table->timestamps();

            $table->index('is_current');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('privacy_policy_versions');
    }
};
