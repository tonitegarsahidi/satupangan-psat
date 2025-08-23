<?php

namespace App\Http\Requests\Pengawasan;

use Illuminate\Foundation\Http\FormRequest;

class PengawasanRekapAddRequest extends FormRequest
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
            'pengawasan_id' => 'required|exists:pengawasans,id',
            'user_id_admin' => 'required|exists:users,id',
            'jenis_psat_id' => 'required|exists:master_jenis_pangan_segars,id',
            'produk_psat_id' => 'required|exists:master_bahan_pangan_segars,id',
            'hasil_rekap' => 'required|string',
            'status' => 'required|string|in:DRAFT,PROSES,SELESAI',
            'pic_tindakan_id' => 'nullable|exists:users,id',
            'is_active' => 'required|boolean',
            'created_by' => 'nullable|exists:users,id',
            'updated_by' => 'nullable|exists:users,id',
        ];
    }

    public function messages()
    {
        return [
            'pengawasan_id.required' => 'The supervision field is required.',
            'pengawasan_id.exists' => 'The selected supervision is invalid.',
            'user_id_admin.required' => 'The admin field is required.',
            'user_id_admin.exists' => 'The selected admin is invalid.',
            'jenis_psat_id.required' => 'The PSAT type field is required.',
            'jenis_psat_id.exists' => 'The selected PSAT type is invalid.',
            'produk_psat_id.required' => 'The PSAT product field is required.',
            'produk_psat_id.exists' => 'The selected PSAT product is invalid.',
            'hasil_rekap.required' => 'The recap result field is required.',
            'hasil_rekap.string' => 'The recap result must be a string.',
            'status.required' => 'The status field is required.',
            'status.string' => 'The status must be a string.',
            'status.in' => 'The selected status is invalid.',
            'pic_tindakan_id.exists' => 'The selected PIC is invalid.',
            'is_active.required' => 'The active field is required.',
            'is_active.boolean' => 'The active field must be true or false.',
            'created_by.exists' => 'The selected creator is invalid.',
            'updated_by.exists' => 'The selected updater is invalid.',
        ];
    }
}
