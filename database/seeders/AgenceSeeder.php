<?php

namespace Database\Seeders;

use App\Models\Agence;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AgenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Agence::insert([
            [
                'name' => 'Kinshasa - Kasa-Vubu',
            ],
            [
                'name' => 'Kinshasa - Bisou-Bisou',
            ],
            [
                'name' => 'Kinshasa - Lowa',
            ],
            [
                'name' => 'Kinshasa - Rond-Point Ngaba',
            ],
            [
                'name' => 'Lubumbashi',
            ],
            [
                'name' => 'Kolwezi',
            ],
            [
                'name' => 'Goma',
            ],
            [
                'name' => 'Matadi',
            ],
            [
                'name' => 'Congo - Brazzaville',
            ],
            [
                'name' => 'Angola - Luanda',
            ],
        ]);
    }
}
