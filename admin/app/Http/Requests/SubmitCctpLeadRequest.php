<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubmitCctpLeadRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            // Honeypot : le lead magnet CCTP était le seul formulaire sans champ
            // leurre. Aligné sur SubmitAuditLeadRequest.
            '_gotcha' => ['nullable', 'prohibited'],
            'email' => ['required', 'email:rfc', 'max:100', 'not_regex:/[\r\n]/'],
            'company' => ['nullable', 'string', 'max:100', 'not_regex:/[\r\n]/'],
            'consentement_rgpd' => ['required', 'accepted'],
        ];
    }

    public function messages(): array
    {
        return [
            'consentement_rgpd.required' => 'Vous devez accepter le traitement de vos données pour télécharger le modèle.',
            'consentement_rgpd.accepted' => 'Vous devez accepter le traitement de vos données pour télécharger le modèle.',
        ];
    }
}
