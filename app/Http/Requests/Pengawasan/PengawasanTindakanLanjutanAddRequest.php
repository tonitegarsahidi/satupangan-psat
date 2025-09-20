<?php

namespace App\Http\Requests\Pengawasan;

use Illuminate\Foundation\Http\FormRequest;

class PengawasanTindakanLanjutanAddRequest extends FormRequest
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
            'pengawasan_tindakan_id' => 'required|exists:pengawasan_tindakan,id',
            'user_id_pic' => 'required|exists:users,id',
            'tindak_lanjut' => 'required|string|max:255',
            'status' => 'required|string|max:50',
            'is_active' => 'sometimes|boolean',
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
            'pengawasan_tindakan_id.required' => 'Pengawasan Tindakan ID is required',
            'pengawasan_tindakan_id.exists' => 'Selected Pengawasan Tindakan does not exist',
            'user_id_pic.required' => 'PIC User ID is required',
            'user_id_pic.exists' => 'Selected PIC User does not exist',
            'tindak_lanjut.required' => 'Tindak Lanjut is required',
            'tindak_lanjut.string' => 'Tindak Lanjut must be a string',
            'tindak_lanjut.max' => 'Tindak Lanjut may not be greater than 255 characters',
            'status.required' => 'Status is required',
            'status.string' => 'Status must be a string',
            'status.max' => 'Status may not be greater than 50 characters',
            'is_active.boolean' => 'Is Active must be a boolean',
        ];
    }
}
