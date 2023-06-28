<?php

namespace Database\Seeders;

use App\Models\CargoType;
use Illuminate\Database\Seeder;

class CargoTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CargoType::insert([
            [
                'name' => 'Cargo',
            ],
            [
                'name' => 'Business class',
            ]
        ]);
    }
}
