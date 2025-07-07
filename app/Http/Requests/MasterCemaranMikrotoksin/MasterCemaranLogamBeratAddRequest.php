<?php

namespace App\Http\Requests\MasterCemaranLogamBerat;

use Illuminate\Foundation\Http\FormRequest;

class MasterCemaranLogamBeratAddRequest extends FormRequest
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
            'kode_cemaran_logam_berat' => 'nullable|string|max:12',
            'nama_cemaran_logam_berat' => 'required|string|max:255',
            'keterangan' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ];
    }
}
