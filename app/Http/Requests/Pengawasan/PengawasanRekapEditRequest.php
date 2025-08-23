<?php

namespace App\Http\Requests\Pengawasan;

use Illuminate\Foundation\Http\FormRequest;

class PengawasanRekapEditRequest extends FormRequest
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
            'pengawasan_id' => 'nullable|exists:pengawasans,id',
            'user_id_admin' => 'nullable|exists:users,id',
            'jenis_psat_id' => 'nullable|exists:master_jenis_pangan_segars,id',
            'produk_psat_id' => 'nullable|exists:master_bahan_pangan_segars,id',
            'hasil_rekap' => 'nullable|string',
            'status' => 'nullable|string|in:DRAFT,PROSES,SELESAI',
            'pic_tindakan_id' => 'nullable|exists:users,id',
            'is_active' => 'nullable|boolean',
            'created_by' => 'nullable|exists:users,id',
            'updated_by' => 'nullable|exists:users,id',
        ];
    }

    public function messages()
    {
        return [
            'pengawasan_id.exists' => 'The selected supervision is invalid.',
            'user_id_admin.exists' => 'The selected admin is invalid.',
            'jenis_psat_id.exists' => 'The selected PSAT type is invalid.',
            'produk_psat_id.exists' => 'The selected PSAT product is invalid.',
            'hasil_rekap.string' => 'The recap result must be a string.',
            'status.string' => 'The status must be a string.',
            'status.in' => 'The selected status is invalid.',
            'pic_tindakan_id.exists' => 'The selected PIC is invalid.',
            'is_active.boolean' => 'The active field must be true or false.',
            'created_by.exists' => 'The selected creator is invalid.',
            'updated_by.exists' => 'The selected updater is invalid.',
        ];
    }
}
