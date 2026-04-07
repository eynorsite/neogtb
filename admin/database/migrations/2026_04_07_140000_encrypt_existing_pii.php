<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Migration RÉTROACTIVE de chiffrement des PII existantes.
 *
 * Contexte : avant l'audit sécurité, ContactMessage / AdminActivityLog / Admin / GdprRequest
 * stockaient certains champs PII en clair. Le code applicatif utilise désormais le cast
 * Eloquent 'encrypted' qui tente de DÉCHIFFRER en lecture.
 *
 * Sans cette migration, toutes les lignes historiques en clair lèveraient DecryptException
 * dès le premier affichage dans le back-office (= crash garanti).
 *
 * Cette migration :
 *  - lit chaque ligne en RAW SQL (sans cast Eloquent)
 *  - détecte si la valeur est déjà chiffrée (heuristique : décodable Crypt::decryptString)
 *  - si non → la chiffre avec Crypt::encryptString(APP_KEY courante)
 *  - écrit en RAW SQL
 *
 * IDEMPOTENTE : peut être relancée sans danger.
 * IRRÉVERSIBLE : down() est volontairement vide (on ne déchiffre jamais en BDD).
 */
return new class extends Migration
{
    /**
     * Tables et colonnes à chiffrer rétroactivement.
     */
    private array $targets = [
        'contact_messages' => ['name', 'email', 'phone', 'company', 'message', 'user_agent'],
        'admin_activity_logs' => ['ip_address', 'user_agent'],
        'admins' => ['last_login_ip'],
        'gdpr_requests' => ['response_content', 'admin_notes'],
    ];

    public function up(): void
    {
        foreach ($this->targets as $table => $columns) {
            if (!Schema::hasTable($table)) {
                continue;
            }

            $existingColumns = array_filter($columns, fn ($c) => Schema::hasColumn($table, $c));
            if (empty($existingColumns)) {
                continue;
            }

            DB::table($table)->orderBy('id')->chunkById(200, function ($rows) use ($table, $existingColumns) {
                foreach ($rows as $row) {
                    $update = [];
                    foreach ($existingColumns as $col) {
                        $value = $row->{$col} ?? null;

                        // Skip null/empty
                        if ($value === null || $value === '') {
                            continue;
                        }

                        // Skip si déjà chiffré (idempotence)
                        if ($this->isEncrypted($value)) {
                            continue;
                        }

                        $update[$col] = Crypt::encryptString((string) $value);
                    }

                    if (!empty($update)) {
                        DB::table($table)->where('id', $row->id)->update($update);
                    }
                }
            });
        }
    }

    public function down(): void
    {
        // Volontairement vide : on ne déchiffre jamais des données en clair en BDD.
        // Si rollback nécessaire, restaurer depuis un backup pré-migration.
    }

    /**
     * Heuristique : tente de déchiffrer. Si ça marche, c'est déjà chiffré.
     */
    private function isEncrypted(string $value): bool
    {
        try {
            Crypt::decryptString($value);
            return true;
        } catch (\Throwable $e) {
            return false;
        }
    }
};
