<?php

namespace App\Http\Controllers;

use App\Http\Requests\SMSRequest;
use App\Models\ClinicSchedule;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Nexmo\Laravel\Facade\Nexmo;
use RealRashid\SweetAlert\Facades\Alert;

class SMSController extends Controller
{
    public function send_sms(SMSRequest $request)
    {
        $user = User::findOrFail($request->user_id);
        $sched = Schedule::where('user_id',$user->id)
        ->whereDate('start',$request->start)
        ->first();

        $clinic_sched = ClinicSchedule::first();

        if($clinic_sched->number_of_patient_am <= 0 && $request->time_type === 'am'){
            Alert::error('Appointment Error', 'Sorry, Reached Maximum Morning Appointment!');
            return redirect()->back();
        }

        if($clinic_sched->number_of_patient_pm <= 0 && $request->time_type === 'pm'){
            Alert::error('Appointment Error', 'Sorry, Reached Maximum Afternoon Appointment!');
            return redirect()->back();
           }

        DB::transaction(function () use($user,$sched,$clinic_sched){
            $sched->update([
                'status' =>'approved'
            ]);

            if($sched->time_type === 'am' ){
                $clinic_sched->decrement('number_of_patient_am',1);
            }else{
                $clinic_sched->decrement('number_of_patient_pm',1);
            }
            // Nexmo::message()->send([
            //     'to' => $user->phone,
            //     'from' =>'sender',
            //     'text' =>'Hello, '.$user->name. 'Your Appointment in Edilion Obygene Clinic has been approved. '
            // ]);

        });
        return redirect()->back()->withSuccess('Approved Successfully!');
    }
}
