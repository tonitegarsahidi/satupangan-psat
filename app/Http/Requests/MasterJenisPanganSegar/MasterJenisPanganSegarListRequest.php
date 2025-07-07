<?php

namespace App\Http\Requests\MasterJenisPanganSegar;

use Illuminate\Foundation\Http\FormRequest;

class MasterJenisPanganSegarListRequest extends FormRequest
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
            "per_page" => "nullable|integer",
            "page" => "nullable|integer",
            "sort_order" => "nullable|string|in:ASC,DESC,asc,desc",
            "sort_field" => "nullable|string|in:NAME,id,nama_jenis_pangan_segar,kode_jenis_pangan_segar,is_active,created_at",
            "keyword" => "nullable|string",
        ];
    }
}
