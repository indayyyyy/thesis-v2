<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

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
        $this->call(UserSeeder::class);
        $this->call(ClinicScheduleSeeder::class);
        $this->call(CaseCategorySeeder::class);
    }
}
