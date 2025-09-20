<?php

namespace App\Http\Requests\Pengawasan;

use Illuminate\Foundation\Http\FormRequest;

class PengawasanTindakanAddRequest extends FormRequest
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
            'pengawasan_rekap_id' => 'required|exists:pengawasan_rekap,id',
            'user_id_pimpinan' => 'required|exists:users,id',
            'tindak_lanjut' => 'required|string',
            'status' => 'required|string',
            'penugasan_pic_id' => 'nullable|array',
            'penugasan_pic_id.*' => 'exists:users,id',
            'penugasan_arahan' => 'nullable|array',
            'penugasan_arahan.*' => 'required|string',
            'created_by' => 'nullable|exists:users,id',
            'updated_by' => 'nullable|exists:users,id',
        ];
    }

    public function messages()
    {
        return [
            'pengawasan_rekap_id.required' => 'The rekap pengawasan field is required.',
            'pengawasan_rekap_id.exists' => 'The selected rekap pengawasan is invalid.',
            'user_id_pimpinan.required' => 'The pimpinan field is required.',
            'user_id_pimpinan.exists' => 'The selected pimpinan is invalid.',
            'tindak_lanjut.required' => 'The follow-up action field is required.',
            'tindak_lanjut.string' => 'The follow-up action must be a string.',
            'status.required' => 'The status field is required.',
            'status.string' => 'The status must be a string.',
            'penugasan_pic_id.array' => 'The PIC assignment field must be an array.',
            'penugasan_pic_id.*.exists' => 'One or more selected PICs are invalid.',
            'penugasan_arahan.array' => 'The action instruction field must be an array.',
            'penugasan_arahan.*.required' => 'The action instruction field is required.',
            'penugasan_arahan.*.string' => 'The action instruction must be a string.',
            'created_by.exists' => 'The selected creator is invalid.',
            'updated_by.exists' => 'The selected updater is invalid.',
        ];
    }
}
