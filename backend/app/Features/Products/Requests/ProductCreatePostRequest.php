<?php

namespace App\Features\Products\Requests;

use App\Http\Enums\Guards;
use App\Http\Requests\InputRequest;
use Illuminate\Support\Facades\Auth;


class ProductCreatePostRequest extends InputRequest
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
            'slug' => 'required|string|max:255|unique:products',
            'hsn' => 'nullable|string|max:255',
            'description' => 'required|string',
            'description_unfiltered' => 'required|string',
            'brief_description' => 'required|string|max:500',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_active' => 'required|boolean',
            'is_new' => 'required|boolean',
            'is_on_sale' => 'required|boolean',
            'is_featured' => 'required|boolean',
            'min_cart_quantity' => 'required|integer|min:1',
            'cart_quantity_interval' => 'required|integer|min:1',
            'cart_quantity_specification' => 'required|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string',
            'category' => 'required|array|min:1',
            'category.*' => 'required|numeric|exists:categories,id',
            'sub_category' => 'required|array|min:1',
            'sub_category.*' => 'required|numeric|exists:sub_categories,id',
            'tax' => 'required|array|min:1',
            'tax.*' => 'required|numeric|exists:taxes,id',
            'specifications' => 'required|array|min:1',
            'specifications.*.title' => 'required|string|max:255',
            'specifications.*.description' => 'required|string',
            'prices' => 'required|array|min:1',
            'prices.*.min_quantity' => 'required|decimal:0,2|gte:1',
            'prices.*.price' => 'required|integer|min:1',
            'stocks' => 'required|array|min:1',
            'stocks.*.purchase_stock' => 'required|decimal:0,2|gte:1',
            'stocks.*.quantity' => 'required|integer|min:1',
            'stocks.*.purchased_at' => 'required|date_format:Y-m-d',
            'colors' => 'nullable|array',
            'colors.*.name' => 'required|string|max:255',
            'colors.*.code' => 'required|string|max:255',
            'videos' => 'nullable|array',
            'videos.*.video' => 'required|url|max:255',
        ];
    }
}
