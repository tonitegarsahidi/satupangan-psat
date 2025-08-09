<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BusinessProfileUpdateRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // Business specific fields only
            'nama_perusahaan' => ['required', 'string', 'max:255'],
            'alamat_perusahaan' => ['nullable', 'string', 'max:255'],
            'jabatan_perusahaan' => ['nullable', 'string', 'max:100'],
            'nib' => ['nullable', 'string', 'max:100'],
            'is_umkm' => ['nullable', 'boolean'],
            'provinsi_id' => ['required', 'exists:master_provinsis,id'],
            'kota_id' => ['required', 'exists:master_kotas,id'],
            'jenispsat_id' => ['required', 'array'],
            'jenispsat_id.*' => ['exists:master_jenis_pangan_segars,id'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Nama lengkap wajib diisi.',
            'name.string' => 'Nama lengkap harus berupa teks.',
            'name.max' => 'Nama lengkap tidak boleh lebih dari 255 karakter.',

            'phone_number.string' => 'Nomor telepon harus berupa teks.',
            'phone_number.max' => 'Nomor telepon tidak boleh lebih dari 20 karakter.',

            'address.string' => 'Alamat harus berupa teks.',
            'address.max' => 'Alamat tidak boleh lebih dari 500 karakter.',

            'provinsi_id.exists' => 'Provinsi yang dipilih tidak valid.',
            'kota_id.exists' => 'Kota yang dipilih tidak valid.',

            'pekerjaan.string' => 'Pekerjaan harus berupa teks.',
            'pekerjaan.max' => 'Pekerjaan tidak boleh lebih dari 100 karakter.',

            'gender.in' => 'Jenis kelamin harus dipilih antara Laki-laki atau Perempuan.',

            'date_of_birth.date' => 'Tanggal lahir harus berupa tanggal yang valid.',

            'profile_picture.image' => 'File harus berupa gambar.',
            'profile_picture.mimes' => 'Gambar harus berformat JPEG, PNG, JPG, atau WEBP.',
            'profile_picture.max' => 'Ukuran gambar tidak boleh lebih dari 5MB.',

            'nama_perusahaan.required' => 'Nama Perusahaan wajib diisi.',
            'nama_perusahaan.string' => 'Nama Perusahaan harus berupa teks.',
            'nama_perusahaan.max' => 'Nama Perusahaan tidak boleh lebih dari 255 karakter.',

            'alamat_perusahaan.string' => 'Alamat Perusahaan harus berupa teks.',
            'alamat_perusahaan.max' => 'Alamat Perusahaan tidak boleh lebih dari 255 karakter.',

            'jabatan_perusahaan.string' => 'Jabatan di Perusahaan harus berupa teks.',
            'jabatan_perusahaan.max' => 'Jabatan di Perusahaan tidak boleh lebih dari 100 karakter.',

            'nib.string' => 'NIB harus berupa teks.',
            'nib.max' => 'NIB tidak boleh lebih dari 100 karakter.',

            'jenispsat_id.required' => 'Jenis PSAT wajib dipilih.',
            'jenispsat_id.array' => 'Jenis PSAT harus berupa array.',
            'jenispsat_id.*.exists' => 'Jenis PSAT yang dipilih tidak valid.',
        ];
    }
}
