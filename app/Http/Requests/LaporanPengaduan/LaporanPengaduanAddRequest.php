<?php

namespace App\Http\Requests\LaporanPengaduan;

use Illuminate\Foundation\Http\FormRequest;

class LaporanPengaduanAddRequest extends FormRequest
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
            'nama_pelapor' => 'required|string|max:255',
            'nik_pelapor' => 'nullable|string|max:32',
            'nomor_telepon_pelapor' => 'nullable|string|max:32',
            'email_pelapor' => 'nullable|string|email|max:255',
            'lokasi_kejadian' => 'nullable|string',
            'provinsi_id' => 'required|uuid',
            'kota_id' => 'required|uuid',
            'isi_laporan' => 'required|string',
            // 'tindak_lanjut_pertama' => 'nullable|string',
            // 'is_active' => 'required|boolean',
        ];
    }
}
