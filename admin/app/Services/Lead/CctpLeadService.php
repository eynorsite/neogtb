<?php

namespace App\Services\Lead;

use App\Models\CctpLead;

class CctpLeadService
{
    /**
     * Enregistre un lead issu du téléchargement du modèle de CCTP décret BACS.
     * Le champ consentement_rgpd éventuel est ignoré (non fillable).
     */
    public function submit(array $data, string $ipHash): CctpLead
    {
        return CctpLead::create(array_merge($data, [
            'ip_address' => $ipHash,
            'status' => 'new',
        ]));
    }
}
