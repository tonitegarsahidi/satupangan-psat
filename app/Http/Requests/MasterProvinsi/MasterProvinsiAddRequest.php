<?php

namespace App\Http\Requests\MasterProvinsi;

use Illuminate\Foundation\Http\FormRequest;

class MasterProvinsiAddRequest extends FormRequest
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
            'kode_provinsi' => 'nullable|string|max:12',
            'nama_provinsi' => 'required|string|max:100',
            'is_active' => 'boolean',
        ];
    }
}
