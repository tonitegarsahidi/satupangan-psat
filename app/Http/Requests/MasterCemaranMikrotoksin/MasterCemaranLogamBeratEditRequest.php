<?php

namespace App\Http\Requests\MasterCemaranLogamBerat;

use Illuminate\Foundation\Http\FormRequest;

class MasterCemaranLogamBeratEditRequest extends FormRequest
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
            'nama_cemaran_logam_berat' => 'required|string|max:255|unique:master_cemaran_logam_berats,nama_cemaran_logam_berat,' . $this->route('id') . ',id',
            'kode_cemaran_logam_berat' => 'nullable|string|max:12',
            'keterangan' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ];
    }
}
