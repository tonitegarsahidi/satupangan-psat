<?php

namespace App\Http\Requests\RegisterSppb;

use Illuminate\Foundation\Http\FormRequest;

class RegisterSppbAddRequest extends FormRequest
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
            'business_id' => 'required|uuid|exists:business,id',
            'nomor_registrasi' => 'nullable|string|max:50|unique:register_sppb,nomor_registrasi',
            'nama_unitusaha' => 'nullable|string|max:100',
            'alamat_unitusaha' => 'nullable|string|max:100',
            'provinsi_unitusaha' => 'nullable|uuid|exists:master_provinsis,id',
            'kota_unitusaha' => 'nullable|uuid|exists:master_kotas,id',
            'nib_unitusaha' => 'nullable|string|max:100',
            'jenispsat_id' => 'required|array',
            'jenispsat_id.*' => 'exists:master_jenis_pangan_segars,id',
            'nama_komoditas' => 'nullable|string|max:50',
            'ruang_lingkup_penanganan' => 'required|uuid|exists:master_penanganan,id',
            'tanggal_terbit' => 'nullable|date',
            'tanggal_terakhir' => 'nullable|date',
            'penanganan_keterangan' => 'string|nullable', // Will be replaced dynamically
            'alamat_unit_penanganan' => 'nullable|string|max:100',
        ];
    }

    public function withValidator($validator)
    {
        $validator->sometimes('penanganan_keterangan', 'required|string|max:255', function ($input) {
            // This is a workaround since we can't easily get the ID here
            // In practice, you might fetch it once and cache it
            return $input->ruang_lingkup_penanganan === $this->getPengolahanLainnyaId();
        });
    }

    private function getPengolahanLainnyaId(): string
    {
        // Placeholder - in reality, fetch from DB or config
        return 'placeholder-uuid-1234-5678';
    }
}
