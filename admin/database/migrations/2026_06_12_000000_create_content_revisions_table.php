<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('content_revisions', function (Blueprint $table) {
            $table->id();
            // Regroupe toutes les révisions créées par un même clic « Enregistrer »
            // (un save peut toucher plusieurs pages) → permet de tout annuler d'un coup.
            $table->uuid('batch_id')->index();
            // Slug de la page concernée (aligné sur page_contents.page).
            $table->string('page', 50)->index();
            // Instantané complet de la page AVANT écrasement : map { page_content.id => value }.
            // Les valeurs nulles sont préservées telles quelles (page_contents.value est nullable).
            $table->json('snapshot');
            // Admin auteur de la sauvegarde (nullable : un save hors contexte d'auth ne doit pas échouer).
            $table->foreignId('created_by')->nullable()->constrained('admins')->nullOnDelete();
            // Table en append-only : created_at seul, pas d'updated_at.
            $table->timestamp('created_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('content_revisions');
    }
};
