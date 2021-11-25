<?php

namespace App\Http\Livewire\Auth;

use App\Models\CaseCategory;
use App\Models\ClinicSchedule;
use App\Models\Schedule;
use Livewire\Component;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SignUp extends Component
{
    public $name = '';
    public $email = '';
    public $password = '';
    public $date_of_appointment = '';
    public $location ='';
    public $phone = '';
    public $custom_validation = '';
    public $time_type = '';
    public $case_category_id = '';

    protected $rules = [
        'name' => 'required|min:3',
        'location' => 'required|max:255',
        'date_of_appointment' => 'required|date',
        'phone' => 'required|max:21',
        'email' => 'required|unique:users,email',
        'password' => 'required|min:6',
        'time_type' => 'required|in:am,pm',
        'case_category_id' =>'required'
    ];

    public function mount() {
        if(auth()->user()){
            redirect('/dashboard');
        }
    }


    public function register() {
        $clinic_sched = ClinicSchedule::first();
        $date_now = Carbon::now('Asia/Hong_Kong')->format('m/Y');
        $date_of_appointment = new Carbon($this->date_of_appointment);
        $weekend = new Carbon($this->date_of_appointment);

        if($weekend->isWeekend()){
            return  $this->addError('custom_validation', 'Sorry, No Appointment on Weekend!');
        }

        if($clinic_sched->number_of_patient_am <= 0 && $this->time_type === 'am'){
         return  $this->addError('custom_validation', 'Sorry, Reached Maximum Morning Appointment!');
        }

        if($clinic_sched->number_of_patient_pm <= 0 && $this->time_type === 'pm'){
            return  $this->addError('custom_validation', 'Sorry, Reached Maximum Afternoon Appointment!');
           }

        if($date_now != $date_of_appointment->format('m/Y')){
            return  $this->addError('custom_validation', 'You can only book appointment for the month of '.Carbon::now()->monthName);
        }

       $user = DB::transaction(function () use($clinic_sched) {
            $user = User::create([
                  'name' =>$this->name,
                'location' =>$this->location,
                'password' =>$this->password,
                'phone' =>$this->phone,
                'date_of_appointment' =>$this->date_of_appointment,
                'case_category_id' =>$this->case_category_id,
                'email' =>$this->email
            ]);
            $user->assignRole('patient');

            Schedule::create([
                'start' => $this->date_of_appointment,
                'end'=> Carbon::now()->addDay(),
                'user_id' =>$user->id,
                'title' =>$user->name,
                'time_type' => $this->time_type,
                'case_category_id' =>$this->case_category_id
            ]);

            // $clinic_sched->decrement('number_of_patient',1);

            // if($clinic_sched->number_of_patient <= 0){
            //     $this->addError('reach_limit', 'Sorry Reach Maximum Booking For Today!');
            // }
            return $user;
    });

    auth()->login($user);
    return redirect('/dashboard');
    }

    public function render()
    {
        return view('livewire.auth.sign-up',[
            'case_categories' => CaseCategory::all()
        ]);
    }
}
