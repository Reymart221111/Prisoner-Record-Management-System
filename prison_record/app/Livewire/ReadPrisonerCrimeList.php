<?php

namespace App\Livewire;

use App\Models\Prisoner;
use Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Throwable;

class ReadPrisonerCrimeList extends Component
{
    use WithPagination;

    public $crime;
    public $committed_date;
    public $additional_notes;
    public $prisonerID;
    public $search;
    public $searchDate;

    public function mount($prisonerID)
    {
        $this->prisonerID = $prisonerID;
    }

    public function detachCrime($pivotId)
    {
        $prisoner = Prisoner::findOrFail($this->prisonerID);
        try {
            $prisoner->crimes()->wherePivot('id', $pivotId)->detach();

            activity()
                ->performedOn($prisoner)
                ->causedBy(Auth::user())
                ->withProperties(['old' => [
                    'crime_id' => $this->crime,
                    'committed_date' => $this->committed_date,
                    'additional_notes' => $this->additional_notes,
                ]])
                ->event('detached')
                ->log("Detached Crime ID {$pivotId} to Prisoner ID {$this->prisonerID}");

            session()->flash('success', 'Crime record has been removed successfully.');
        } catch (Throwable $th) {
            session()->flash('error', 'Error:' . $th->getMessage());
        }
    }

    public function render()
    {
        $prisoner = Prisoner::findOrFail($this->prisonerID);
        $crimes = $prisoner->crimes()
            ->withPivot('id', 'committed_date', 'additional_notes')
            ->where('crime_name', 'like', "%{$this->search}%")
            ->when($this->searchDate, function ($query) {
                return $query->whereDate('crime_prisoner.committed_date', $this->searchDate);
            })
            ->paginate(10);

        return view('livewire.read-prisoner-crime-list', [
            'prisoner' => $prisoner,
            'crimes' => $crimes
        ]);
    }
}
