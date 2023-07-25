<?php

namespace Database\Seeders;

use App\Models\ExpeditionType;
use Illuminate\Database\Seeder;

class ExpeditionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ExpeditionType::insert([
            [
                'name' => 'Cargo',
            ],
            [
                'name' => 'Business',
            ]
        ]);
    }
}
