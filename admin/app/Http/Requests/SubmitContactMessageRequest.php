<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubmitContactMessageRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100', 'not_regex:/[\r\n]/'],
            'email' => ['required', 'email:rfc', 'max:100', 'not_regex:/[\r\n]/'],
            'company' => ['nullable', 'string', 'max:100', 'not_regex:/[\r\n]/'],
            'subject' => ['required', 'string', 'max:200', 'not_regex:/[\r\n]/'],
            'message' => ['required', 'string', 'min:10', 'max:5000'],
            'source_page' => ['nullable', 'string', 'max:200'],
            'consentement_rgpd' => ['accepted'],
        ];
    }

    public function messages(): array
    {
        return [
            'consentement_rgpd.accepted' => 'Vous devez accepter le traitement de vos donnees pour envoyer votre message.',
        ];
    }
}
