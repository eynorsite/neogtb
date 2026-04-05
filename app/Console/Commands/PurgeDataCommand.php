<?php

namespace App\Console\Commands;

use App\Models\ContactMessage;
use App\Models\CookieConsent;
use App\Models\GdprRequest;
use Illuminate\Console\Command;

class PurgeDataCommand extends Command
{
    protected $signature = 'purge:data';
    protected $description = 'Purge les données personnelles selon les durées de conservation RGPD';

    public function handle(): int
    {
        // Contacts > 3 ans
        $contacts = ContactMessage::where('created_at', '<', now()->subYears(3))->forceDelete();
        $this->info("Contacts purgés : {$contacts}");

        // Consentements cookies > 13 mois
        $consents = CookieConsent::where('created_at', '<', now()->subMonths(13))->delete();
        $this->info("Consentements cookies purgés : {$consents}");

        // Demandes RGPD traitées > 3 ans
        $gdpr = GdprRequest::where('status', 'completed')
            ->where('processed_at', '<', now()->subYears(3))
            ->forceDelete();
        $this->info("Demandes RGPD purgées : {$gdpr}");

        $this->info('Purge RGPD terminée.');

        return self::SUCCESS;
    }
}
