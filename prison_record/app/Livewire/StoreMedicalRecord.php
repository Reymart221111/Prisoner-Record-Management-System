<?php

namespace App\Livewire;

use App\Models\Prisoner;
use Livewire\Component;
use Throwable;

class StoreMedicalRecord extends Component
{
    public $medical_diagnosis;
    public $medication;
    public $last_checkup_date;
    public $doctor_notes;
    public $prisonerId;

    public function rules()
    {
        return [
            'medical_diagnosis' => ['required', 'string'],
            'medication' => ['nullable', 'string'],
            'last_checkup_date' => ['required', 'date'],
            'doctor_notes' => ['nullable', 'string'],
        ];
    }
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function mount($prisonerId)
    {
        $this->prisonerId = $prisonerId;
    }

    public function storeMedicalRecord()
    {
        $validatedData = $this->validate();

        try {
            $prisoner = Prisoner::findOrFail($this->prisonerId);
            $prisoner->medicalRecords()->create($validatedData);
            session()->flash('success', 'Medical Record Added Successfully');
        } catch (Throwable $th) {
            session()->flash('error', 'Error: ' . $th->getMessage());
        }
        $this->reset(['medical_diagnosis', 'medication', 'last_checkup_date', 'doctor_notes']);
    }


    public function render()
    {
        return view('livewire.store-medical-record');
    }
}
