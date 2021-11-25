<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClinicSchedule extends Model
{
    use HasFactory;
    protected $fillable = [
        'number_of_patient_am',
        'number_of_patient_pm',
        'clinic_status',
    ];

}
