<?php

namespace App\Http\Requests\RegisterSppb;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterSppbEditRequest extends FormRequest
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
        $registerSppbId = $this->route('id'); // Assuming the route parameter is 'id'

        return [
            'business_id' => 'required|uuid|exists:business,id',
            'status' => 'required|string|max:50',
            'is_enabled' => 'required|boolean',
            'nomor_registrasi' => [
                'nullable',
                'string',
                'max:50',
                Rule::unique('register_sppb', 'nomor_registrasi')->ignore($registerSppbId),
            ],
            'tanggal_terbit' => 'nullable|date',
            'tanggal_terakhir' => 'nullable|date',
            'is_unitusaha' => 'required|boolean',
            'nama_unitusaha' => 'nullable|string|max:100',
            'alamat_unitusaha' => 'nullable|string|max:100',
            'provinsi_unitusaha' => 'nullable|uuid|exists:master_provinsis,id',
            'kota_unitusaha' => 'nullable|uuid|exists:master_kotas,id',
            'nib_unitusaha' => 'nullable|string|max:100',
            'jenispsat_id' => 'required|array',
            'jenispsat_id.*' => 'exists:master_jenis_pangan_segars,id',
            'nama_komoditas' => 'nullable|string|max:50',
        ];
    }
}
