<?php

namespace App\Http\Requests\Pengawasan;

use Illuminate\Foundation\Http\FormRequest;

class PengawasanTindakanLanjutanListRequest extends FormRequest
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
            'id' => 'sometimes|exists:pengawasan_tindakan_lanjutan,id',
            'page' => 'sometimes|integer|min:1',
            'per_page' => 'sometimes|integer|min:1|max:100',
            'sort_field' => 'sometimes|string|in:id,pengawasan_tindakan_id,user_id_pic,tindak_lanjut,status,created_at,updated_at',
            'sort_order' => 'sometimes|string|in:asc,desc',
            'keyword' => 'sometimes|string|max:255',
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
            'id.exists' => 'Selected Pengawasan Tindakan Lanjutan does not exist',
            'page.integer' => 'Page must be an integer',
            'page.min' => 'Page must be at least 1',
            'per_page.integer' => 'Per page must be an integer',
            'per_page.min' => 'Per page must be at least 1',
            'per_page.max' => 'Per page may not be greater than 100',
            'sort_field.string' => 'Sort field must be a string',
            'sort_field.in' => 'Sort field must be one of: id, pengawasan_tindakan_id, user_id_pic, tindak_lanjut, status, created_at, updated_at',
            'sort_order.string' => 'Sort order must be a string',
            'sort_order.in' => 'Sort order must be one of: asc, desc',
            'keyword.string' => 'Keyword must be a string',
            'keyword.max' => 'Keyword may not be greater than 255 characters',
        ];
    }
}
