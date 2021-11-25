<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $admin =   User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@clinic.com',
            'password' =>'password'
        ]);

        $admin->assignRole('admin');

        $doctor = User::factory()->create([
            'name' => 'user doctor',
            'email' => 'doctor@clinic.com',
            'password' => 'password'
        ]);

        $doctor->assignRole('admin');
    }
}
