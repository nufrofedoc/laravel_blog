<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogPostCreateRequest extends FormRequest
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
            'title'        => 'required|min:5|max:200|unique:blog_posts',
            'slug'         => 'max:200',
            'content_raw'  => 'required|string|min:5|max:10000',
            'category_id'  => 'required|integer|exists:blog_categories,id',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @param array
     */
    public function message()
    {
        return [
            'title.required'  => 'Input :attribute of article',
            'content_raw.min' => 'Min length of article [:min] char',
        ];
    }

    /**
     * Get custom attributes for variables errors.
     *
     * @param array
     */
    public function attributes()
    {
        return [
            'title' => 'Heading',
        ];
    }
}
