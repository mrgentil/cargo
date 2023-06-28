<?php

namespace App\Http\Controllers;

use App\Http\Resources\SuperPackageResource;
use App\Models\Cargo;
use App\Models\Package;
use App\Models\SuperPackage;
use App\Services\IdGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use \Illuminate\Validation\ValidationException;

class SuperPackageController extends Controller
{

    public function index()
    {
        $superPackages = SuperPackage::paginate(15);
        return SuperPackageResource::collection($superPackages);
    }

    public function store(Request $request)
    {
        $data = Validator::make($request->all(), [
            "max_weight" => 'required|numeric',
            'packages' => 'required|array',
            'packages.*' => 'integer'
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
            $superCargo = SuperPackage::create([
                "max_weight" => $data["max_weight"],
                "cargo_id" => $cargo->id,
                "user_id" => auth()->user()->id,
                "code" => IdGenerator::Generate("superPackage")
            ]);

            foreach ($data["packages"] as $value) {
                $package = Package::find($value);
                if (!$package) {
                    continue;
                }
                $package->super_package_id = $superCargo->id;
                $package->save();
            }
            DB::commit();
            response()->json(null, 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }
}
