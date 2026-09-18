<?php

namespace App\Features\Charges\Requests;


class ChargeUpdatePostRequest extends ChargeCreatePostRequest
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
            'slug' => 'required|string|max:255|unique:charges,slug,' . $this->route('id'),
        ]);
    }
}
