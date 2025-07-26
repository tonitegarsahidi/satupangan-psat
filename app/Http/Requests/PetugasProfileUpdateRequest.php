<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class PetugasProfileUpdateRequest extends FormRequest
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
            // Work contact information
            'phone_number' => ['nullable', 'string', 'max:20'],
            'pekerjaan' => ['nullable', 'string', 'max:100'],
            
            // Petugas specific fields
            'unit_kerja' => ['required', 'string', 'max:255'],
            'jabatan' => ['required', 'string', 'max:100'],
            'is_kantor_pusat' => ['required', 'in:0,1'],
            'penempatan' => ['nullable', 'exists:master_provinsis,id'],
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
            'phone_number.string' => 'Nomor telepon harus berupa teks.',
            'phone_number.max' => 'Nomor telepon tidak boleh lebih dari 20 karakter.',
            
            'pekerjaan.string' => 'Pekerjaan harus berupa teks.',
            'pekerjaan.max' => 'Pekerjaan tidak boleh lebih dari 100 karakter.',
            
            'unit_kerja.required' => 'Unit Kerja wajib diisi.',
            'unit_kerja.string' => 'Unit Kerja harus berupa teks.',
            'unit_kerja.max' => 'Unit Kerja tidak boleh lebih dari 255 karakter.',
            
            'jabatan.required' => 'Jabatan wajib diisi.',
            'jabatan.string' => 'Jabatan harus berupa teks.',
            'jabatan.max' => 'Jabatan tidak boleh lebih dari 100 karakter.',
            
            'is_kantor_pusat.required' => 'Tipe Petugas wajib dipilih.',
            'is_kantor_pusat.in' => 'Tipe Petugas harus dipilih antara Pusat atau Daerah.',
            
            'penempatan.exists' => 'Provinsi penempatan tidak valid.',
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            // Validate penempatan for petugas daerah
            if ($this->is_kantor_pusat == '0' && empty($this->penempatan)) {
                $validator->errors()->add('penempatan', 'Penempatan wajib dipilih untuk Petugas Daerah.');
            }
        });
    }
}