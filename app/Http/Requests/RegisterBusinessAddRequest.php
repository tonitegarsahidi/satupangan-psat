<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;

class RegisterBusinessAddRequest extends FormRequest
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
            'alamat_domisili' => ['required', 'string', 'max:255'],
            'provinsi_id' => ['required', 'exists:master_provinsis,id'],
            'kota_id' => ['required', 'exists:master_kotas,id'],
            'password' => ['required', Rules\Password::defaults()],
            'agree' => 'accepted',
            'nama_perusahaan' => ['required', 'string', 'max:255'],
            'alamat_perusahaan' => ['nullable', 'string', 'max:255'],
            'jabatan_perusahaan' => ['nullable', 'string', 'max:100'],
            'nib' => ['nullable', 'string', 'max:100'],
            'jenispsat_id' => ['required', 'array'],
            'jenispsat_id.*' => ['exists:master_jenis_pangan_segars,id'],
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
            'alamat_domisili.required' => 'Alamat Domisili wajib diisi.',
            'provinsi_id.required' => 'Provinsi wajib dipilih.',
            'provinsi_id.exists' => 'Provinsi tidak valid.',
            'kota_id.required' => 'Kabupaten/Kota wajib dipilih.',
            'kota_id.exists' => 'Kabupaten/Kota tidak valid.',
            'password.required' => 'Password wajib diisi.',
            'agree.accepted' => 'Anda harus menyetujui syarat dan ketentuan.',
            'nama_perusahaan.required' => 'Nama Perusahaan wajib diisi.',
            'jenispsat_id.required' => 'Jenis Pangan Segar wajib dipilih.',
            'jenispsat_id.array' => 'Jenis Pangan Segar harus berupa array.',
            'jenispsat_id.*.exists' => 'Jenis Pangan Segar yang dipilih tidak valid.',
        ];
    }
}