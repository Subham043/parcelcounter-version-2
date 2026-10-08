<?php

namespace App\Features\AboutSections\Requests;

use App\Http\Enums\Guards;
use App\Http\Requests\InputRequest;
use Illuminate\Support\Facades\Auth;


class AboutSectionFilterRequest extends InputRequest
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

            'sort' => 'nullable|string|in:id,-id,created_at,-created_at',

            'filter' => 'nullable|array:search,is_active',

            'filter.search' => 'nullable|string|max:255',

            'filter.is_active' => 'nullable|string|in:yes,no',
        ];
    }
}
