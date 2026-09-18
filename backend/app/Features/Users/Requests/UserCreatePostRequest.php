<?php

namespace App\Features\Users\Requests;

use App\Http\Enums\Guards;
use App\Http\Requests\InputRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;


class UserCreatePostRequest extends InputRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Auth::guard(Guards::API->value())->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'nullable|string|email:rfc,dns|max:255|unique:users',
            'phone' => 'required|numeric|digits:10|unique:users',
            'is_blocked' => 'required|boolean',
            'role' => 'required|string|exists:Spatie\Permission\Models\Role,name',
            'confirm_password' => 'string|min:8|required_with:password|same:password',
            'password' => [
                'required',
                'string',
                Password::min(6)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
            ],
        ];
    }
}
