<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QrBadanPanganRequest extends FormRequest
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
            'business_id' => 'required|uuid|exists:business,id',
            'qr_code' => 'nullable|string|max:255',
            'current_assignee' => 'nullable|uuid|exists:users,id',
            'requested_by' => 'nullable|uuid|exists:users,id',
            'requested_at' => 'nullable|date',
            'reviewed_by' => 'nullable|uuid|exists:users,id',
            'reviewed_at' => 'nullable|date',
            'approved_by' => 'nullable|uuid|exists:users,id',
            'approved_at' => 'nullable|date',
            'status' => 'nullable|string|max:50',
            'is_published' => 'nullable|boolean',
            'qr_category' => 'nullable|integer|min:1',
            'nama_komoditas' => 'required|string|max:200',
            'nama_latin' => 'required|string|max:200',
            'merk_dagang' => 'required|string|max:200',
            'jenis_psat' => 'nullable|uuid|exists:master_jenis_pangan_segars,id',
            'referensi_sppb' => 'nullable|uuid|exists:register_sppb_jenispsat,id',
            'referensi_izinedar_psatpl' => 'nullable|uuid|exists:register_izinedar_psatpl,id',
            'referensi_izinedar_psatpd' => 'nullable|uuid|exists:register_izinedar_psatpd,id',
            'referensi_izinedar_psatpduk' => 'nullable|uuid|exists:register_izinedar_psatpduk,id',
            'referensi_izinrumah_pengemasan' => 'nullable|uuid|exists:register_izinrumah_pengemasan,id',
            'referensi_sertifikat_keamanan_pangan' => 'nullable|uuid|exists:register_sertifikat_keamanan_pangan,id',
            'file_lampiran1' => 'nullable|file|mimes:pdf,jpeg,jpg,doc,docx,png',
            'file_lampiran2' => 'nullable|file|mimes:pdf,jpeg,jpg,doc,docx,png',
            'file_lampiran3' => 'nullable|file|mimes:pdf,jpeg,jpg,doc,docx,png',
            'file_lampiran4' => 'nullable|file|mimes:pdf,jpeg,jpg,doc,docx,png',
            'file_lampiran5' => 'nullable|file|mimes:pdf,jpeg,jpg,doc,docx,png',
            'created_by' => 'nullable|string',
            'updated_by' => 'nullable|string',
        ];
    }

    /**
     * Get the custom error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'business_id.required' => 'Business wajib dipilih',
            'business_id.uuid' => 'Format ID business tidak valid',
            'business_id.exists' => 'Business tidak ditemukan',
            'qr_code.max' => 'QR Code maksimal 255 karakter',
            'current_assignee.exists' => 'Assignee tidak ditemukan',
            'requested_by.exists' => 'Requested by tidak ditemukan',
            'requested_at.date' => 'Format requested at tidak valid',
            'reviewed_by.exists' => 'Reviewed by tidak ditemukan',
            'reviewed_at.date' => 'Format reviewed at tidak valid',
            'approved_by.exists' => 'Approved by tidak ditemukan',
            'approved_at.date' => 'Format approved at tidak valid',
            'status.max' => 'Status maksimal 50 karakter',
            'is_published.boolean' => 'Is published harus berupa boolean',
            'qr_category.integer' => 'QR Category harus berupa angka',
            'qr_category.min' => 'QR Category minimal 1',
            'qr_category.max' => 'QR Category maksimal 3',
            'nama_komoditas.required' => 'Nama komoditas wajib diisi',
            'nama_komoditas.max' => 'Nama komoditas maksimal 200 karakter',
            'nama_latin.required' => 'Nama latin wajib diisi',
            'nama_latin.max' => 'Nama latin maksimal 200 karakter',
            'merk_dagang.required' => 'Merk dagang wajib diisi',
            'merk_dagang.max' => 'Merk dagang maksimal 200 karakter',
            'jenis_psat.exists' => 'Jenis PSAT tidak ditemukan',
            'referensi_sppb.exists' => 'Referensi SPPB tidak ditemukan',
            'referensi_izinedar_psatpl.exists' => 'Referensi Izin EDAR PSATPL tidak ditemukan',
            'referensi_izinedar_psatpd.exists' => 'Referensi Izin EDAR PSATPD tidak ditemukan',
            'referensi_izinedar_psatpduk.exists' => 'Referensi Izin EDAR PSATPDUK tidak ditemukan',
            'referensi_izinrumah_pengemasan.exists' => 'Referensi Izin Rumah Pengemasan tidak ditemukan',
            'referensi_sertifikat_keamanan_pangan.exists' => 'Referensi Sertifikat Keamanan Pangan tidak ditemukan',
            'file_lampiran1.mimes' => 'File lampiran 1 harus berformat PDF, JPEG, JPG, DOC, DOCX, atau PNG',
            'file_lampiran2.mimes' => 'File lampiran 2 harus berformat PDF, JPEG, JPG, DOC, DOCX, atau PNG',
            'file_lampiran3.mimes' => 'File lampiran 3 harus berformat PDF, JPEG, JPG, DOC, DOCX, atau PNG',
            'file_lampiran4.mimes' => 'File lampiran 4 harus berformat PDF, JPEG, JPG, DOC, DOCX, atau PNG',
            'file_lampiran5.mimes' => 'File lampiran 5 harus berformat PDF, JPEG, JPG, DOC, DOCX, atau PNG',
        ];
    }
}
