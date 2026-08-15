<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubmitGdprRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            // Honeypot : champ leurre présent dans la vue mais jamais contrôlé
            // jusqu'ici. Aligné sur SubmitAuditLeadRequest.
            '_gotcha' => ['nullable', 'prohibited'],
            'type' => ['required', 'in:access,deletion,portability,rectification,opposition'],
            'email' => ['required', 'email:rfc', 'max:255', 'not_regex:/[\r\n]/'],
            'name' => ['required', 'string', 'max:255', 'not_regex:/[\r\n<>]/'],
            'message' => ['nullable', 'string', 'min:10', 'max:1000'],
        ];
    }
}
