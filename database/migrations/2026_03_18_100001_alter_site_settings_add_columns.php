<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->boolean('is_public')->default(false)->after('description');
            $table->boolean('is_encrypted')->default(false)->after('is_public');
            $table->boolean('is_required')->default(false)->after('is_encrypted');

            $table->index(['group', 'key']);
        });
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropIndex(['group', 'key']);
            $table->dropColumn(['is_public', 'is_encrypted', 'is_required']);
        });
    }
};
