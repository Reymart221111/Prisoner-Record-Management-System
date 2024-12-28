<?php

namespace App\Livewire;

use App\Models\Crime;
use Illuminate\Validation\Rule;
use Livewire\Component;

class UpdateCrime extends Component
{
    public $id;
    public $crime_name;

    public function rules()
    {
        return [
            'crime_name' => [Rule::unique('crimes', 'crime_name')->ignore($this->id), 'string', 'max:191', 'required']
        ];
    }

    public function mount($crimeId)
    {
        $crime = Crime::findOrFail($crimeId);

        $this->id = $crime->id;
        $this->crime_name = $crime->crime_name;
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function updateCrime()
    {
        $crime = Crime::findOrFail($this->id);
        $validatedData = $this->validate();

        try {
            $crime->update($validatedData);
            session()->flash('success', 'Crime Updated Succesfully');
        } catch (\Exception $e) {
            session()->flash('error', 'Error:' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.update-crime');
    }
}
