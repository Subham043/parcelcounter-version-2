<?php

namespace App\Features\SubCategories\Requests;


class SubCategoryUpdatePostRequest extends SubCategoryCreatePostRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $parentRules = parent::rules();
        return array_merge($parentRules, [
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'slug' => 'required|string|max:255|unique:sub_categories,slug,' . $this->route('id'),
        ]);
    }
}
