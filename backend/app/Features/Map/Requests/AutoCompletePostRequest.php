<?php

namespace App\Features\Map\Requests;

use App\Http\Requests\InputRequest;


class AutoCompletePostRequest extends InputRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return TRUE;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'query' => 'required|min:2|string|max:250',
            'lat' => 'nullable|required_with:lng|decimal:1,15',
            'lng' => 'nullable|required_with:lat|decimal:1,15',
        ];
    }

    public function attributes(): array
    {
        return [
            'query' => 'Query',
            'lat' => 'Latitude',
            'lng' => 'Longitude',
        ];
    }
}
