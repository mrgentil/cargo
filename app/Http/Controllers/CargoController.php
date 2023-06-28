<?php

namespace App\Http\Controllers;

use App\Models\Cargo;
use App\Services\IdGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CargoController extends Controller
{
    public function index()
    {
        $superPackages = Cargo::paginate(15);
        return Cargo::collection($superPackages);
    }

    public function store(Request $request)
    {
        $data = Validator::make($request->all(), [
            'start_date' => 'date|required|before:end_date',
            'end_date' => 'date|required|after:start_date',
            'tarif' => 'required|numeric',
            'cargo_type_id' => 'required|numeric|exists:cargo_types,id'
        ])->validate();

        try {
            Cargo::create([
                'start_date' => $data['start_date'],
                'end_date' => $data['end_date'],
                'tarif' => $data['tarif'],
                'cargo_type_id' => $data["cargo_type_id"],
                'code' => IdGenerator::Generate('cargo'),
                'is_closed' => false,
                'user_id' => auth()->user()->id
            ]);

            return response()->json(null, 201);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }
}
