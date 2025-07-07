<?php

namespace App\Http\Requests\MasterCemaranPestisida;

use Illuminate\Foundation\Http\FormRequest;

class MasterCemaranPestisidaEditRequest extends FormRequest
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
            'nama_cemaran_pestisida' => 'required|string|max:100|unique:master_cemaran_pestisidas,nama_cemaran_pestisida,' . $this->route('id') . ',id',
            'kode_cemaran_pestisida' => 'nullable|string|max:12',
            'keterangan' => 'nullable|string',
            'is_active' => 'boolean',
        ];
    }
}
