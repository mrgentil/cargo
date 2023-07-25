<?php

namespace App\Http\Resources;

use App\Models\Customer;
use Illuminate\Http\Resources\Json\JsonResource;

class ShippingResource extends JsonResource
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
            'sender' => CustomerResource::make($this->sender),
            'recipient' => CustomerResource::make($this->recipient),
            'amount' => $this->amount,
            'tarif' => $this->tarif,
            'payed_sender_amount' => $this->payed_sender_amount,
            'payed_recipient_amount' => $this->payed_recipient_amount,
            'is_shipped' => (bool) $this->is_shipped,
            'sending_town' => TownResource::make($this->sendingTown),
            'destination_town' => TownResource::make($this->destinationTown),
            'secret_code' => $this->secret_code,
            'code' => $this->code,
            'packages' => PackageResource::collection($this->packages),
            'Expedition' => CargoResource::make($this->cargo)
        ];
    }
}
