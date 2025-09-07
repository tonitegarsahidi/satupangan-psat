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
            'pengawasan_ids.*' => 'required|exists:pengawasan,id',
            'user_id_admin' => 'nullable|exists:users,id',
            'jenis_psat_id' => 'required|exists:master_jenis_pangan_segars,id',
            'produk_psat_id' => 'required|exists:master_bahan_pangan_segars,id',
            'provinsi_id' => 'nullable|exists:master_provinsis,id',
            'judul_rekap' => 'nullable|string|max:200',
            'hasil_rekap' => 'required|string',
            'lampiran1' => 'nullable|file|max:102400|mimes:pdf,jpeg,jpg,doc,docx,png',
            'lampiran2' => 'nullable|file|max:102400|mimes:pdf,jpeg,jpg,doc,docx,png',
            'lampiran3' => 'nullable|file|max:102400|mimes:pdf,jpeg,jpg,doc,docx,png',
            'lampiran4' => 'nullable|file|max:102400|mimes:pdf,jpeg,jpg,doc,docx,png',
            'lampiran5' => 'nullable|file|max:102400|mimes:pdf,jpeg,jpg,doc,docx,png',
            'lampiran6' => 'nullable|file|max:102400|mimes:pdf,jpeg,jpg,doc,docx,png',
            'status' => 'nullable|string|in:DRAFT,PROSES,SELESAI',
            'pic_tindakan_id' => 'nullable|exists:users,id',
            'tindakan_id' => 'nullable|exists:pengawasan_tindakan,id',
            'is_active' => 'nullable|boolean',
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
            'user_id_admin.exists' => 'The selected admin is invalid.',
            'jenis_psat_id.required' => 'The PSAT type field is required.',
            'jenis_psat_id.exists' => 'The selected PSAT type is invalid.',
            'produk_psat_id.required' => 'The PSAT product field is required.',
            'produk_psat_id.exists' => 'The selected PSAT product is invalid.',
            'provinsi_id.exists' => 'The selected province is invalid.',
            'judul_rekap.string' => 'The recap title must be a string.',
            'judul_rekap.max' => 'The recap title may not be greater than 200 characters.',
            'hasil_rekap.required' => 'The recap result field is required.',
            'hasil_rekap.string' => 'The recap result must be a string.',
            'lampiran1.file' => 'Lampiran 1 harus berupa file.',
            'lampiran1.max' => 'Ukuran file Lampiran 1 maksimal 100MB.',
            'lampiran1.mimes' => 'Lampiran 1 harus berupa file dengan ekstensi: pdf, jpeg, jpg, doc, docx, png.',
            'lampiran2.file' => 'Lampiran 2 harus berupa file.',
            'lampiran2.max' => 'Ukuran file Lampiran 2 maksimal 100MB.',
            'lampiran2.mimes' => 'Lampiran 2 harus berupa file dengan ekstensi: pdf, jpeg, jpg, doc, docx, png.',
            'lampiran3.file' => 'Lampiran 3 harus berupa file.',
            'lampiran3.max' => 'Ukuran file Lampiran 3 maksimal 100MB.',
            'lampiran3.mimes' => 'Lampiran 3 harus berupa file dengan ekstensi: pdf, jpeg, jpg, doc, docx, png.',
            'lampiran4.file' => 'Lampiran 4 harus berupa file.',
            'lampiran4.max' => 'Ukuran file Lampiran 4 maksimal 100MB.',
            'lampiran4.mimes' => 'Lampiran 4 harus berupa file dengan ekstensi: pdf, jpeg, jpg, doc, docx, png.',
            'lampiran5.file' => 'Lampiran 5 harus berupa file.',
            'lampiran5.max' => 'Ukuran file Lampiran 5 maksimal 100MB.',
            'lampiran5.mimes' => 'Lampiran 5 harus berupa file dengan ekstensi: pdf, jpeg, jpg, doc, docx, png.',
            'lampiran6.file' => 'Lampiran 6 harus berupa file.',
            'lampiran6.max' => 'Ukuran file Lampiran 6 maksimal 100MB.',
            'lampiran6.mimes' => 'Lampiran 6 harus berupa file dengan ekstensi: pdf, jpeg, jpg, doc, docx, png.',
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
