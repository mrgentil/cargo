<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'full_name' => 'Super Admin',
            'telephone' => '+380937777777',
            'email' => 'root@gmail.com',
            'password' => Hash::make('root'),
            'gender' => "M"
        ]);

        $user->assignRole('Super-Admin');
    }
}
