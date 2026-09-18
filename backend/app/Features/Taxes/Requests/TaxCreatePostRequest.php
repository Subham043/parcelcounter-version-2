<?php

namespace App\Features\Taxes\Requests;

use App\Http\Enums\Guards;
use App\Http\Requests\InputRequest;
use Illuminate\Support\Facades\Auth;


class TaxCreatePostRequest extends InputRequest
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
            'slug' => 'required|string|max:255|unique:taxes',
            'value' => [
                'required',
                'decimal:0,2',
                'gte:0',
                'lte:100'
            ],
            'is_inter_state_tax' => 'required|boolean',
            'is_active' => 'required|boolean',
        ];
    }
}
