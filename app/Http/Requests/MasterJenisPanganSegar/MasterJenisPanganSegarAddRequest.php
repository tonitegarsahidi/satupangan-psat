<?php

namespace App\Http\Requests\MasterJenisPanganSegar;

use Illuminate\Foundation\Http\FormRequest;

class MasterJenisPanganSegarAddRequest extends FormRequest
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
            'kelompok_id' => 'required|string|max:36',
            'kode_jenis_pangan_segar' => 'nullable|string|max:12',
            'nama_jenis_pangan_segar' => 'required|string|max:100',
            'is_active' => 'boolean',
        ];
    }
}
