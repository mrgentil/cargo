<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    use HasFactory;

    protected $fillable = [
        "sender_id",
        "recipient_id",
        "amount",
        "sending_town_id",
        "destination_town_id",
        "secret_code",
        "code",
        "tarif",
        "user_id",
        "payed_sender_amount",
        "payed_recipient_amount",
        "cargo_id"
    ];

    public function sender()
    {
        return $this->belongsTo(Customer::class, "sender_id");
    }

    public function recipient()
    {
        return $this->belongsTo(Customer::class, "recipient_id");
    }

    public function sendingTown()
    {
        return $this->belongsTo(Town::class, "sending_town_id");
    }

    public function destinationTown()
    {
        return $this->belongsTo(Town::class, "destination_town_id");
    }

    public function Cargo()
    {
        return $this->belongsTo(Expedition::class);
    }

    public function packages()
    {
        return $this->hasMany(Package::class);
    }
}
