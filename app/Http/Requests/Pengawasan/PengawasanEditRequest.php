<?php

namespace App\Http\Requests\Pengawasan;

use Illuminate\Foundation\Http\FormRequest;

class PengawasanEditRequest extends FormRequest
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
            'user_id_initiator' => 'nullable|exists:users,id',
            'lokasi_alamat' => 'nullable|string|max:255',
            'lokasi_kota_id' => 'nullable|exists:master_kota,id',
            'lokasi_provinsi_id' => 'nullable|exists:master_provinsi,id',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'jenis_psat_id' => 'nullable|exists:master_jenis_pangan_segar,id',
            'produk_psat_id' => 'nullable|exists:master_bahan_pangan_segar,id',
            'hasil_pengawasan' => 'nullable|string',
            'status' => 'nullable|string|in:DRAFT,PROSES,SELESAI',
            'tindakan_rekomendasikan' => 'nullable|string',
            'is_active' => 'nullable|boolean',
            'created_by' => 'nullable|exists:users,id',
            'updated_by' => 'nullable|exists:users,id',
        ];
    }

    public function messages()
    {
        return [
            'lokasi_alamat.string' => 'The location address must be a string.',
            'lokasi_alamat.max' => 'The location address may not be greater than 255 characters.',
            'lokasi_kota_id.exists' => 'The selected city is invalid.',
            'lokasi_provinsi_id.exists' => 'The selected province is invalid.',
            'tanggal_mulai.date' => 'The start date must be a valid date.',
            'tanggal_selesai.date' => 'The end date must be a valid date.',
            'tanggal_selesai.after_or_equal' => 'The end date must be a date after or equal to the start date.',
            'jenis_psat_id.exists' => 'The selected PSAT type is invalid.',
            'produk_psat_id.exists' => 'The selected PSAT product is invalid.',
            'hasil_pengawasan.string' => 'The supervision result must be a string.',
            'status.string' => 'The status must be a string.',
            'status.in' => 'The selected status is invalid.',
            'tindakan_rekomendasikan.string' => 'The recommended action must be a string.',
            'is_active.boolean' => 'The active field must be true or false.',
            'created_by.exists' => 'The selected creator is invalid.',
            'updated_by.exists' => 'The selected updater is invalid.',
        ];
    }
}
