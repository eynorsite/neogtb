<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        $password = Str::random(16);

        $admin = Admin::firstOrCreate(
            ['email' => 'admin@neogtb.fr'],
            [
                'name' => 'Ulrich Calmo',
                'password' => Hash::make($password, ['rounds' => 12]),
                'role' => 'superadmin',
                'is_active' => true,
            ]
        );

        if ($admin->wasRecentlyCreated) {
            $this->command->newLine();
            $this->command->warn('╔══════════════════════════════════════════════╗');
            $this->command->warn('║  COMPTE SUPERADMIN CRÉÉ                     ║');
            $this->command->warn('╠══════════════════════════════════════════════╣');
            $this->command->warn('║  Email : admin@neogtb.fr                    ║');
            $this->command->warn('║  Mot de passe : ' . str_pad($password, 28) . '║');
            $this->command->warn('╠══════════════════════════════════════════════╣');
            $this->command->warn('║  ⚠ NOTEZ CE MOT DE PASSE MAINTENANT !      ║');
            $this->command->warn('║  Il ne sera plus affiché.                   ║');
            $this->command->warn('╚══════════════════════════════════════════════╝');
            $this->command->newLine();
        } else {
            $this->command->info('Le compte superadmin existe déjà.');
        }
    }
}
