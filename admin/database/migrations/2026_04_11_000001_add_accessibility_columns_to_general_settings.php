<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('general_settings', function (Blueprint $table) {
            if (!Schema::hasColumn('general_settings', 'handicap_referent_name')) {
                $table->string('handicap_referent_name')->nullable()->after('rgpd_retention_newsletter_days');
            }
            if (!Schema::hasColumn('general_settings', 'handicap_referent_email')) {
                $table->string('handicap_referent_email')->nullable()->after('handicap_referent_name');
            }
            if (!Schema::hasColumn('general_settings', 'handicap_referent_phone')) {
                $table->string('handicap_referent_phone')->nullable()->after('handicap_referent_email');
            }
            if (!Schema::hasColumn('general_settings', 'accessibility_info')) {
                $table->text('accessibility_info')->nullable()->after('handicap_referent_phone');
            }
        });
    }

    public function down(): void
    {
        Schema::table('general_settings', function (Blueprint $table) {
            $columns = [
                'handicap_referent_name',
                'handicap_referent_email',
                'handicap_referent_phone',
                'accessibility_info',
            ];

            foreach ($columns as $col) {
                if (Schema::hasColumn('general_settings', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
