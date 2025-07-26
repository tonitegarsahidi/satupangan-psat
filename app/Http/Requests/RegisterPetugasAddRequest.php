<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;

class RegisterPetugasAddRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'jenis_kelamin' => ['required', 'in:male,female'],
            'no_hp' => ['required', 'string', 'max:20'],
            'pekerjaan' => ['required', 'string', 'max:100'],
            'alamat_domisili' => ['required', 'string', 'max:255'],
            'provinsi_id' => ['required', 'exists:master_provinsis,id'],
            'kota_id' => ['required', 'exists:master_kotas,id'],
            'password' => ['required', Rules\Password::defaults()],
            'agree' => 'accepted',
            'unit_kerja' => ['required', 'string', 'max:255'],
            'jabatan' => ['required', 'string', 'max:100'],
            'is_kantor_pusat' => ['required', 'in:0,1'],
            'penempatan' => ['nullable', 'exists:master_provinsis,id'],
        ];
    }

    /**
     * Get custom error messages for validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Nama Lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'jenis_kelamin.required' => 'Jenis Kelamin wajib dipilih.',
            'jenis_kelamin.in' => 'Jenis Kelamin tidak valid.',
            'no_hp.required' => 'No. HP wajib diisi.',
            'pekerjaan.required' => 'Pekerjaan wajib diisi.',
            'alamat_domisili.required' => 'Alamat Domisili wajib diisi.',
            'provinsi_id.required' => 'Provinsi wajib dipilih.',
            'provinsi_id.exists' => 'Provinsi tidak valid.',
            'kota_id.required' => 'Kabupaten/Kota wajib dipilih.',
            'kota_id.exists' => 'Kabupaten/Kota tidak valid.',
            'password.required' => 'Password wajib diisi.',
            'agree.accepted' => 'Anda harus menyetujui syarat dan ketentuan.',
            'unit_kerja.required' => 'Unit Kerja wajib diisi.',
            'jabatan.required' => 'Jabatan wajib diisi.',
            'is_kantor_pusat.required' => 'Tipe Petugas wajib dipilih.',
            'penempatan.exists' => 'Provinsi penempatan tidak valid.',
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // Validate penempatan for petugas daerah
            if ($this->is_kantor_pusat == '0' && empty($this->penempatan)) {
                $validator->errors()->add('penempatan', 'Penempatan wajib dipilih untuk Petugas Daerah.');
            }
        });
    }
}