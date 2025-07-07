<?php

namespace App\Http\Requests\MasterBahanPanganSegar;

use Illuminate\Foundation\Http\FormRequest;

class MasterBahanPanganSegarEditRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'jenis_id' => 'required|string|max:36',
            'nama_bahan_pangan_segar' => 'required|string|max:100',
            'kode_bahan_pangan_segar' => 'nullable|string|max:12',
            'is_active' => 'boolean',
        ];
    }
}
