<?php

namespace App\Features\Testimonials\Requests;


class TestimonialUpdatePostRequest extends TestimonialCreatePostRequest
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
        ]);
    }
}
