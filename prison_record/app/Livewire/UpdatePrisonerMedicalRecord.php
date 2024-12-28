<?php

namespace App\Livewire;

use App\Models\PrisonerMedicalRecord;
use Livewire\Component;

class UpdatePrisonerMedicalRecord extends Component
{
    public $prisonerMedicalRecordId;
    public $medical_diagnosis;
    public $medication;
    public $last_checkup_date;
    public $doctor_notes;

    public function rules()
    {
        return [
            'medical_diagnosis' => ['required', 'string'],
            'medication' => ['nullable', 'string'],
            'last_checkup_date' => ['required', 'date'],
            'doctor_notes' => ['nullable', 'string']
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function mount($prisonerMedicalRecordId)
    {
        $prisonerMedicalRecord = PrisonerMedicalRecord::findOrFail($prisonerMedicalRecordId);
        $this->prisonerMedicalRecordId = $prisonerMedicalRecordId;
        $this->medical_diagnosis = $prisonerMedicalRecord->medical_diagnosis;
        $this->medication = $prisonerMedicalRecord->medication;
        $this->last_checkup_date = $prisonerMedicalRecord->last_checkup_date;
        $this->doctor_notes = $prisonerMedicalRecord->doctor_notes;
    }

    public function updateMedicalRecord()
    {
        $validatedData = $this->validate();

        try {
            $prisonerMedicalRecord = PrisonerMedicalRecord::findOrFail($this->prisonerMedicalRecordId);
            $prisonerMedicalRecord->update($validatedData);
            session()->flash('success', 'Record Updated Sucesfuly');
        } catch (\Throwable $th) {
            session()->flash('error', 'Error:' . $th->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.update-prisoner-medical-record');
    }
}
