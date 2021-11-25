<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Schedule;
class Cancelled extends Component
{
    public function render()
    {
        $appointments =  Schedule::withTrashed()
        ->paginate(10);
        return view('livewire.cancelled',['appointments' =>$appointments]);
    }
}
