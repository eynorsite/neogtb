<?php

namespace App\Observers;

use App\Models\Admin;
use App\Models\GeneralSetting;
use App\Models\PrivacyPolicyVersion;
use App\Services\SiteConfigService;
use Illuminate\Support\Facades\Log;

/**
 * Observer sur GeneralSetting.
 *
 * Note : le cache model est déjà invalidé via GeneralSetting::booted().
 * Cet observer gère le versioning de la politique de confidentialité
 * lorsque le champ legal_texts change, ainsi que l'invalidation du cache service.
 */
class SiteSettingObserver
{
    public function saving(GeneralSetting $setting): void
    {
        // Filament peut sauver un TextInput vide en null dans les colonnes JSON.
        // Arr::get() retourne alors ce null au lieu du default, et casse la
        // signature ': string' de SiteConfigService::label() → TypeError → 500.
        // On normalise null → '' à l'enregistrement pour garantir l'invariant.
        foreach (['ui_labels', 'legal_texts'] as $column) {
            if ($setting->isDirty($column) && is_array($setting->{$column})) {
                $setting->{$column} = $this->normalizeNullsToStrings($setting->{$column});
            }
        }
    }

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

    /**
     * Recurse dans un array nested et remplace toute valeur null par ''.
     * Laisse les sous-arrays tranquilles (ils peuvent legitimment contenir
     * des structures complexes dont on ne veut pas toucher).
     */
    private function normalizeNullsToStrings(array $data): array
    {
        foreach ($data as $key => $value) {
            if ($value === null) {
                $data[$key] = '';
            } elseif (is_array($value)) {
                $data[$key] = $this->normalizeNullsToStrings($value);
            }
        }

        return $data;
    }

    public function deleted(GeneralSetting $setting): void
    {
        app(SiteConfigService::class)->clearCache();
    }

    private function createPrivacyPolicyVersion(string $content): void
    {
        // Résoudre l'auteur : auth web > premier admin (CLI/seeder) > skip propre
        $authorId = $this->resolveAuthorId();

        if ($authorId === null) {
            Log::info('[SiteSettingObserver] Versioning politique de confidentialité ignoré : aucun admin disponible (installation vierge).');

            return;
        }

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
            'created_by'   => $authorId,
        ]);
    }

    /**
     * Détermine l'auteur de la version à créer.
     *
     * Gère 3 contextes :
     *   1. Web authentifié     → ID de l'admin connecté
     *   2. CLI avec admins     → ID du premier admin existant (seeder, artisan)
     *   3. Installation vierge → null (le caller doit skipper la création)
     */
    private function resolveAuthorId(): ?int
    {
        if ($id = auth()->id()) {
            return (int) $id;
        }

        return Admin::query()->orderBy('id')->value('id');
    }
}
