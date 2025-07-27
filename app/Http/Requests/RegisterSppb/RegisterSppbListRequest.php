<?php

namespace App\Http\Requests\RegisterSppb;

use Illuminate\Foundation\Http\FormRequest;

class RegisterSppbListRequest extends FormRequest
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
            'per_page' => 'nullable|integer|min:1',
            'page' => 'nullable|integer|min:1',
            'sort_field' => 'nullable|string|in:id,business_id,status,is_enabled,nomor_registrasi,tanggal_terbit,tanggal_terakhir,is_unitusaha,nama_unitusaha,alamat_unitusaha,provinsi_unitusaha,kota_unitusaha,nib_unitusaha,created_at,updated_at',
            'sort_order' => 'nullable|string|in:asc,desc',
            'keyword' => 'nullable|string',
        ];
    }
}
