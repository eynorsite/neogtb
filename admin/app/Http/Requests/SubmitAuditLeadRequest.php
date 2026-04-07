<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubmitAuditLeadRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'email' => ['required', 'email:rfc', 'max:100'],
            'name' => ['nullable', 'string', 'max:100', 'not_regex:/[\r\n]/'],
            'company' => ['nullable', 'string', 'max:100', 'not_regex:/[\r\n]/'],
            'score' => ['nullable', 'integer', 'min:0', 'max:100'],
            'level_label' => ['nullable', 'string', 'max:50'],
            'surface' => ['nullable', 'integer', 'min:0', 'max:10000000'],
            'savings_euro' => ['nullable', 'integer', 'min:0', 'max:10000000'],
            'payload' => ['nullable', 'array'],
        ];
    }
}
