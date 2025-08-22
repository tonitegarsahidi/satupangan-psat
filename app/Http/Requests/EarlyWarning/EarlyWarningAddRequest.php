<?php

namespace App\Http\Requests\EarlyWarning;

use Illuminate\Foundation\Http\FormRequest;

class EarlyWarningAddRequest extends FormRequest
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
            'creator_id' => 'required|exists:users,id',
            'status' => 'required|string|max:50|in:Draft,Approved,Published',
            'title' => 'required|string|max:200',
            'content' => 'required|string',
            'related_product' => 'nullable|string',
            'preventive_steps' => 'nullable|string',
            'attachment_path' => 'nullable|string',
            'url' => 'nullable|string|max:200',
            'urgency_level' => 'required|string|max:50|in:Info,Warning,Danger',
        ];
    }
}
