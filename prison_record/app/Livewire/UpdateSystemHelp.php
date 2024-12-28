<?php

namespace App\Livewire;

use App\Models\Help;
use Livewire\Attributes\On;
use Livewire\Component;

class UpdateSystemHelp extends Component
{
    public $helpId;
    public $title;
    public $content;

    public function rules()
    {
        return [
            'title' => ['required', 'string', 'max:200'],
            'content' => ['required', 'string', 'max:10000']
        ];
    }

    public function updatedTitle()
    {
        $this->validateOnly('title');
    }

    public function updatedContent()
    {
        $this->validateOnly('content');
    }


    public function mount($helpId)
    {
        $this->helpId = $helpId;
        $help = Help::findOrFail($helpId);
        $this->title = $help->title;
        $this->content = $help->content;
    }
    
    public function updateSystemHelpArticle()
    {
        $this->authorize('update', Help::class);
        $validatedData = $this->validate();

        if ($validatedData) {
            try {
                $help = Help::findOrFail($this->helpId);
                $help->update($validatedData);
                session()->flash('success', 'Help article updated successfully.');
                $this->dispatch('help-updated', ['status' => 'success', 'message' => 'Help article updated successfully.']);
            } catch (\Throwable $th) {
                $this->dispatch('help-updated', ['error' => 'success', 'message' => 'Error:' . $th->getMessage()]);
            }
        }
    }

    #[On('help-updated')]
    public function HandleStoredEvent($event)
    {
        if ($event['status'] === 'success') {
            session()->flash('success', $event['message']);
            $this->dispatch('scroll-top');
        } else {
            session()->flash('error', $event['message']);
        }
    }
    
    public function render()
    {
        $this->authorize('update', Help::class);
        return view('livewire.update-system-help');
    }
}
