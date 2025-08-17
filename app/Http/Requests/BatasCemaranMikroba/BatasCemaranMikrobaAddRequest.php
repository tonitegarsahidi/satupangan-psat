<?php

namespace App\Http\Requests\BatasCemaranMikroba;

use Illuminate\Foundation\Http\FormRequest;

class BatasCemaranMikrobaAddRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'jenis_psat' => 'required|exists:master_jenis_pangan_segars,id',
            'cemaran_mikroba' => 'required|exists:master_cemaran_mikrobas,id',
            'value_min' => 'required|numeric',
            'value_max' => 'required|numeric|gt:value_min',
            'satuan' => 'required|string|max:255',
            'metode' => 'required|string|max:255',
            'keterangan' => 'nullable|string|max:255',
            'is_active' => 'required|boolean',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'jenis_psat.required' => 'Jenis Pangan is required.',
            'jenis_psat.exists' => 'Selected Jenis Pangan does not exist.',
            'cemaran_mikroba.required' => 'Cemaran Mikroba is required.',
            'cemaran_mikroba.exists' => 'Selected Cemaran Mikroba does not exist.',
            'value_min.required' => 'Minimum value is required.',
            'value_min.numeric' => 'Minimum value must be a number.',
            'value_max.required' => 'Maximum value is required.',
            'value_max.numeric' => 'Maximum value must be a number.',
            'value_max.gt' => 'Maximum value must be greater than minimum value.',
            'satuan.required' => 'Satuan is required.',
            'metode.required' => 'Metode is required.',
            'is_active.required' => 'Status is required.',
            'is_active.boolean' => 'Status must be true or false.',
        ];
    }
}
