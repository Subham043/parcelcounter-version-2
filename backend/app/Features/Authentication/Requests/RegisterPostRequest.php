<?php

namespace App\Features\Authentication\Requests;

use App\Features\Roles\Enums\Roles;
use App\Http\Requests\InputRequest;
use Illuminate\Validation\Rules\Password as PasswordValidation;
use Illuminate\Validation\Rule;


class RegisterPostRequest extends InputRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
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
            'name' => ['required', 'string'],
            'email' => ['nullable', 'email:rfc,dns', 'unique:users'],
            'phone' => ['required', 'numeric', 'digits:10', 'unique:users'],
            'password' => [
                'required',
                'string',
                PasswordValidation::min(6)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
            ],
            'confirm_password' => ['required_with:password', 'same:password'],
            'role' => ['required', 'string', 'exists:Spatie\Permission\Models\Role,name', Rule::in([
                Roles::User->value,
                Roles::ReferralRockstars->value,
                Roles::RewardRiders->value,
                Roles::AppPromoter->value,
            ]),],
            // 'captcha' => ['required', 'captcha']
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'captcha.captcha' => 'Invalid Captcha. Please try again.',
        ];
    }
}
