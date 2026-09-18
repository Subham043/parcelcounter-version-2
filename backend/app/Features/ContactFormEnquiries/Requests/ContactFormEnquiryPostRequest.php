<?php

namespace App\Features\ContactFormEnquiries\Requests;

use App\Http\Requests\InputRequest;


class ContactFormEnquiryPostRequest extends InputRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
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
            'email' => 'required|string|email:rfc,dns|max:255',
            'phone' => 'nullable|numeric|digits:10',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:500',
            'page_url' => 'nullable|url|max:500',
        ];
    }
}
