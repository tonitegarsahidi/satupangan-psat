<?php

namespace App\Http\Requests\MasterCemaranPestisida;

use Illuminate\Foundation\Http\FormRequest;

class MasterCemaranPestisidaAddRequest extends FormRequest
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
            'kode_cemaran_pestisida' => 'nullable|string|max:12',
            'nama_cemaran_pestisida' => 'required|string|max:100',
            'keterangan' => 'nullable|string',
            'is_active' => 'boolean',
        ];
    }
}
