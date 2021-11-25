<?php

namespace App\Http\Livewire;

use App\Models\CaseCategory;
use App\Models\Schedule;
use Livewire\Component;
use Livewire\WithPagination;

class Tables extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.tables',[
            'appointments' => Schedule::paginate(10),
        ]);
    }
}
