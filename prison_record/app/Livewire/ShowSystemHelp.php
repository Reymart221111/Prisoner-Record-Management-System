<?php

namespace App\Livewire;

use App\Models\Help;
use Livewire\Component;

class ShowSystemHelp extends Component
{
    public $helpId;
    public $help;

    public function mount($helpId)
    {
        $this->helpId = $helpId;
        $this->help = Help::find($helpId);
        debugbar()->info('id:'.$this->helpId);
    }
  
    public function render()
    {
        $this->authorize('view', Help::class);
        return view('livewire.show-system-help', ['help' => $this->help]);
    }
}