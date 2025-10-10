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
            'pengawasan_rekap_id' => 'required|exists:pengawasan_rekap,id',
            'user_id_pimpinan' => 'required|exists:users,id',
            'tindak_lanjut' => 'required|string',
            'status' => 'required|string',
            'penugasan_pic_id' => 'nullable|array',
            'penugasan_pic_id.*' => 'exists:users,id',
            'penugasan_arahan' => 'nullable|array',
            'penugasan_arahan.*' => 'string',
            'is_active' => 'required|boolean',
        ];
    }

    public function messages()
    {
        return [
            'pengawasan_rekap_id.required' => 'Rekap pengawasan harus dipilih.',
            'pengawasan_rekap_id.exists' => 'Rekap pengawasan yang dipilih tidak valid.',
            'user_id_pimpinan.required' => 'Penanggung jawab harus dipilih.',
            'user_id_pimpinan.exists' => 'Penanggung jawab yang dipilih tidak valid.',
            'tindak_lanjut.required' => 'Arahan tindak lanjut harus diisi.',
            'tindak_lanjut.string' => 'Arahan tindak lanjut harus berupa teks.',
            'status.required' => 'Status harus dipilih.',
            'status.string' => 'Status harus berupa teks.',
            'penugasan_pic_id.array' => 'Data PIC penugasan harus berupa array.',
            'penugasan_pic_id.*.exists' => 'PIC yang dipilih tidak valid.',
            'penugasan_arahan.array' => 'Data arahan penugasan harus berupa array.',
            'penugasan_arahan.*.string' => 'Arahan tindak lanjut harus berupa teks.',
            'is_active.required' => 'Status aktif harus dipilih.',
            'is_active.boolean' => 'Status aktif harus bernilai benar atau salah.',
        ];
    }
}
