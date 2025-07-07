<?php

namespace App\Http\Requests\MasterKelompokPangan;

use Illuminate\Foundation\Http\FormRequest;

class MasterKelompokPanganAddRequest extends FormRequest
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
            'kode_kelompok_pangan' => 'nullable|string|max:12',
            'nama_kelompok_pangan' => 'required|string|max:100',
            'keterangan' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ];
    }
}
