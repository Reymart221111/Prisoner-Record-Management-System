<?php

namespace App\Livewire;

use App\Models\PrisonerMedicalRecord;
use Livewire\Component;

class ViewMedicalRecord extends Component
{
    public $prisonerMedicalRecords;
    public $prisonerMedicalRecordId;

    public function mount()
    {
        $this->prisonerMedicalRecords = PrisonerMedicalRecord::findOrFail($this->prisonerMedicalRecordId);
    }
    
    public function render()
    {
        return view('livewire.view-medical-record');
    }
}
