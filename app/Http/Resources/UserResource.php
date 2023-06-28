<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'full_name' => $this->full_name,
            'telephone' => $this->telephone,
            'email' => $this->email,
            'gender' => $this->gender,
            'first_login' => (bool)$this->first_login,
            'roles' => RoleResource::collection($this->roles),
        ];
    }
}
