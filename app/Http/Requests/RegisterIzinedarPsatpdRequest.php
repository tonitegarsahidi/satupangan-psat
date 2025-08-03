<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterIzinedarPsatpdRequest extends FormRequest
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
            'nomor_sppb' => 'nullable|string|max:50',
            'nomor_izinedar_pl' => 'nullable|string|max:50',
            'nama_unitusaha' => 'nullable|string|max:200',
            'alamat_unitusaha' => 'nullable|string|max:200',
            'alamat_unitpenanganan' => 'nullable|string|max:200',
            'provinsi_unitusaha' => 'nullable|uuid|exists:master_provinsis,id',
            'kota_unitusaha' => 'nullable|uuid|exists:master_kotas,id',
            'nib_unitusaha' => 'nullable|string|max:200',
            'jenis_psat' => 'nullable|uuid|exists:master_jenis_pangan_segars,id',
            'nama_komoditas' => 'nullable|string|max:200',
            'nama_latin' => 'nullable|string|max:200',
            'negara_asal' => 'nullable|string|max:200',
            'merk_dagang' => 'nullable|string|max:200',
            'jenis_kemasan' => 'nullable|string|max:200',
            'ukuran_berat' => 'nullable|string|max:200',
            'klaim' => 'nullable|string|max:200',
            'foto_1' => 'nullable|file|image|mimes:jpeg,jpg,png,gif',
            'foto_2' => 'nullable|file|image|mimes:jpeg,jpg,png,gif',
            'foto_3' => 'nullable|file|image|mimes:jpeg,jpg,png,gif',
            'foto_4' => 'nullable|file|image|mimes:jpeg,jpg,png,gif',
            'foto_5' => 'nullable|file|image|mimes:jpeg,jpg,png,gif',
            'foto_6' => 'nullable|file|image|mimes:jpeg,jpg,png,gif',
            'file_nib' => 'nullable|file|mimes:pdf,jpeg,jpg,doc,docx,png',
            'file_sppb' => 'nullable|file|mimes:pdf,jpeg,jpg,doc,docx,png',
            'file_izinedar_psatpd' => 'nullable|file|mimes:pdf,jpeg,jpg,doc,docx,png',
            'okkp_penangungjawab' => 'nullable|uuid|exists:users,id',
            'tanggal_terbit' => 'nullable|date',
            'tanggal_terakhir' => 'nullable|date',
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
            'nomor_sppb.max' => 'Nomor SPPB maksimal 50 karakter',
            'nomor_izinedar_pl.max' => 'Nomor Izin EDAR PL maksimal 50 karakter',
            'nama_unitusaha.max' => 'Nama unit usaha maksimal 200 karakter',
            'alamat_unitusaha.max' => 'Alamat unit usaha maksimal 200 karakter',
            'alamat_unitpenanganan.max' => 'Alamat unit penanganan maksimal 200 karakter',
            'provinsi_unitusaha.exists' => 'Provinsi tidak ditemukan',
            'kota_unitusaha.exists' => 'Kota tidak ditemukan',
            'nib_unitusaha.max' => 'NIB unit usaha maksimal 200 karakter',
            'jenis_psat.exists' => 'Jenis PSAT tidak ditemukan',
            'nama_komoditas.max' => 'Nama komoditas maksimal 200 karakter',
            'nama_latin.max' => 'Nama latin maksimal 200 karakter',
            'negara_asal.max' => 'Negara asal maksimal 200 karakter',
            'merk_dagang.max' => 'Merk dagang maksimal 200 karakter',
            'jenis_kemasan.max' => 'Jenis kemasan maksimal 200 karakter',
            'ukuran_berat.max' => 'Ukuran berat maksimal 200 karakter',
            'klaim.max' => 'Klaim maksimal 200 karakter',
            'foto_1.image' => 'Foto 1 harus berupa gambar',
            'foto_1.mimes' => 'Foto 1 harus berformat jpeg, jpg, png, atau gif',
            'foto_2.image' => 'Foto 2 harus berupa gambar',
            'foto_2.mimes' => 'Foto 2 harus berformat jpeg, jpg, png, atau gif',
            'foto_3.image' => 'Foto 3 harus berupa gambar',
            'foto_3.mimes' => 'Foto 3 harus berformat jpeg, jpg, png, atau gif',
            'foto_4.image' => 'Foto 4 harus berupa gambar',
            'foto_4.mimes' => 'Foto 4 harus berformat jpeg, jpg, png, atau gif',
            'foto_5.image' => 'Foto 5 harus berupa gambar',
            'foto_5.mimes' => 'Foto 5 harus berformat jpeg, jpg, png, atau gif',
            'foto_6.image' => 'Foto 6 harus berupa gambar',
            'foto_6.mimes' => 'Foto 6 harus berformat jpeg, jpg, png, atau gif',
            'file_nib.mimes' => 'File NIB harus berformat PDF, JPEG, JPG, DOC, DOCX, atau PNG',
            'file_sppb.mimes' => 'File SPPB harus berformat PDF, JPEG, JPG, DOC, DOCX, atau PNG',
            'file_izinedar_psatpd.mimes' => 'File Izin EDAR PSATPD harus berformat PDF, JPEG, JPG, DOC, DOCX, atau PNG',
            'okkp_penangungjawab.exists' => 'OKKP penanggung jawab tidak ditemukan',
            'tanggal_terbit.date' => 'Format tanggal terbit tidak valid',
            'tanggal_terakhir.date' => 'Format tanggal terakhir tidak valid',
        ];
    }
}
