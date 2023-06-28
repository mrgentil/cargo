<?php

namespace App\Http\Controllers;

use App\Http\Resources\ShippingResource;
use App\Models\Cargo;
use App\Models\Customer;
use App\Models\Shipping;
use App\Services\IdGenerator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ShippingController extends Controller
{
    public function store(Request $request)
    {
        $data = Validator::make($request->all(), [
            'sender_first_name' => 'required|string',
            'sender_last_name' => 'required|string',
            'sender_phone' => 'required|string',
            'recipient_first_name' => 'required|string',
            'recipient_last_name' => 'required|string',
            'recipient_phone' => 'required|string',
            'sending_town' => 'required|numeric|different:destination_town',
            'destination_town' => 'required|numeric|different:recipient_phone',
            'amount' => 'required|numeric',
            'payed_sender_amount' => 'nullable|numeric',
            'packages' => 'required|array',
            'packages.*.weight' => 'required|numeric'
        ])->validate();


        try {
            $cargo = Cargo::where('is_closed', false)->first();
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }

        if (!$cargo) {
            throw ValidationException::withMessages([
                'cargo' => "Veuillez créer un cargo avant"
            ]);
        }

        try {
            DB::beginTransaction();

            $sender = Customer::create([
                "first_name" => $data["sender_first_name"],
                "last_name" => $data["sender_last_name"],
                "telephone" => $data["sender_phone"]
            ]);

            $recipient = Customer::create([
                "first_name" => $data["recipient_first_name"],
                "last_name" => $data["recipient_last_name"],
                "telephone" => $data["recipient_phone"]
            ]);

            $shipping = Shipping::create([
                "sender_id" => $sender->id,
                "recipient_id" => $recipient->id,
                "amount" =>  $data["amount"],
                "sending_town_id" => $data["sending_town"],
                "destination_town_id" => $data["destination_town"],
                "secret_code" => rand(10000000, 99999999),
                "code" => IdGenerator::Generate("shipping"),
                "tarif" => $cargo->tarif,
                "payed_sender_amount" => isset($data["payed_sender_amount"]) ? $data["payed_sender_amount"] : 0,
                "payed_recipient_amount" => 0,
                'user_id' => auth()->user()->id,
                "cargo_id" => $cargo->id,
                "is_shipped" => false
            ]);

            $packages = [];
            foreach ($data["packages"] as $value) {
                $packages[] = [
                    "weight" => $value["weight"],
                    "code" => IdGenerator::Generate("packages")
                ];
            }

            $shipping->packages()->createMany($packages);

            DB::commit();

            return response()->json(ShippingResource::make($shipping));
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }

    public function seekShipping(Request $request)
    {
        $data = Validator::make($request->all(), [
            'sender_first_name' => 'required|string',
            'sender_last_name' => 'required|string',
            'recipient_first_name' => 'required|string',
            'recipient_last_name' => 'required|string',
            'secret_code' => 'required|numeric'
        ])->validate();

        try {
            $shipping = Shipping::where('secret_code', $data['secret_code'])
                ->where("is_shipped", false)
                ->join('customers as sender', function ($query) use ($data) {
                    $query->on('sender.id', "shippings.sender_id")
                        ->where('sender.first_name', $data['sender_first_name'])
                        ->where("sender.last_name", $data['sender_last_name']);
                })
                ->join('customers as recipient', function ($query) use ($data) {
                    $query->on('recipient.id', "shippings.recipient_id")
                        ->where('recipient.first_name', $data['recipient_first_name'])
                        ->where("recipient.last_name", $data['recipient_last_name']);
                })->select("shippings.*")->first();

            if (!$shipping) {
                return  response()->json(null, 404);
            }
            return response()->json(ShippingResource::make($shipping));
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }

    public function delivered(Request $request)
    {
        $data = Validator::make($request->all(), [
            "shipping_id" => 'required|numeric',
            'secret_code' => 'required|numeric',
            "payed_recipient_amount" => "nullable|numeric"
        ])->validate();

        try {
            $shipping = Shipping::where("id", $data["shipping_id"])->where('secret_code', $data['secret_code'])
                ->where("is_shipped", false);
            if ($shipping) {
                return  response()->json(null, 404);
            }

            $payed_recipient_amount = $data["payed_recipient_amount"] ?? 0;
            $payed_sender_amount = $shipping->payed_sender_amount ?? 0;
            $amount = $shipping->amount;
            $total_payed = $payed_recipient_amount + $payed_sender_amount;

            if ($total_payed < $amount) {
                return response()->json([
                    "total_payed" => $total_payed,
                    "remaining_payed" => $amount - $total_payed
                ], 422);
            }

            $shipping->payed_recipient_amount = $payed_recipient_amount;
            $shipping->is_shipped = true;
            $shipping->save();
            return response()->json(ShippingResource::make($shipping));
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }
}
