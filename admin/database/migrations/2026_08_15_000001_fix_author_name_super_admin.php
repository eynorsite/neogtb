<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * En production, le schema.org Article des 20 articles publiés déclarait
 * « author.name = Super Admin », et la même valeur s'affichait sous chaque titre.
 *
 * La migration 2026_04_12_134536 visait déjà ce renommage, mais elle filtrait sur
 * email = 'admin@neogtb.fr' : le compte de prod portant une autre adresse, elle n'a
 * jamais rien modifié là où c'était nécessaire.
 *
 * On cible ici le compte par son NOM (et non par son email), en se limitant aux
 * comptes réellement auteurs d'articles publiés : un pseudo d'administration ne doit
 * pas se retrouver en signature publique, ni dans les signaux d'expertise lus par
 * Google et les moteurs de réponse.
 */
return new class extends Migration
{
    private const PLACEHOLDER = 'Super Admin';

    private const REAL_NAME = 'Ulrich Calmo';

    public function up(): void
    {
        $authorIds = DB::table('posts')->whereNotNull('author_id')->distinct()->pluck('author_id');

        if ($authorIds->isEmpty()) {
            return;
        }

        DB::table('admins')
            ->whereIn('id', $authorIds)
            ->where('name', self::PLACEHOLDER)
            ->update(['name' => self::REAL_NAME]);
    }

    public function down(): void
    {
        // Pas de restauration : réintroduire « Super Admin » comme signature publique
        // recréerait volontairement le défaut. Le rollback est donc un no-op assumé.
    }
};
