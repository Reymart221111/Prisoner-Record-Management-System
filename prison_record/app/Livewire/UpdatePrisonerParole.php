<?php

namespace App\Livewire;

use App\Enums\ParoleStatus;
use App\Models\Prisoner;
use App\Models\PrisonerParole;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Livewire\Attributes\On;
use Livewire\Component;

class UpdatePrisonerParole extends Component
{
    public $availablePrisoners;
    public $parole_type;
    public $prisoner;
    public $sentence_reduction;
    public $prisoner_id;
    public $search = '';
    public $parole;
    public $paroleId;

    #[On('editParole')]
    public function handleEditParoleEvent($paroleId)
    {
        $this->resetValidation();

        $this->paroleId = $paroleId;
        $this->parole = PrisonerParole::with('prisoner')->findOrFail($paroleId);
        $this->prisoner_id = $this->parole->prisoner_id;
        $this->parole_type = $this->parole->parole_type;
        $this->sentence_reduction = $this->parole->sentence_reduction;
        $this->search = $this->parole->prisoner->prisoner_id;

        debugbar()->info('Parole data loaded', [
            'paroleId' => $this->paroleId,
            'parole' => $this->parole,
            'prisoner_id' => $this->prisoner_id,
            'parole_type' => $this->parole_type,
            'sentence_reduction' => $this->sentence_reduction
        ]);
    }
    
    public function resetValidation($field = null)
    {
        debugbar()->info('Validation reset triggered');
        parent::resetValidation($field);
    }

    public function rules()
    {
        return [
            'prisoner_id' => ['required', 'exists:prisoners,id'],
            'parole_type' => ['required', new Enum(ParoleStatus::class)],
            'sentence_reduction' => ['required', 'numeric', 'min:1'],
            'search' => ['required', 'string']
        ];
    }

    public function messages()
    {
        return [
            'search.required' => 'Prisoner id cannot be empty',
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);

        if ($propertyName === 'search') {
            $matchingPrisoner = collect($this->availablePrisoners)
                ->firstWhere(function ($prisoner) {
                    return strtolower($prisoner['prisoner_id']) === strtolower($this->search);
                });

            if (!$matchingPrisoner) {
                $this->addError('search', 'Please select a valid prisoner id from the list');
            }
        }
    }

    public function mount()
    {
        $this->parole = PrisonerParole::with('prisoner')->find($this->paroleId);
        if ($this->parole) {
            $this->prisoner_id = $this->parole->prisoner_id;
            $this->parole_type = $this->parole->parole_type;
            $this->sentence_reduction = $this->parole->sentence_reduction;
            $this->search = $this->parole->prisoner->prisoner_id;
        }

        $this->availablePrisoners = Prisoner::select('id', 'prisoner_id', 'first_name', 'last_name')
            ->get()
            ->map(function ($prisoner) {
                return [
                    'id' => $prisoner->id,
                    'prisoner_id' => $prisoner->prisoner_id,
                    'first_name' => $prisoner->first_name,
                    'last_name' => $prisoner->last_name
                ];
            })
            ->values()
            ->toArray();
    }

    public function updateParole()
    {
        $this->validate();

        try {
            $parole = PrisonerParole::findOrFail($this->paroleId);

            $parole->update([
                'prisoner_id' => $this->prisoner_id,
                'parole_type' => $this->parole_type,
                'sentence_reduction' => $this->sentence_reduction
            ]);

            $this->dispatch('parole-updated', [
                'status' => 'success',
                'message' => 'Record Updated Succesfully',
                'data' => $parole,
            ]);
        } catch (\Throwable $th) {
            $this->dispatch('parole-updated', [
                'status' => 'error',
                'message' => 'Error:' . $th->getMessage(),
            ]);
        }
    }

    public function render()
    {
        return view('livewire.update-prisoner-parole', ['availablePrisoners' => $this->availablePrisoners,]);
    }
}
