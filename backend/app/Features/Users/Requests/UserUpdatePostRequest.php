<?php

namespace App\Features\Users\Requests;

use Illuminate\Validation\Rules\Password;


class UserUpdatePostRequest extends UserCreatePostRequest
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
            'email' => 'nullable|string|email:rfc,dns|max:255|unique:users,email,' . $this->route('id'),
            'phone' => 'required|numeric|digits:10|unique:users,phone,' . $this->route('id'),
            'password' => [
                'nullable',
                'string',
                Password::min(6)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
            ],
            'confirm_password' => 'string|min:8|required_with:password|same:password',
        ]);
    }
}
