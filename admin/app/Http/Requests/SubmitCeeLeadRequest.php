<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubmitCeeLeadRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'email' => ['required', 'email:rfc', 'max:100'],
            'name' => ['nullable', 'string', 'max:100'],
            'company' => ['nullable', 'string', 'max:100'],
            'sector' => ['nullable', 'string', 'max:50'],
            'th116_mwh' => ['nullable', 'numeric', 'min:0', 'max:100000'],
            'th116_value' => ['nullable', 'numeric', 'min:0', 'max:999999'],
            'consentement_rgpd' => ['required', 'accepted'],
            'payload' => ['nullable', 'array'],
        ];
    }

    public function messages(): array
    {
        return [
            'consentement_rgpd.required' => 'Vous devez accepter le traitement de vos données pour recevoir votre estimation CEE.',
            'consentement_rgpd.accepted' => 'Vous devez accepter le traitement de vos données pour recevoir votre estimation CEE.',
        ];
    }
}
