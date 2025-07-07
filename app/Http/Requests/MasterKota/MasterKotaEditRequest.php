<?php

namespace App\Http\Requests\MasterKota;

use Illuminate\Foundation\Http\FormRequest;

class MasterKotaEditRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'provinsi_id' => 'required|uuid|exists:master_provinsis,id',
            'kode_kota' => 'nullable|string|max:12',
            'nama_kota' => 'required|string|max:100|unique:master_kotas,nama_kota,' . $this->route('id') . ',id',
            'is_active' => 'boolean',
        ];
    }
}
