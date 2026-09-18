<?php

namespace App\Features\ContactFormEnquiries\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ContactFormEnquiryCollection extends JsonResource
{
	/**
	 * Transform the resource collection into an array.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
	 */
	public function toArray($request)
	{
		return [
			'id' => $this->id,
			'name' => $this->name,
			'email' => $this->email,
			'phone' => $this->phone,
			'subject' => $this->subject,
			'message' => $this->message,
			'page_url' => $this->page_url,
			'created_at' => $this->created_at,
			'updated_at' => $this->updated_at,
		];
	}
}