<?php

namespace App\Http\Requests\MasterKota;

use Illuminate\Foundation\Http\FormRequest;

class MasterKotaListRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "per_page" => "nullable|integer",
            "page" => "nullable|integer",
            "sort_order" => "nullable|string|in:ASC,DESC,asc,desc",
            "sort_field" => "nullable|string|in:id,provinsi_id,kode_kota,nama_kota,is_active,created_at",
            "keyword" => "nullable|string",
        ];
    }
}
