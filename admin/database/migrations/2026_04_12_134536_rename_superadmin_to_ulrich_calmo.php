<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('admins')
            ->where('email', 'admin@neogtb.fr')
            ->where('name', 'Super Admin')
            ->update(['name' => 'Ulrich Calmo']);
    }

    public function down(): void
    {
        DB::table('admins')
            ->where('email', 'admin@neogtb.fr')
            ->where('name', 'Ulrich Calmo')
            ->update(['name' => 'Super Admin']);
    }
};
