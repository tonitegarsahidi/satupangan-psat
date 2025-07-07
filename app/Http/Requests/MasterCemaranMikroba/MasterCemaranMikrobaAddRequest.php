<?php

namespace App\Http\Requests\MasterCemaranMikroba;

use Illuminate\Foundation\Http\FormRequest;

class MasterCemaranMikrobaAddRequest extends FormRequest
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
            'kode_cemaran_mikroba' => 'nullable|string|max:12',
            'nama_cemaran_mikroba' => 'required|string|max:255',
            'keterangan' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ];
    }
}
