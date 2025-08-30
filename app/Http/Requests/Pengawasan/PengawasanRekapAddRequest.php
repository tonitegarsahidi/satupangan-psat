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
            'pengawasan_ids' => 'sometimes|array',
            'pengawasan_ids.*' => 'required|exists:pengawasans,id',
            'user_id_admin' => 'required|exists:users,id',
            'jenis_psat_id' => 'required|exists:master_jenis_pangan_segars,id',
            'produk_psat_id' => 'required|exists:master_bahan_pangan_segars,id',
            'provinsi_id' => 'nullable|exists:master_provinsis,id',
            'hasil_rekap' => 'required|string',
            'lampiran1' => 'nullable|string|max:200',
            'lampiran2' => 'nullable|string|max:200',
            'lampiran3' => 'nullable|string|max:200',
            'lampiran4' => 'nullable|string|max:200',
            'lampiran5' => 'nullable|string|max:200',
            'lampiran6' => 'nullable|string|max:200',
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
            'pengawasan_ids.array' => 'The supervision field must be an array.',
            'pengawasan_ids.*.required' => 'The supervision field is required.',
            'pengawasan_ids.*.exists' => 'The selected supervision is invalid.',
            'user_id_admin.required' => 'The admin field is required.',
            'user_id_admin.exists' => 'The selected admin is invalid.',
            'jenis_psat_id.required' => 'The PSAT type field is required.',
            'jenis_psat_id.exists' => 'The selected PSAT type is invalid.',
            'produk_psat_id.required' => 'The PSAT product field is required.',
            'produk_psat_id.exists' => 'The selected PSAT product is invalid.',
            'provinsi_id.exists' => 'The selected province is invalid.',
            'hasil_rekap.required' => 'The recap result field is required.',
            'hasil_rekap.string' => 'The recap result must be a string.',
            'lampiran1.string' => 'The attachment 1 must be a string.',
            'lampiran1.max' => 'The attachment 1 may not be greater than 200 characters.',
            'lampiran2.string' => 'The attachment 2 must be a string.',
            'lampiran2.max' => 'The attachment 2 may not be greater than 200 characters.',
            'lampiran3.string' => 'The attachment 3 must be a string.',
            'lampiran3.max' => 'The attachment 3 may not be greater than 200 characters.',
            'lampiran4.string' => 'The attachment 4 must be a string.',
            'lampiran4.max' => 'The attachment 4 may not be greater than 200 characters.',
            'lampiran5.string' => 'The attachment 5 must be a string.',
            'lampiran5.max' => 'The attachment 5 may not be greater than 200 characters.',
            'lampiran6.string' => 'The attachment 6 must be a string.',
            'lampiran6.max' => 'The attachment 6 may not be greater than 200 characters.',
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
