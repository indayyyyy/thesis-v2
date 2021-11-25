<?php

namespace App\Http\Livewire;

use App\Models\CaseCategory;
use App\Models\Schedule;
use Livewire\Component;

class Appointments extends Component
{
    public function render()
    {
        $data = Schedule::where('user_id',auth()->user()->id)->paginate(10);
        return view('livewire.appointments',[
            'appointments' => $data,
            'case_categories' => CaseCategory::all()
        ]);
    }
}
