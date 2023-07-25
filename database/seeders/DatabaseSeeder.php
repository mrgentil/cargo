<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleSeeder::class);
        $this->call(AgenceSeeder::class);
        $this->call(TownSeeder::class);
        $this->call(ExpeditionTypeSeeder::class);
        $this->call(SuperAdminSeeder::class);
    }
}
