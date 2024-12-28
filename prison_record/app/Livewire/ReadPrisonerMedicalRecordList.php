<?php

namespace App\Livewire;

use App\Models\Prisoner;
use App\Models\PrisonerMedicalRecord;
use Livewire\Component;
use Livewire\WithPagination;

class ReadPrisonerMedicalRecordList extends Component
{
    use WithPagination;

    public $prisonerId;
    public $search;
    public $searchDate;
    public $prisoner;

    public function mount()
    {
        $this->prisoner = Prisoner::findOrFail($this->prisonerId);
    }

    public function destroyMedicalRecord($recordId)
    {
        $prisonerMedicalRecord = PrisonerMedicalRecord::findOrFail($recordId);
        try {
            $prisonerMedicalRecord->delete();
            session()->flash('success', 'Deleted Succesfully');
        } catch (\Throwable $th) {
            session()->flash('error', 'Error:' . $th->getMessage());
        }
    }

    public function render()
    {
        $prisoner = Prisoner::findOrFail($this->prisonerId);
        $medicalRecords = $prisoner->medicalRecords()
            ->where('medical_diagnosis', 'like', "%{$this->search}%")
            ->when($this->searchDate, function ($query) {
                return $query->whereDate('last_checkup_date', $this->searchDate);
            })
            ->paginate(10);

        return view('livewire.read-prisoner-medical-record-list', [
            'prisoner' => $prisoner,
            'medicalRecords' => $medicalRecords,
        ]);
    }
}
