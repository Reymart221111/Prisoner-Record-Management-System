<?php

namespace App\Livewire;

use App\Models\DiseasePrisoner;
use Livewire\Component;
use Carbon\Carbon;
use Livewire\Attributes\On;

class UpdatePrisonerDisease extends Component
{
    public $recordId = null;
    public $death_date = '';
    public $death_cause = '';

    public function rules()
    {
        return [
            'death_date' => ['required', 'date'],
            'death_cause' => ['required', 'string', 'min:5'],
        ];
    }

    #[On('editDeadPrisoner')]
    public function handleEditEvent($recordId)
    {
        $this->resetValidation();

        // Access recordId from the event data
        $this->recordId = $recordId;

        try {
            $deadPrisoner = DiseasePrisoner::findOrFail($this->recordId);
            // Format the date to Y-m-d for HTML date input
            $this->death_date = Carbon::parse($deadPrisoner->death_date)->format('Y-m-d');
            $this->death_cause = $deadPrisoner->death_cause;
        } catch (\Exception $e) {
            session()->flash('error', 'Record not found.');
        }
    }

    public function updateParole()
    {
        $this->validate();

        try {
            $deadPrisoner = DiseasePrisoner::findOrFail($this->recordId);
            $deadPrisoner->update([
                'death_date' => $this->death_date,
                'death_cause' => $this->death_cause,
            ]);

            $this->dispatch('record-updated', [
                'status' => 'success',
                'message' => 'Record Updated Succesfully'
            ]);
        } catch (\Throwable $th) {
            $this->dispatch('record-updated', [
                'status' => 'error',
                'message' => 'Error Updating Record:' . $th->getMessage()
            ]);
        }
    }

    public function resetValidation($field = null)
    {
        parent::resetValidation($field);
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function render()
    {
        return view('livewire.update-prisoner-disease');
    }
}
