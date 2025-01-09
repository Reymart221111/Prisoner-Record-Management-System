<?php

namespace App\Livewire;

use App\Models\Prisoner;
use Auth;
use Livewire\Component;

class PrisonerActionButton extends Component
{
    public $prisonerId;
    public $page;

    public function mount($prisonerId, $page = 1)
    {
        // $prisoner = Prisoner::findOrFail($prisonerId);
        
        // // Fix: Pass both the action and the model instance
        // if (!Auth::user()->can('delete', $prisoner)) {
        //     abort(403, 'Unauthorized!');
        // }
        
        $this->prisonerId = $prisonerId;
        $this->page = $page;
    }

    public function deletePrisoner()
    {
        $prisoner = Prisoner::findOrFail($this->prisonerId);
        $this->authorize('delete', $prisoner);

        $prisoner->delete();

        return redirect(request()->header('Referer'))->with('success','Prisoner deleted successfully');
    }

    public function render()
    {
        $prisoner = Prisoner::findOrFail($this->prisonerId);
        return view('livewire.prisoner-action-button', compact('prisoner'));
    }
}
