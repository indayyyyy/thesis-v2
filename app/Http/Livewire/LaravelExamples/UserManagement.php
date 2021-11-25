<?php

namespace App\Http\Livewire\LaravelExamples;

use App\Models\User;
use Livewire\Component;

class UserManagement extends Component
{
    public function render()
    {
        $users =  User::whereHas(
            'roles', function($q){
                $q->where('name', 'admin')
                ->Orwhere('name','doctor');
            }
        )->get();
        return view('livewire.laravel-examples.user-management',['users'=>$users]);
    }
}
