<?php

namespace App\Features\ProductStocks\Requests;

use App\Http\Enums\Guards;
use App\Http\Requests\InputRequest;
use Illuminate\Support\Facades\Auth;


class ProductStockPostRequest extends InputRequest
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
            'purchase_stock' => 'required|decimal:0,2|gte:1',
            'quantity' => 'required|integer|min:1',
            'purchased_at' => 'required|date',
        ];
    }
}
