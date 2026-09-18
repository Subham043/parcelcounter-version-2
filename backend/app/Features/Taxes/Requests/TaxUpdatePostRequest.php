<?php

namespace App\Features\Taxes\Requests;


class TaxUpdatePostRequest extends TaxCreatePostRequest
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
            'slug' => 'required|string|max:255|unique:taxes,slug,' . $this->route('id'),
        ]);
    }
}
