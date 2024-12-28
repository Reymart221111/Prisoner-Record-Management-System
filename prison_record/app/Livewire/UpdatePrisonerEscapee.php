<?php

namespace App\Livewire;

use App\Models\EscapePrisoner;
use Carbon\Carbon;
use Livewire\Attributes\On;
use Livewire\Component;

class UpdatePrisonerEscapee extends Component
{
    public $recordId = null;
    public $escape_date = '';
    public $notes = '';

    public function rules()
    {
        return [
            'escape_date' => ['required', 'date'],
            'notes' => ['required', 'string', 'min:5'],
        ];
    }

    #[On('editEscapee')]
    public function handleEditEvent($recordId)
    {
        $this->resetValidation();

        // Access recordId from the event data
        $this->recordId = $recordId;

        try {
            $prisonerEscapee = EscapePrisoner::findOrFail($this->recordId);
            // Format the date to Y-m-d for HTML date input
            $this->escape_date = Carbon::parse($prisonerEscapee->escape_date)->format('Y-m-d');
            $this->notes = $prisonerEscapee->notes;
        } catch (\Exception $e) {
            session()->flash('error', 'Record not found.');
        }
    }

    public function updateParole()
    {
        $this->validate();

        try {
            $prisonerEscapee = EscapePrisoner::findOrFail($this->recordId);
            $prisonerEscapee->update([
                'escape_date' => $this->escape_date,
                'notes' => $this->notes,
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
        return view('livewire.update-prisoner-escapee');
    }
}
