<?php

namespace App\Http\Requests\Pengawasan;

use Illuminate\Foundation\Http\FormRequest;

class PengawasanTindakanEditRequest extends FormRequest
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
            'pengawasan_rekap_id' => 'nullable|exists:pengawasan_rekap,id',
            'user_id_pimpinan' => 'nullable|exists:users,id',
            'tindak_lanjut' => 'nullable|string',
            'status' => 'nullable|string',
            'pic_tindakan_ids' => 'nullable|array',
            'pic_tindakan_ids.*' => 'exists:users,id',
            'is_active' => 'nullable|boolean',
            'created_by' => 'nullable|exists:users,id',
            'updated_by' => 'nullable|exists:users,id',
        ];
    }

    public function messages()
    {
        return [
            'pengawasan_rekap_id.exists' => 'The selected rekap pengawasan is invalid.',
            'user_id_pimpinan.exists' => 'The selected pimpinan is invalid.',
            'tindak_lanjut.string' => 'The follow-up action must be a string.',
            'status.string' => 'The status must be a string.',
            'pic_tindakan_ids.array' => 'The PIC field must be an array.',
            'pic_tindakan_ids.*.exists' => 'One or more selected PICs are invalid.',
            'is_active.boolean' => 'The active field must be true or false.',
            'created_by.exists' => 'The selected creator is invalid.',
            'updated_by.exists' => 'The selected updater is invalid.',
        ];
    }
}
