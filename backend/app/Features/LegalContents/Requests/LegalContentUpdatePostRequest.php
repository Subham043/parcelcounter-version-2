<?php

namespace App\Features\LegalContents\Requests;


class LegalContentUpdatePostRequest extends LegalContentCreatePostRequest
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
            'slug' => 'required|string|max:255|unique:legal_contents,slug,' . $this->route('id'),
        ]);
    }
}
