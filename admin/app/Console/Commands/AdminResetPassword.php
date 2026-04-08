<?php

namespace App\Console\Commands;

use App\Models\Admin;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

/**
 * Reset (or set) the password of a back-office Admin from the CLI.
 *
 * Useful when:
 *  - the SMTP outbound mailer is broken so the "forgot password" web flow fails
 *  - the operator has SSH access but no working email
 *  - bootstrapping a fresh server (initial superadmin login)
 *
 * Examples:
 *   php artisan admin:reset-password admin@neogtb.fr
 *   php artisan admin:reset-password admin@neogtb.fr --password='myStr0ngP@ss!'
 *   php artisan admin:reset-password admin@neogtb.fr --random
 */
class AdminResetPassword extends Command
{
    protected $signature = 'admin:reset-password
        {email : Email of the admin account to reset}
        {--password= : New plain-text password (will be hashed). Prompted interactively if missing.}
        {--random : Generate a random 16-char password instead of asking}
        {--activate : Also force is_active=true on the account}';

    protected $description = 'Reset (or set) the password of a back-office admin';

    public function handle(): int
    {
        $email = $this->argument('email');

        $admin = Admin::where('email', $email)->first();
        if (! $admin) {
            $this->error("Aucun admin trouvé avec l'email : {$email}");
            $this->line('');
            $this->line('Admins existants :');
            Admin::query()->orderBy('id')->get(['id', 'email', 'role', 'is_active'])
                ->each(fn ($a) => $this->line("  #{$a->id}  {$a->email}  ({$a->role}, ".($a->is_active ? 'active' : 'inactive').')'));
            return self::FAILURE;
        }

        if ($this->option('random')) {
            $password = Str::random(16);
            $generated = true;
        } elseif ($this->option('password')) {
            $password = (string) $this->option('password');
            $generated = false;
        } else {
            $password = $this->secret('Nouveau mot de passe (min. 12 caractères)');
            $confirm  = $this->secret('Confirmer le mot de passe');
            if ($password !== $confirm) {
                $this->error('Les mots de passe ne correspondent pas.');
                return self::FAILURE;
            }
            $generated = false;
        }

        try {
            validator(
                ['password' => $password],
                ['password' => ['required', Password::min(12)->letters()->mixedCase()->numbers()]],
            )->validate();
        } catch (ValidationException $e) {
            foreach ($e->errors() as $field => $messages) {
                foreach ($messages as $msg) {
                    $this->error($msg);
                }
            }
            return self::FAILURE;
        }

        $admin->forceFill([
            'password' => Hash::make($password),
        ]);

        if ($this->option('activate')) {
            $admin->is_active = true;
        }

        $admin->save();

        $this->newLine();
        $this->info("✅ Mot de passe mis à jour pour {$admin->email} (rôle : {$admin->role}).");

        if ($generated) {
            $this->newLine();
            $this->warn('╔══════════════════════════════════════════════════════════╗');
            $this->warn('║  NOUVEAU MOT DE PASSE — NOTEZ-LE MAINTENANT             ║');
            $this->warn('╠══════════════════════════════════════════════════════════╣');
            $this->warn('║  '.str_pad($password, 56).'║');
            $this->warn('╚══════════════════════════════════════════════════════════╝');
            $this->newLine();
        }

        return self::SUCCESS;
    }
}
