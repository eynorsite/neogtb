<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gdpr_requests', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['access', 'deletion', 'portability', 'rectification', 'opposition']);
            $table->text('email'); // chiffré via le modèle
            $table->text('name'); // chiffré via le modèle
            $table->text('message')->nullable(); // chiffré via le modèle
            $table->enum('status', ['pending', 'processing', 'completed', 'rejected'])->default('pending');
            $table->foreignId('processed_by')->nullable()->constrained('admins')->nullOnDelete();
            $table->timestamp('processed_at')->nullable();
            $table->text('response_content')->nullable();
            $table->timestamp('response_sent_at')->nullable();
            $table->text('admin_notes')->nullable();
            $table->timestamps();

            $table->index('status');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gdpr_requests');
    }
};
