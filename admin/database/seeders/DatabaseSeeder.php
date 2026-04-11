<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            SuperAdminSeeder::class,
            GeneralSettingsSeeder::class,
            SitePagesSeeder::class,
            NavigationSeeder::class,
            BlogSeeder::class,
        ]);
    }
}
