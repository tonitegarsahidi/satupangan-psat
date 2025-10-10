<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleListRequest extends FormRequest
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
            'id' => 'nullable|integer|exists:articles,id',
            'keyword' => 'nullable|string|max:255',
            'category' => 'nullable|in:pembinaan,berita',
            'status' => 'nullable|in:draft,published',
            'sort_field' => 'nullable|in:' . implode(',', \App\Models\Article::getModel()->sortable ?? ['id', 'title', 'category', 'status', 'published_at', 'created_at']),
            'sort_order' => 'nullable|in:asc,desc',
            'per_page' => 'nullable|integer|min:1|max:100',
            'page' => 'nullable|integer|min:1',
        ];
    }

    public function messages()
    {
        return [
            'id.integer' => 'The article ID must be an integer.',
            'id.exists' => 'The selected article does not exist.',
            'keyword.string' => 'The keyword must be a string.',
            'keyword.max' => 'The keyword may not be greater than 255 characters.',
            'category.in' => 'The category must be either pembinaan or berita.',
            'status.in' => 'The status must be either draft or published.',
            'sort_field.in' => 'The sort field is not valid.',
            'sort_order.in' => 'The sort order must be either asc or desc.',
            'per_page.integer' => 'The per page value must be an integer.',
            'per_page.min' => 'The per page value must be at least 1.',
            'per_page.max' => 'The per page value may not be greater than 100.',
            'page.integer' => 'The page value must be an integer.',
            'page.min' => 'The page value must be at least 1.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Set default values if not provided
        if (!$this->has('sort_field')) {
            $this->merge(['sort_field' => 'id']);
        }

        if (!$this->has('sort_order')) {
            $this->merge(['sort_order' => 'desc']);
        }

        if (!$this->has('per_page')) {
            $this->merge(['per_page' => config('constant.CRUD.PER_PAGE', 15)]);
        }

        if (!$this->has('page')) {
            $this->merge(['page' => 1]);
        }
    }
}
