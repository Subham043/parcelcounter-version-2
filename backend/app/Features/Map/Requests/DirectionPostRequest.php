<?php

namespace App\Features\Map\Requests;

use App\Http\Requests\InputRequest;


class DirectionPostRequest extends InputRequest
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
            'origin_lat' => 'required|decimal:1,15',
            'origin_lng' => 'required|decimal:1,15',
            'destination_lat' => 'required|decimal:1,15',
            'destination_lng' => 'required|decimal:1,15',
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
            'origin_lat' => 'Origin Latitude',
            'origin_lng' => 'Origin Longitude',
            'destination_lat' => 'Destination Latitude',
            'destination_lng' => 'Destination Longitude',
        ];
    }
}
