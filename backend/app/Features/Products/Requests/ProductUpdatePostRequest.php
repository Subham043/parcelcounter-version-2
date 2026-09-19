<?php

namespace App\Features\Products\Requests;


class ProductUpdatePostRequest extends ProductCreatePostRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $parentRules = parent::rules();
        return array_merge($parentRules, [
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'slug' => 'required|string|max:255|unique:products,slug,' . $this->route('id'),
            'specifications' => 'required|array|min:1',
            'specifications.*.id' => 'nullable|numeric|exists:product_specifications,id',
            'specifications.*.title' => 'required|string|max:255',
            'specifications.*.description' => 'required|string',
            'prices' => 'required|array|min:1',
            'prices.*.id' => 'nullable|numeric|exists:product_prices,id',
            'prices.*.min_quantity' => 'required|decimal:0,2|gte:1',
            'prices.*.price' => 'required|integer|min:1',
            'stocks' => 'required|array|min:1',
            'stocks.*.id' => 'nullable|numeric|exists:product_stocks,id',
            'stocks.*.purchase_stock' => 'required|decimal:0,2|gte:1',
            'stocks.*.quantity' => 'required|integer|min:1',
            'stocks.*.purchased_at' => 'required|date_format:Y-m-d',
            'colors' => 'nullable|array',
            'colors.*.id' => 'nullable|numeric|exists:product_colors,id',
            'colors.*.name' => 'required|string|max:255',
            'colors.*.code' => 'required|string|max:255',
            'videos' => 'nullable|array',
            'videos.*.id' => 'nullable|numeric|exists:product_videos,id',
            'videos.*.video' => 'required|url|max:255',
        ]);
    }
}
