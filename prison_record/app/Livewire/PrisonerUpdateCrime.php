<?php

namespace App\Livewire;

use App\Auditable;
use App\Models\Crime;
use App\Models\Prisoner;
use Exception;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PrisonerUpdateCrime extends Component
{
    public $prisonerID;
    public $prisonerCrimeId;
    public $availableCrimes;
    public $crime;
    public $committed_date;
    public $additional_notes;
    public $search; // Changed from selectedCrimeName to search

    protected $messages = [
        'crime.in' => 'Please select a valid crime from the list.',
    ];

    public function rules()
    {
        $validCrimeIds = collect($this->availableCrimes)->pluck('id')->toArray();

        return [
            'crime' => ['required', 'exists:crimes,id', 'in:' . implode(',', $validCrimeIds)],
            'committed_date' => ['required', 'date'],
            'additional_notes' => ['nullable', 'string'],
            'search' => ['required']
        ];
    }


    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);

        // If search is updated, validate that it matches an available crime
        if ($propertyName === 'search') {
            $matchingCrime = collect($this->availableCrimes)
                ->first(function ($crime) {
                    return strtolower($crime['crime_name']) === strtolower($this->search);
                });

            if (!$matchingCrime) {
                $this->addError('search', 'Please select a valid crime from the list.');
                $this->crime = null; // Reset crime ID if invalid search
            } else {
                $this->crime = $matchingCrime['id'];
            }
        }
    }

    public function mount($prisonerCrimeId)
    {
        $this->prisonerCrimeId = $prisonerCrimeId;

        // Get the pivot record with the crime name
        $prisonerCrime = \DB::table('crime_prisoner')
            ->join('crimes', 'crimes.id', '=', 'crime_prisoner.crime_id')
            ->where('crime_prisoner.id', $prisonerCrimeId)
            ->select('crime_prisoner.*', 'crimes.crime_name')
            ->first();

        if ($prisonerCrime) {
            $this->prisonerID = $prisonerCrime->prisoner_id;
            $this->crime = $prisonerCrime->crime_id;
            $this->committed_date = $prisonerCrime->committed_date;
            $this->additional_notes = $prisonerCrime->additional_notes;
            $this->search = $prisonerCrime->crime_name;
        }

        $this->availableCrimes = Crime::pluck('crime_name', 'id')
            ->map(function ($crime_name, $id) {
                return ['id' => $id, 'crime_name' => $crime_name];
            })
            ->values()
            ->toArray();
    }

    public function updateCrime()
    {
        $this->validate();

        // Additional validation before update
        $isValidCrime = collect($this->availableCrimes)
            ->first(function ($crime) {
                return strtolower($crime['crime_name']) === strtolower($this->search)
                    && $crime['id'] === $this->crime;
            });

        if (!$isValidCrime) {
            $this->addError('search', 'Please select a valid crime from the list.');
            return;
        }

        try {
            // Get the crime relationship through the pivot
            $prisonerCrime = Prisoner::findOrFail($this->prisonerID)
                ->crimes()
                ->wherePivot('id', $this->prisonerCrimeId)
                ->first();

            // Store old values
            $oldValues = [
                'crime_id' => $prisonerCrime->pivot->crime_id,
                'committed_date' => $prisonerCrime->pivot->committed_date,
                'additional_notes' => $prisonerCrime->pivot->additional_notes,
            ];

            // Update the pivot record
            $prisonerCrime->pivot->update([
                'crime_id' => $this->crime,
                'committed_date' => $this->committed_date,
                'additional_notes' => $this->additional_notes,
            ]);

            $prisonerCrime = Prisoner::findOrFail($this->prisonerID);

            activity()
                ->performedOn($prisonerCrime)
                ->causedBy(Auth::user())
                ->withProperties([
                    'old' => $oldValues,
                    'attributes' => [
                        'crime_id' => $this->crime,
                        'committed_date' => $this->committed_date,
                        'additional_notes' => $this->additional_notes,
                    ]
                ])
                ->event('updated')
                ->log("Updated Crime ID {$this->prisonerCrimeId} for Prisoner ID {$this->prisonerID}");

            session()->flash('success', 'Crime updated successfully');
        } catch (Exception $e) {
            session()->flash('error', 'Error: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.prisoner-update-crime');
    }
}
