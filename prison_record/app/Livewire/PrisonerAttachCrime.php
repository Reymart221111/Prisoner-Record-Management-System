<?php

namespace App\Livewire;

use App\Models\Crime;
use App\Models\Prisoner;
use Exception;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Spatie\Activitylog\Models\Activity;

class PrisonerAttachCrime extends Component
{
    public $prisonerID;
    public $availableCrimes;
    public $crime;
    public $committed_date;
    public $additional_notes;
    public $search = '';

    // Removed protected $rules and $messages

    public function mount($prisonerID)
    {
        $this->prisonerID = $prisonerID;
        $this->availableCrimes = Crime::pluck('crime_name', 'id')
            ->map(function ($crime_name, $id) {
                return ['id' => $id, 'crime_name' => $crime_name];
            })
            ->values()
            ->toArray();
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);

        if ($propertyName === 'search') {
            $matchingCrime = collect($this->availableCrimes)
                ->firstWhere(fn($crime) => strtolower($crime['crime_name']) === strtolower($this->search));

            $this->crime = $matchingCrime['id'] ?? null;

            if (!$matchingCrime) {
                $this->addError('search', 'Please select a valid crime from the list.');
            }
        }
    }

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

    public function messages()
    {
        return [
            'crime.required' => 'Please select a valid crime from the list',
            'crime.exists' => 'The selected crime is invalid. Please choose a valid crime.',
            'crime.in' => 'The selected crime is not in the available list.',
            'search.required' => 'Please enter a crime name',
            'committed_date.required' => 'The committed date is required.',
            'committed_date.date' => 'The committed date must be a valid date.',
            'additional_notes.string' => 'The additional notes must be a valid string.'
        ];
    }

    public function attachCrime()
    {
        $this->validate();
    
        $prisoner = Prisoner::findOrFail($this->prisonerID);
    
        try {
            // Use the model's method to attach crime and log activity
            $prisoner->attachCrimeWithLogging($this->crime, [
                'committed_date' => $this->committed_date,
                'additional_notes' => $this->additional_notes,
            ]);
    
            session()->flash('success', 'Crime added to prisoner successfully');
    
            // Reset form fields except prisonerID
            $this->reset(['crime', 'committed_date', 'additional_notes', 'search']);
        } catch (Exception $e) {
            // Log the error for debugging
            debugbar()->info("Error attaching crime or logging activity: " . $e->getMessage());
    
            // Provide user-friendly error message
            session()->flash('error', 'An unexpected error occurred while assigning the crime. Please try again.');
        }
    }
    

    public function render()
    {
        return view('livewire.prisoner-attach-crime');
    }
}
