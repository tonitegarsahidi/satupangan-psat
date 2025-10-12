<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleAddRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:articles',
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'category' => 'required|in:pembinaan,berita',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:20480',
            'status' => 'required|in:draft,published',
            'published_at' => 'nullable|date',
            'is_featured' => 'nullable|boolean',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'The article title is required.',
            'title.string' => 'The article title must be a string.',
            'title.max' => 'The article title may not be greater than 255 characters.',
            'slug.string' => 'The slug must be a string.',
            'slug.max' => 'The slug may not be greater than 255 characters.',
            'slug.unique' => 'This slug has already been taken.',
            'content.required' => 'The article content is required.',
            'content.string' => 'The article content must be a string.',
            'excerpt.string' => 'The excerpt must be a string.',
            'excerpt.max' => 'The excerpt may not be greater than 500 characters.',
            'category.required' => 'Please select an article category.',
            'category.in' => 'The category must be either pembinaan or berita.',
            'featured_image.image' => 'The featured image must be an image file.',
            'featured_image.mimes' => 'The featured image must be a file of type: jpeg, png, jpg, gif.',
            'featured_image.max' => 'The featured image may not be greater than 20MB.',
            'status.required' => 'Please select the article status.',
            'status.in' => 'The status must be either draft or published.',
            'published_at.date' => 'The published date must be a valid date.',
            'is_featured.boolean' => 'The featured field must be true or false.',
        ];
    }
}
