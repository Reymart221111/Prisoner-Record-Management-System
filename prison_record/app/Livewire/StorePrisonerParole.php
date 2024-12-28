<?php

namespace App\Livewire;

use App\Models\Prisoner;
use App\Models\PrisonerParole;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Throwable;

class StorePrisonerParole extends Component
{
    public $prisonerId;
    public $availblePrisoners;
    public $prisoner;
    public $parole_type;
    public $sentence_reduction;
    public $prisoner_id;
    public $search = '';

    public function rules()
    {
        return [
            'prisoner_id' => ['required', 'exists:prisoners,id'],
            'parole_type' => ['required', 'in:regular,medical'],
            'sentence_reduction' => ['required', 'numeric', 'min:1'],
            'search' => ['required']
        ];
    }

    public function messages()
    {
        return [
            'search.required' => "Prisoner id is required",
        ];
    }

    public function mount()
    {
        $this->availblePrisoners = Prisoner::select('id', 'prisoner_id', 'first_name', 'last_name')
            ->get()
            ->map(function ($prisoner) {
                return [
                    'id' => $prisoner->id,
                    'prisoner_id' => $prisoner->prisoner_id,
                    'first_name' => $prisoner->first_name,
                    'last_name' => $prisoner->last_name,
                ];
            })
            ->values()
            ->toArray();
    }

    public function storeParole()
    {
        $this->validate();
        try {
            $parole = PrisonerParole::create([
                'prisoner_id' => $this->prisoner_id,
                'parole_type' => $this->parole_type,
                'sentence_reduction' => $this->sentence_reduction,
            ]);

            $this->dispatch('parole-stored', [
                'status' => 'success',
                'message' => 'Parole record created successfully',
                'data' => $parole
            ]);
            $this->reset(['prisoner_id', 'parole_type', 'sentence_reduction', 'search']);
        } catch (Throwable $th) {
            $this->dispatch('parole-stored', [
                'status' => 'error',
                'message' => 'Failed to create parole record: ' . $th->getMessage()
            ]);
        }
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);

        if ($propertyName === 'search') {
            $matchingPrisoner = collect($this->availblePrisoners)
                ->firstWhere(fn($prisoner) => strtolower($prisoner['prisoner_id']) === strtolower($this->search));

            $this->prisoner = $matchingPrisoner['id'] ?? null;

            if (!$matchingPrisoner) {
                $this->addError('search', 'Please select a valid prisoner id from the list.');
            }
        }
    }

    public function render()
    {
        return view('livewire.store-prisoner-parole', ['availablePrisoners' => $this->availblePrisoners,]);
    }
}
