<?php

namespace App\Livewire;

use App\Models\Help;
use Barryvdh\Debugbar\Facades\Debugbar;
use Livewire\Attributes\On;
use Livewire\Component;

class StoreSystemHelp extends Component
{
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


    public function saveSystemHelpArticle()
    {
        $this->authorize('create', Help::class);
        // Add this debug line
        Debugbar::info('Content before validation: ' . $this->content);

        $validatedData = $this->validate();

        Debugbar::info($validatedData);

        if ($validatedData) {
            try {
                Help::create($validatedData);
                $this->reset();
                $this->dispatch('trix-reset');
                session()->flash('success', 'Help article created successfully.');
                $this->dispatch('help-created', ['status' => 'success', 'message' => 'Help article created successfully.']);
            } catch (\Throwable $th) {
                Debugbar::error($th);
                $this->dispatch('help-created', ['error' => 'success', 'message' => 'Error:' . $th->getMessage()]);
            }
        }
    }

    #[On('help-created')]
    public function HandleStoredEvent($event)
    {
        if ($event['status'] === 'success') {
            session()->flash('success', $event['message']);
        } else {
            session()->flash('error', $event['message']);
        }
    }


    public function render()
    {
        $this->authorize('create', Help::class);
        return view('livewire.store-system-help');
    }
}
