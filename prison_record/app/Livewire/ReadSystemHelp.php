<?php

namespace App\Livewire;

use App\Models\Help;
use Livewire\Component;
use Livewire\WithPagination;

class ReadSystemHelp extends Component
{
    use WithPagination;
    
    public $search = '';

    protected $queryString = ['search'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function resetPage()
    {
        $this->reset('search');
    }

    public function deleteArticle($id)
    {
        $help = Help::find($id);
        $help->delete();
        session()->flash('success', 'Help article deleted successfully.');
    }

    public function render()
    {
        $helps = Help::select('id', 'title', 'content', 'updated_at')->when($this->search, function ($query) {
            $query->where('title', 'like', "%{$this->search}%")
                ->orWhere('content', 'like', "%{$this->search}%");
        })->paginate(10);
        return view('livewire.read-system-help', ['helps' => $helps]);
    }
}
