<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClinicSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clinic_schedules', function (Blueprint $table) {
            $table->id();
            $table->integer('number_of_patient_am')->default(8);
            $table->integer('number_of_patient_pm')->default(8);
            $table->enum('clinic_status',['available','unavailable'])->default('available');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clinic_schedules');
    }
}
