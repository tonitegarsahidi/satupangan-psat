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
            'lokasi_kota_id' => 'nullable|exists:master_kotas,id',
            'lokasi_provinsi_id' => 'nullable|exists:master_provinsis,id',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'jenis_psat_id' => 'nullable|exists:master_jenis_pangan_segars,id',
            'produk_psat_id' => 'nullable|exists:master_bahan_pangan_segars,id',
            'hasil_pengawasan' => 'nullable|string',
            'lampiran1' => 'nullable|file',
            'lampiran2' => 'nullable|file',
            'lampiran3' => 'nullable|file',
            'lampiran4' => 'nullable|file',
            'lampiran5' => 'nullable|file',
            'lampiran6' => 'nullable|file',
            'status' => 'nullable|string|in:DRAFT,PROSES,SELESAI',
            'tindakan_rekomendasikan' => 'nullable|string',
            'is_active' => 'nullable|boolean',
            'created_by' => 'nullable|exists:users,id',
            'updated_by' => 'nullable|exists:users,id',
            'pengawasan_items' => 'nullable|array',
            'pengawasan_items.*.jenis_pengawasan' => 'nullable|in:RAPID,LAB',
            'pengawasan_items.*.jenis_cemaran' => 'nullable|string|max:255',
            'pengawasan_items.*.metode_pengujian' => 'nullable|string|max:255',
            'pengawasan_items.*.is_positif' => 'nullable|boolean',
            'pengawasan_items.*.jumlah_sampel' => 'nullable|integer|min:1',
            'pengawasan_items.*.keterangan' => 'nullable|string',
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
            'lampiran1.file' => 'Lampiran 1 must be a valid file.',
            'lampiran1.mimes' => 'Lampiran 1 must be a file of type: pdf, jpeg, jpg, doc, docx, png.',
            'lampiran2.file' => 'Lampiran 2 must be a valid file.',
            'lampiran2.mimes' => 'Lampiran 2 must be a file of type: pdf, jpeg, jpg, doc, docx, png.',
            'lampiran3.file' => 'Lampiran 3 must be a valid file.',
            'lampiran3.mimes' => 'Lampiran 3 must be a file of type: pdf, jpeg, jpg, doc, docx, png.',
            'lampiran4.file' => 'Lampiran 4 must be a valid file.',
            'lampiran4.mimes' => 'Lampiran 4 must be a file of type: pdf, jpeg, jpg, doc, docx, png.',
            'lampiran5.file' => 'Lampiran 5 must be a valid file.',
            'lampiran5.mimes' => 'Lampiran 5 must be a file of type: pdf, jpeg, jpg, doc, docx, png.',
            'lampiran6.file' => 'Lampiran 6 must be a valid file.',
            'lampiran6.mimes' => 'Lampiran 6 must be a file of type: pdf, jpeg, jpg, doc, docx, png.',
            'status.string' => 'The status must be a string.',
            'status.in' => 'The selected status is invalid.',
            'tindakan_rekomendasikan.string' => 'The recommended action must be a string.',
            'is_active.boolean' => 'The active field must be true or false.',
            'created_by.exists' => 'The selected creator is invalid.',
            'updated_by.exists' => 'The selected updater is invalid.',
            'pengawasan_items.array' => 'The pengawasan items must be an array.',
            'pengawasan_items.*.jenis_pengawasan.in' => 'The selected supervision type is invalid.',
            'pengawasan_items.*.jenis_cemaran.string' => 'The contamination type must be a string.',
            'pengawasan_items.*.jenis_cemaran.max' => 'The contamination type may not be greater than 255 characters.',
            'pengawasan_items.*.metode_pengujian.string' => 'The testing method must be a string.',
            'pengawasan_items.*.metode_pengujian.max' => 'The testing method may not be greater than 255 characters.',
            'pengawasan_items.*.is_positif.boolean' => 'The positive status must be true or false.',
            'pengawasan_items.*.jumlah_sampel.integer' => 'The sample quantity must be an integer.',
            'pengawasan_items.*.jumlah_sampel.min' => 'The sample quantity must be at least 1.',
        ];
    }
}

