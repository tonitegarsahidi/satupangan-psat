<?php

namespace App\Http\Requests\MasterKota;

use Illuminate\Foundation\Http\FormRequest;

class MasterKotaAddRequest extends FormRequest
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
            'nama_kota' => 'required|string|max:100',
            'is_active' => 'boolean',
        ];
    }
}
