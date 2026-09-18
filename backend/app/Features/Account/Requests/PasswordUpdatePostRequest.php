<?php

namespace App\Features\Account\Requests;

use App\Http\Enums\Guards;
use App\Http\Requests\InputRequest;
use Illuminate\Validation\Rules\Password as Password;
use Illuminate\Support\Facades\Hash;

class PasswordUpdatePostRequest extends InputRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() : bool
    {
        return auth()->guard(Guards::API->value())->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $user = $this->user();
        return [
            'old_password' => ['required','string', function ($attribute, $value, $fail) use ($user) {
                if (!Hash::check($value, $user->password)) {
                    $fail('The old password entered is incorrect.');
                }
            }],
            'password' => ['required',
                'string',
                Password::min(8)
                        ->letters()
                        ->mixedCase()
                        ->numbers()
                        ->symbols()
            ],
            'confirm_password' => 'string|min:6|required_with:password|same:password',
        ];
    }

}
