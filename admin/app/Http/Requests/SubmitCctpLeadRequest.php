<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubmitCctpLeadRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'email' => ['required', 'email:rfc', 'max:100'],
            'company' => ['nullable', 'string', 'max:100'],
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
