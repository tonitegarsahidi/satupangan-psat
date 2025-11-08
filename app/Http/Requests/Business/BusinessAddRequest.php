<?php

namespace App\Http\Requests\Business;

use Illuminate\Foundation\Http\FormRequest;

class BusinessAddRequest extends FormRequest
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
            'nama_perusahaan' => 'required|string|max:255',
            'alamat_perusahaan' => 'required|string|max:500',
            'jabatan_perusahaan' => 'required|string|max:255',
            'nib' => 'required|string|max:50',
            'is_umkm' => 'sometimes|boolean',
            'provinsi_id' => 'required|exists:master_provinsis,id',
            'kota_id' => 'required|exists:master_kotas,id',
            'jenispsat_id' => 'sometimes|array',
            'jenispsat_id.*' => 'exists:master_jenis_pangan_segars,id',
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'nama_perusahaan.required' => 'Nama perusahaan wajib diisi',
            'alamat_perusahaan.required' => 'Alamat perusahaan wajib diisi',
            'jabatan_perusahaan.required' => 'Jabatan perusahaan wajib diisi',
            'nib.required' => 'NIB wajib diisi',
            'provinsi_id.required' => 'Provinsi wajib diisi',
            'provinsi_id.exists' => 'Provinsi tidak valid',
            'kota_id.required' => 'Kota wajib diisi',
            'kota_id.exists' => 'Kota tidak valid',
            'jenispsat_id.*.exists' => 'Jenis PSAT tidak valid',
        ];
    }
}
