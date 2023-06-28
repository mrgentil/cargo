<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SuperPackageResource extends JsonResource
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
            "id" => $this->id,
            "code" => $this->code,
            "max_weight" => $this->max_weight,
            "cargo" => CargoResource::make($this->cargo),
            "owner" => UserResource::make($this->owner),
            "packages" => PackageResource::collection($this->packages)
        ];
    }
}
