<?php

namespace App\Features\Authentication\Resources;

use App\Features\Roles\Resources\RoleCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthCollection extends JsonResource
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
			'verified' => $this->phone_verified_at ? "VERIFIED" : "VERIFICATION PENDING",
			'email_verified_at' => $this->email_verified_at,
			'phone_verified_at' => $this->phone_verified_at,
			'is_blocked' => $this->is_blocked,
			'roles' => RoleCollection::collection($this->roles),
			'created_at' => $this->created_at,
			'updated_at' => $this->updated_at,
		];
	}
}
