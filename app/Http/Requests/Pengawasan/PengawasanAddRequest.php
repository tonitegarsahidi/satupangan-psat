<?php

namespace App\Http\Requests\Pengawasan;

use Illuminate\Foundation\Http\FormRequest;

class PengawasanAddRequest extends FormRequest
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
            'lokasi_alamat' => 'required|string|max:255',
            'lokasi_kota_id' => 'required|exists:master_kota,id',
            'lokasi_provinsi_id' => 'required|exists:master_provinsi,id',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'jenis_psat_id' => 'required|exists:master_jenis_pangan_segar,id',
            'produk_psat_id' => 'required|exists:master_bahan_pangan_segar,id',
            'hasil_pengawasan' => 'required|string',
            'status' => 'required|string|in:DRAFT,PROSES,SELESAI',
            'tindakan_rekomendasikan' => 'nullable|string',
            'is_active' => 'required|boolean',
            'created_by' => 'nullable|exists:users,id',
            'updated_by' => 'nullable|exists:users,id',
        ];
    }

    public function messages()
    {
        return [
            'lokasi_alamat.required' => 'The location address field is required.',
            'lokasi_alamat.string' => 'The location address must be a string.',
            'lokasi_alamat.max' => 'The location address may not be greater than 255 characters.',
            'lokasi_kota_id.required' => 'The city field is required.',
            'lokasi_kota_id.exists' => 'The selected city is invalid.',
            'lokasi_provinsi_id.required' => 'The province field is required.',
            'lokasi_provinsi_id.exists' => 'The selected province is invalid.',
            'tanggal_mulai.required' => 'The start date field is required.',
            'tanggal_mulai.date' => 'The start date must be a valid date.',
            'tanggal_selesai.date' => 'The end date must be a valid date.',
            'tanggal_selesai.after_or_equal' => 'The end date must be a date after or equal to the start date.',
            'jenis_psat_id.required' => 'The PSAT type field is required.',
            'jenis_psat_id.exists' => 'The selected PSAT type is invalid.',
            'produk_psat_id.required' => 'The PSAT product field is required.',
            'produk_psat_id.exists' => 'The selected PSAT product is invalid.',
            'hasil_pengawasan.required' => 'The supervision result field is required.',
            'hasil_pengawasan.string' => 'The supervision result must be a string.',
            'status.required' => 'The status field is required.',
            'status.string' => 'The status must be a string.',
            'status.in' => 'The selected status is invalid.',
            'tindakan_rekomendasikan.string' => 'The recommended action must be a string.',
            'is_active.required' => 'The active field is required.',
            'is_active.boolean' => 'The active field must be true or false.',
            'created_by.exists' => 'The selected creator is invalid.',
            'updated_by.exists' => 'The selected updater is invalid.',
        ];
    }
}
