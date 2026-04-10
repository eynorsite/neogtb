<?php

namespace App\Console\Commands;

use App\Models\ContactMessage;
use App\Models\AuditLead;
use App\Models\CeeLead;
use App\Models\CookieConsent;
use App\Models\NewsletterSubscriber;
use App\Models\GeneralSetting;
use Illuminate\Console\Command;

class PurgeExpiredDataCommand extends Command
{
    protected $signature = 'rgpd:purge-expired {--dry-run : Afficher ce qui serait purgé sans supprimer}';
    protected $description = 'Supprime/anonymise les données personnelles expirées selon la politique de rétention';

    public function handle(): int
    {
        $dryRun = $this->option('dry-run');

        if ($dryRun) {
            $this->warn('Mode dry-run : aucune donnée ne sera modifiée.');
        }

        $this->purgeContactMessages($dryRun);
        $this->purgeAuditLeads($dryRun);
        $this->purgeCeeLeads($dryRun);
        $this->purgeCookieConsents($dryRun);
        $this->purgeNewsletterInactive($dryRun);

        $this->info('Purge RGPD terminée.');
        return self::SUCCESS;
    }

    private function getRetentionDays(string $key, string $minKey): int
    {
        $setting = (int) GeneralSetting::value($key, 730);
        $minimum = config("neogtb.rgpd_min_retention.{$minKey}", 90);
        return max($setting, $minimum);
    }

    private function purgeContactMessages(bool $dryRun): void
    {
        $days = $this->getRetentionDays('rgpd_retention_contacts_days', 'contacts');
        $query = ContactMessage::where('created_at', '<', now()->subDays($days));

        $count = $query->count();
        $this->line("  ContactMessage : {$count} enregistrements de plus de {$days} jours.");

        if (!$dryRun && $count > 0) {
            // Soft delete les messages expirés (le modèle utilise SoftDeletes)
            $query->delete();
        }
    }

    private function purgeAuditLeads(bool $dryRun): void
    {
        $days = $this->getRetentionDays('rgpd_retention_leads_days', 'leads');
        $query = AuditLead::where('created_at', '<', now()->subDays($days));

        $count = $query->count();
        $this->line("  AuditLead : {$count} enregistrements de plus de {$days} jours.");

        if (!$dryRun && $count > 0) {
            $query->delete();
        }
    }

    private function purgeCeeLeads(bool $dryRun): void
    {
        $days = $this->getRetentionDays('rgpd_retention_leads_days', 'leads');
        $query = CeeLead::where('created_at', '<', now()->subDays($days));

        $count = $query->count();
        $this->line("  CeeLead : {$count} enregistrements de plus de {$days} jours.");

        if (!$dryRun && $count > 0) {
            $query->delete();
        }
    }

    private function purgeCookieConsents(bool $dryRun): void
    {
        $days = $this->getRetentionDays('rgpd_retention_cookies_days', 'cookies');
        $query = CookieConsent::where('created_at', '<', now()->subDays($days));

        $count = $query->count();
        $this->line("  CookieConsent : {$count} enregistrements de plus de {$days} jours.");

        if (!$dryRun && $count > 0) {
            $query->delete();
        }
    }

    private function purgeNewsletterInactive(bool $dryRun): void
    {
        $days = $this->getRetentionDays('rgpd_retention_newsletter_days', 'newsletter');
        $query = NewsletterSubscriber::whereNotNull('unsubscribed_at')
            ->where('unsubscribed_at', '<', now()->subDays($days));

        $count = $query->count();
        $this->line("  NewsletterSubscriber (désabonnés) : {$count} enregistrements de plus de {$days} jours.");

        if (!$dryRun && $count > 0) {
            $query->delete();
        }
    }
}
