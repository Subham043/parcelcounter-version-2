<?php

namespace App\Features\Products\Requests;

use App\Http\Enums\Guards;
use App\Http\Requests\InputRequest;
use Illuminate\Support\Facades\Auth;


class ProductFilterRequest extends InputRequest
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

            'include-category' => 'nullable|string|in:yes,no',

            'include-sub-category' => 'nullable|string|in:yes,no',
            
            'include-tax' => 'nullable|string|in:yes,no',
            
            'include-specification' => 'nullable|string|in:yes,no',
            
            'include-image' => 'nullable|string|in:yes,no',
            
            'include-video' => 'nullable|string|in:yes,no',
            
            'include-color' => 'nullable|string|in:yes,no',
            
            'include-price' => 'nullable|string|in:yes,no',
            
            'include-review' => 'nullable|string|in:yes,no',
            
            'include-stock' => 'nullable|string|in:yes,no',
            
            'include-latest-stock' => 'nullable|string|in:yes,no',
            
            'is-select' => 'nullable|string|in:yes,no',
            
            'filter' => 'nullable|array:search,is_active,category,sub_category',

            'filter.search' => 'nullable|string|max:255',

            'filter.is_active' => 'nullable|string|in:yes,no',

            'filter.is_new' => 'nullable|string|in:yes,no',
            
            'filter.is_on_sale' => 'nullable|string|in:yes,no',
            
            'filter.is_featured' => 'nullable|string|in:yes,no',
            
            'filter.category' => 'nullable|integer|gt:0',

            'filter.sub_category' => 'nullable|integer|gt:0',
        ];
    }
}
