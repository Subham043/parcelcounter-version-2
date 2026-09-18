<?php

namespace App\Features\ProductImages\Requests;

use App\Http\Enums\Guards;
use Illuminate\Support\Facades\Auth;


class ProductImageUpdatePostRequest extends ProductImageCreatePostRequest
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
        $parentRules = parent::rules();
        return array_merge($parentRules, [
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);
    }
}
