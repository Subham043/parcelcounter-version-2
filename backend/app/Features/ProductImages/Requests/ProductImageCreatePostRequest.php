<?php

namespace App\Features\ProductImages\Requests;

use App\Http\Enums\Guards;
use App\Http\Requests\InputRequest;
use Illuminate\Support\Facades\Auth;


class ProductImageCreatePostRequest extends InputRequest
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
            'image_title' => 'nullable|string|max:255',
            'image_alt' => 'nullable|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ];
    }
}
