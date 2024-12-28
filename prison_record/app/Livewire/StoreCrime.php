<?php

namespace App\Livewire;

use App\Models\Crime;
use Exception;
use Livewire\Component;

class StoreCrime extends Component
{
    public $crime_name;

    public function rules()
    {
        return [
            'crime_name' => ['required', 'string', 'max:191', 'unique:crimes,crime_name']
        ];
    }
    

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function saveCrime()
    {
        $validatedData = $this->validate();

        try{
            Crime::create($validatedData);
            $this->reset();
            session()->flash('success', 'Crimes Added Succesfully');
        } catch (Exception $e)
        {
            session()->flash('error', 'Error Creating Crimes:'.$e->getMessage());
        }
    }
    public function render()
    {
        return view('livewire.store-crime');
    }
}
