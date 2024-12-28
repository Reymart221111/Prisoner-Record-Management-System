<?php

namespace App\Livewire;

use App\Models\Prisoner;
use Livewire\Component;
use Livewire\WithPagination;

class ReadPrisonerMedicalRecords extends Component
{
    use WithPagination;
    
    public $search='';

    public function render()
    {
        $prisoners = Prisoner::where('first_name', 'like', "%{$this->search}%")
            ->orWhere('last_name', 'like', "%{$this->search}%")
            ->orWhere('prisoner_id', 'like', "%{$this->search}%")
            ->paginate(10);
        return view('livewire.read-prisoner-medical-records', ['prisoners' => $prisoners]);
    }
}
