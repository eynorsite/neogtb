<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        // Anciennement : seeding de SiteSettingsSeeder (table key-value supprimée).
        // Les settings sont désormais gérés via GeneralSetting (table monolithique).
    }

    public function down(): void
    {
        // No-op : la table site_settings key-value a été supprimée au profit de general_settings.
    }
};
