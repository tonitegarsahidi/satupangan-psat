<?php

namespace App\Http\Requests\EarlyWarning;

use Illuminate\Foundation\Http\FormRequest;

class EarlyWarningListRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'id' => 'sometimes|exists:early_warnings,id',
            'per_page' => 'sometimes|integer|min:1|max:100',
            'page' => 'sometimes|integer|min:1',
            'keyword' => 'sometimes|string|max:255',
            'sort_field' => 'sometimes|in:id,title,status,urgency_level,created_at,updated_at',
            'sort_order' => 'sometimes|in:asc,desc',
        ];
    }
}
