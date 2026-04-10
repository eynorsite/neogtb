<?php

namespace App\Observers;

use App\Models\GeneralSetting;
use App\Models\PrivacyPolicyVersion;
use App\Services\SiteConfigService;

/**
 * Observer sur GeneralSetting.
 *
 * Note : le cache model est déjà invalidé via GeneralSetting::booted().
 * Cet observer gère le versioning de la politique de confidentialité
 * lorsque le champ legal_texts change, ainsi que l'invalidation du cache service.
 */
class SiteSettingObserver
{
    public function saved(GeneralSetting $setting): void
    {
        // Invalider le cache service
        app(SiteConfigService::class)->clearCache();

        // Si legal_texts a changé et contient une politique de confidentialité, versionner
        if ($setting->isDirty('legal_texts')) {
            $legalTexts = $setting->legal_texts ?? [];
            $policy = $legalTexts['politique_confidentialite'] ?? null;

            if (filled($policy)) {
                $this->createPrivacyPolicyVersion($policy);
            }
        }
    }

    public function deleted(GeneralSetting $setting): void
    {
        app(SiteConfigService::class)->clearCache();
    }

    private function createPrivacyPolicyVersion(string $content): void
    {
        // Désactiver les versions précédentes
        PrivacyPolicyVersion::where('is_current', true)->update(['is_current' => false]);

        // Calculer le prochain numéro de version
        $lastVersion = PrivacyPolicyVersion::max('version') ?? '0.0';
        $parts = explode('.', $lastVersion);
        $major = (int) ($parts[0] ?? 0);
        $minor = (int) ($parts[1] ?? 0);
        $newVersion = $major . '.' . ($minor + 1);

        // Créer la nouvelle version
        PrivacyPolicyVersion::create([
            'version'      => $newVersion,
            'content'      => $content,
            'published_at' => now(),
            'is_current'   => true,
            'created_by'   => auth()->id(),
        ]);
    }
}
