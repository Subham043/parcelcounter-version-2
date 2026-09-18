<?php

namespace App\Features\Account\Requests;

use App\Http\Enums\Guards;
use App\Http\Requests\InputRequest;

class ProfileUpdatePostRequest extends InputRequest
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
        return [
            'name' => ['required', 'string'],
            'email' => ['required','email:rfc,dns','unique:users,email,'.auth()->guard(Guards::API->value())->id()],
            'phone' => ['nullable','numeric', 'digits:10', 'unique:users,phone,'.auth()->guard(Guards::API->value())->id()],
        ];
    }

}
