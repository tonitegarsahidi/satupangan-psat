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
            'lokasi_kota_id' => 'required|exists:master_kotas,id',
            'lokasi_provinsi_id' => 'required|exists:master_provinsis,id',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'jenis_psat_id' => 'required|exists:master_jenis_pangan_segars,id',
            'produk_psat_id' => 'required|exists:master_bahan_pangan_segars,id',
            'hasil_pengawasan' => 'required|string',
            'lampiran1' => 'nullable|file',
            'lampiran2' => 'nullable|file',
            'lampiran3' => 'nullable|file',
            'lampiran4' => 'nullable|file',
            'lampiran5' => 'nullable|file',
            'lampiran6' => 'nullable|file|mimes:pdf,jpeg,jpg,doc,docx,png',
            'status' => 'required|string|in:DRAFT,PROSES,SELESAI',
            'tindakan_rekomendasikan' => 'nullable|string',
            'created_by' => 'nullable|exists:users,id',
            'updated_by' => 'nullable|exists:users,id',
            'pengawasan_items' => 'nullable|array',
            'pengawasan_items.*.type' => 'nullable|in:rapid,lab',
            'pengawasan_items.*.jumlah_sampel' => 'nullable|integer|min:1',
            'pengawasan_items.*.test_name' => 'nullable|string|max:255',
            'pengawasan_items.*.test_parameter' => 'nullable|string|max:255',
            'pengawasan_items.*.is_positif' => 'nullable|boolean',
            'pengawasan_items.*.value_numeric' => 'nullable|numeric',
            'pengawasan_items.*.value_unit' => 'nullable|string|max:255',
            'pengawasan_items.*.is_memenuhisyarat' => 'nullable|boolean',
            'pengawasan_items.*.keterangan' => 'nullable|string',
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
            'status.required' => 'The status field is required.',
            'status.string' => 'The status must be a string.',
            'status.in' => 'The selected status is invalid.',
            'tindakan_rekomendasikan.string' => 'The recommended action must be a string.',
            'is_active.required' => 'The active field is required.',
            'is_active.boolean' => 'The active field must be true or false.',
            'created_by.exists' => 'The selected creator is invalid.',
            'updated_by.exists' => 'The selected updater is invalid.',
            'pengawasan_items.array' => 'The pengawasan items must be an array.',
            'pengawasan_items.*.type.in' => 'The selected supervision type is invalid.',
            'pengawasan_items.*.jumlah_sampel.integer' => 'The sample quantity must be an integer.',
            'pengawasan_items.*.jumlah_sampel.min' => 'The sample quantity must be at least 1.',
            'pengawasan_items.*.test_name.string' => 'The test name must be a string.',
            'pengawasan_items.*.test_name.max' => 'The test name may not be greater than 255 characters.',
            'pengawasan_items.*.is_positif.boolean' => 'The positive status must be true or false.',
            'pengawasan_items.*.value_numeric.numeric' => 'The numeric value must be a number.',
            'pengawasan_items.*.value_unit.string' => 'The unit must be a string.',
            'pengawasan_items.*.value_unit.max' => 'The unit may not be greater than 255 characters.',
            'pengawasan_items.*.is_memenuhisyarat.boolean' => 'The "memenuhi syarat" status must be true or false.',
        ];
    }
}
