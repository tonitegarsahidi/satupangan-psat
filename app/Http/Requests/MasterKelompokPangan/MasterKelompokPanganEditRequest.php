<?php

namespace App\Http\Requests\MasterKelompokPangan;

use Illuminate\Foundation\Http\FormRequest;

class MasterKelompokPanganEditRequest extends FormRequest
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
            'nama_kelompok_pangan' => 'required|string|max:100|unique:master_kelompok_pangans,nama_kelompok_pangan,' . $this->route('id') . ',id',
            'kode_kelompok_pangan' => 'nullable|string|max:12|unique:master_kelompok_pangans,kode_kelompok_pangan,' . $this->route('id') . ',id',
            'keterangan' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ];
    }
}
