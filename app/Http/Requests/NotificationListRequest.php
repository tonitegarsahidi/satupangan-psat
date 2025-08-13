<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NotificationListRequest extends FormRequest
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
            'page' => 'sometimes|integer|min:1',
            'per_page' => 'sometimes|integer|min:1|max:100',
            'sort_field' => 'sometimes|string|in:id,type,title,message,is_read,created_at,updated_at',
            'sort_order' => 'sometimes|string|in:asc,desc',
            'keyword' => 'sometimes|string|max:255',
            'unreadOnly' => 'sometimes|boolean',
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
            'page.integer' => 'Page must be an integer.',
            'page.min' => 'Page must be at least 1.',
            'per_page.integer' => 'Per page must be an integer.',
            'per_page.min' => 'Per page must be at least 1.',
            'per_page.max' => 'Per page must not be greater than 100.',
            'sort_field.string' => 'Sort field must be a string.',
            'sort_field.in' => 'Invalid sort field.',
            'sort_order.string' => 'Sort order must be a string.',
            'sort_order.in' => 'Sort order must be either asc or desc.',
            'keyword.string' => 'Keyword must be a string.',
            'keyword.max' => 'Keyword must not be greater than 255 characters.',
            'unreadOnly.boolean' => 'Unread only must be a boolean.',
        ];
    }
}
