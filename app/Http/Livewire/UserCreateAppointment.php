<?php

namespace App\Http\Livewire;

use Livewire\Component;

class UserCreateAppointment extends Component
{

    public $name = '';
    public $email = '';
    // public $password = '';
    public $date_of_appointment = '';
    public $location ='';
    public $phone = '';
    public $custom_validation = '';

    protected $rules = [
        'name' => 'required|min:3',
        'location' => 'required|max:255',
        'date_of_appointment' => 'required|date',
        'phone' => 'required|max:21',
        'email' => 'required|email:rfc,dns|unique:users',
        // 'password' => 'required|min:6',
    ];


    public function register_patient()
    {
        dd('test');

    }

    public function render()
    {
        return view('livewire.user-create-appointment');
    }
}
