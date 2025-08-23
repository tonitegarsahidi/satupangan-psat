<?php

namespace App\Http\Requests\Pengawasan;

use Illuminate\Foundation\Http\FormRequest;

class PengawasanRekapListRequest extends FormRequest
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
            'keyword' => 'nullable|string|max:255',
            'per_page' => 'nullable|integer|min:1|max:100',
            'page' => 'nullable|integer|min:1',
            'sort_field' => 'nullable|string|in:id,hasil_rekap,status,created_at,updated_at',
            'sort_order' => 'nullable|string|in:asc,desc',
        ];
    }

    public function messages()
    {
        return [
            'keyword.string' => 'The keyword must be a string.',
            'keyword.max' => 'The keyword may not be greater than 255 characters.',
            'per_page.integer' => 'The per page must be an integer.',
            'per_page.min' => 'The per page must be at least 1.',
            'per_page.max' => 'The per page may not be greater than 100.',
            'page.integer' => 'The page must be an integer.',
            'page.min' => 'The page must be at least 1.',
            'sort_field.string' => 'The sort field must be a string.',
            'sort_field.in' => 'The selected sort field is invalid.',
            'sort_order.string' => 'The sort order must be a string.',
            'sort_order.in' => 'The selected sort order is invalid.',
        ];
    }
}
