<?php

namespace App\Features\Charges\Requests;

use App\Http\Enums\Guards;
use App\Http\Requests\InputRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;


class ChargeCreatePostRequest extends InputRequest
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
            'slug' => 'required|string|max:255|unique:charges',
            'is_percentage' => 'required|boolean',
            'value' => [
                'required',
                'decimal:0,2',
                'gte:0',
                Rule::when(
                    $this->boolean('is_percentage'),
                    ['max:100']
                ),
            ],
            'include_charges_for_cart_price_below' => 'nullable|decimal:0,2',
            'is_active' => 'required|boolean',
        ];
    }
}
