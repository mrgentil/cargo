<?php

namespace App\Http\Controllers;

use App\Http\Resources\PackageResource;
use App\Models\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function indexByCode($code)
    {
        try {
            $package = Package::where('code', $code)->first();
            if ($package) {
                return response()->json(PackageResource::make($package));
            }
            return response()->json(null, 404);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }
}
