<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubmitAuditLeadRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            // Honeypot anti-bot : le champ doit etre absent ou vide.
            '_gotcha' => ['nullable', 'prohibited'],

            // Identification lead
            'email' => ['required', 'email:rfc', 'max:100', 'not_regex:/[\r\n]/'],
            'name' => ['nullable', 'string', 'max:100', 'not_regex:/[\r\n]/'],
            'company' => ['nullable', 'string', 'max:100', 'not_regex:/[\r\n]/'],
            'consentement_rgpd' => ['required', 'accepted'],

            // Donnees du diagnostic (persistees en BDD)
            'building_type' => ['nullable', 'string', 'max:50'],
            'surface' => ['nullable', 'integer', 'min:0', 'max:10000000'],
            'score' => ['nullable', 'integer', 'min:0', 'max:100'],
            'level_label' => ['nullable', 'string', 'max:50'],
            'savings_euro' => ['nullable', 'numeric', 'min:0', 'max:10000000'],
            'payload' => ['nullable', 'array'],
        ];
    }

    public function messages(): array
    {
        return [
            '_gotcha.prohibited' => 'Requete invalide.',
            'consentement_rgpd.required' => 'Vous devez accepter le traitement de vos donnees pour recevoir votre diagnostic.',
            'consentement_rgpd.accepted' => 'Vous devez accepter le traitement de vos donnees pour recevoir votre diagnostic.',
        ];
    }
}
