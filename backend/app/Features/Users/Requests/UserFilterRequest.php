<?php

namespace App\Features\Users\Requests;

use App\Http\Enums\Guards;
use App\Http\Requests\InputRequest;
use Illuminate\Support\Facades\Auth;


class UserFilterRequest extends InputRequest
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
            'total' => 'nullable|integer|gt:0',

            'sort' => 'nullable|string|in:id,-id,name,-name',
            
            'filter' => 'nullable|array:search,is_blocked,is_verified,role',

            'filter.search' => 'nullable|string|max:255',

            'filter.is_blocked' => 'nullable|string|in:yes,no',

            'filter.is_verified' => 'nullable|string|in:yes,no',
            
            'filter.role' => 'nullable|string|max:255',
        ];
    }
}
