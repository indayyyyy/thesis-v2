<?php

namespace Database\Seeders;

use App\Models\ClinicSchedule;
use Illuminate\Database\Seeder;

class ClinicScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ClinicSchedule::create();
    }
}
