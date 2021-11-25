<?php

namespace Database\Seeders;

use App\Models\CaseCategory;
use Illuminate\Database\Seeder;

class CaseCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CaseCategory::insert([
            [
                'name' =>'Ultrasound'
            ],
            [
                'name' =>'Transvaginal'
            ],
            [
                'name' =>'Transrectal'
            ],
            [
                'name' =>'Transabdominal-Care'
            ]
        ]);
    }
}
