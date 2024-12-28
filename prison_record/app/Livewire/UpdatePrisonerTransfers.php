<?php

namespace App\Livewire;

use App\Models\TransfferedPrisoner;
use Carbon\Carbon;
use Livewire\Attributes\On;
use Livewire\Component;

class UpdatePrisonerTransfers extends Component
{
    public $recordId = null;
    public $transfer_date = '';
    public $notes = '';

    public function rules()
    {
        return [
            'transfer_date' => ['required', 'date'],
            'notes' => ['required', 'string', 'min:5'],
        ];
    }

    #[On('editTransferedPrisoner')]
    public function handleEditEvent($recordId)
    {
        $this->resetValidation();

        // Access recordId from the event data
        $this->recordId = $recordId;

        try {
            $transferedPrisoner = TransfferedPrisoner::findOrFail($this->recordId);
            // Format the date to Y-m-d for HTML date input
            $this->transfer_date = Carbon::parse($transferedPrisoner->transfer_date)->format('Y-m-d');
            $this->notes = $transferedPrisoner->notes;
        } catch (\Exception $e) {
            session()->flash('error', 'Record not found.');
        }
    }

    public function updateParole()
    {
        $this->validate();

        try {
            $transferedPrisoner = TransfferedPrisoner::findOrFail($this->recordId);
            $transferedPrisoner->update([
                'transfer_date' => $this->transfer_date,
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
        return view('livewire.update-prisoner-transfers');
    }
}
