<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use App\Http\Requests\ScheduleRequest;
use App\Models\ClinicSchedule;
use Illuminate\Support\Facades\Validator;
Use Alert;
use App\Http\Requests\PatientRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class ScheduleController extends Controller
{

    public function check_validated($request)
    {

        $clinic_sched = ClinicSchedule::first();
        $date_now = Carbon::now('Asia/Hong_Kong')->format('m/Y');
        $date_of_appointment = new Carbon($request->date_of_appointment);

        $weekend = new Carbon($request->date_of_appointment);



        if($clinic_sched->number_of_patient_am <= 0 && $request->time_type === 'am')
        {
            Alert::error('Appointment Error', 'Sorry, Reached Maximum Morning Appointment!');
            return redirect()->back();
        }
        if($clinic_sched->number_of_patient_pm <= 0  && $request->time_type === 'pm')
        {
            Alert::error('Appointment Error', 'Sorry, Reached Maximum Afternoon Appointment!');
            return redirect()->back();
        }


        if($date_now != $date_of_appointment->format('m/Y'))
        {
            Alert::error('Appointment Error', 'You can only book appointment for the month of '.Carbon::now()->monthName);
            return redirect()->back();
        }
    }

    public function update_sched(Request $request, Schedule $schedule)
    {
              $weekend = new Carbon($request->start);

        if($weekend->isWeekend()){
            Alert::error('Appointment Error', 'Sorry, No Appointment on Weekend!');
            return redirect()->back();
        }


        DB::transaction(function ()  use($request, $schedule){
            $schedule->update($request->all());
        });

        return redirect()->back()->withSuccess('Updated Successfully!');
    }
    public function create_sched_patient(PatientRequest $request)
    {
        $weekend = new Carbon($request->date_of_appointment);

        if($weekend->isWeekend()){
            Alert::error('Appointment Error', 'Sorry, No Appointment on Weekend!');
            return redirect()->back();
        }

        $this->check_validated($request);

        Schedule::create([
            'start' => $request->date_of_appointment,
            'end'=> Carbon::now()->addDay(),
            'user_id' =>auth()->user()->id,
            'title' =>auth()->user()->name,
            'status' =>'pending',
            'case_category_id' =>$request->case_category_id
        ]);

        return redirect()->route('appointments')->withSuccess('Created Successfully!');
    }

    public function create_sched(ScheduleRequest $request)
    {

        //diri mag send og sms notif password sa user
    $weekend = new Carbon($request->date_of_appointment);

        if($weekend->isWeekend()){
            Alert::error('Appointment Error', 'Sorry, No Appointment on Weekend!');
            return redirect()->back();
        }

        $this->check_validated($request);

        $clinic_sched = ClinicSchedule::first();
         DB::transaction(function () use($clinic_sched,$request) {
        $password =  Str::random(12);
            $user = User::create([
                'name' => $request->name,
                'location' => $request->location,
                'phone' => $request->phone,
                'email' =>$request->email,
                'password' =>$password
            ]);
            $user->assignRole('patient');

         $sched =   Schedule::create([
                'start' => $request->date_of_appointment,
                'end'=> Carbon::now()->addDay(),
                'user_id' =>$user->id,
                'title' =>$user->name,
                'status' =>'approved',
                'case_category_id' =>$request->case_category_id
            ]);

            if($sched->time_type === 'am' ){
                $clinic_sched->decrement('number_of_patient_am',1);
            }else{
                $clinic_sched->decrement('number_of_patient_pm',1);
            }

            $details = [
                'title' => 'Dr. Edillion Maternity',
                'body' => 'Hello, '   .$user->name. ' your registration process has been confirm. Your account has been created. You can now login using this credentials email: '.$user->email. '& password: '. $password
            ];


            \Mail::to($user->email)->send(new \App\Mail\PasswordNotif($details));


    });

        // Alert::success('Congrats', 'You\'ve Successfully Registered');
      return redirect()->route('dashboard')->withSuccess('Created Successfully!');
    }

    public function index(Request $request)
    {
        if($request->ajax()) {
            if(auth()->user()->hasRole('patient')){
                $data = Schedule::where('user_id',auth()->user()->id)
                ->whereDate('start', '>=', $request->start)
                ->whereDate('end',   '<=', $request->end)
                ->where('status','approved')
                ->get(['id', 'start', 'end','title']);

                return response()->json($data);
            }
             $data = Schedule::whereDate('start', '>=', $request->start)
                       ->whereDate('end',   '<=', $request->end)
                       ->where('status','approved')
                       ->get(['id', 'start', 'end','title']);


             return response()->json($data);
        }

        return view('calendar');
    }

    public function ajax(Request $request)
    {
        $time = Carbon::now('Asia/Hong_Kong');
        switch ($request->type) {

           case 'add':
              $event = Schedule::create([
                  'user_id' => auth()->user()->id,
                  'start' => new DateTime($request->start. ' '.$time->toTimeString()),
                  'end' => $request->end,
                  'title' =>auth()->user()->name
              ]);

              return response()->json($event);
             break;

           case 'update':
              $event = Schedule::find($request->id)->update([
                  'start' => $request->start,
                  'end' => $request->end,
                  'title' =>auth()->user()->name

              ]);


              return response()->json($event);
             break;

           case 'delete':
              $event = Schedule::find($request->id)->delete();
              return response()->json($event);
             break;

           default:
             # code...
             break;
        }
    }
}
