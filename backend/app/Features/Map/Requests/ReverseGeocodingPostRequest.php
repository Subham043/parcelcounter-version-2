<?php

namespace App\Features\Map\Requests;

use App\Http\Requests\InputRequest;


class ReverseGeocodingPostRequest extends InputRequest
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
            'lat' => 'required|decimal:1,15',
            'lng' => 'required|decimal:1,15',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'lat' => 'Latitude',
            'lng' => 'Longitude',
        ];
    }
}
