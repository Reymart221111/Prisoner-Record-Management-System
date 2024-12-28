<?php

namespace App\Livewire;

use App\Models\PrisonerParole;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use Throwable;

class ViewPrisonerParoleList extends Component
{
    use WithPagination;

    public $paroleId;
    public $search = '';
    public $paroleType = '';
    public $sortField = '';
    public $sortDirection = 'asc';

    // Reset pagination when search/filter changes
    public function updating($name)
    {
        if (in_array($name, ['search', 'paroleType', 'sortField'])) {
            $this->resetPage();
        }
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    #[On('parole-stored')]
    public function handleParoleStore($event)
    {
        if ($event['status'] === 'success') {
            session()->flash('success', $event['message']);
        } else {
            session()->flash('error', $event['message']);
        }
    }

    #[On('parole-updated')]
    public function handleParoleUpdate($event)
    {
        if ($event['status'] === 'success') {
            session()->flash('success', $event['message']);
        } elseif ($event['status'] === 'error') {
            session()->flash('error', $event['message']);
        }
    }

    public function deleteParole($paroleId)
    {
        try {
            $parole = PrisonerParole::findOrFail($paroleId);
            $parole->delete();

            session()->flash('success', 'Record Deleted Successfully');
        } catch (Throwable $th) {
            session()->flash('error', 'Error: ' . $th->getMessage());
        }
    }

    public function render()
    {
        $query = PrisonerParole::with('prisoner')
            ->when($this->search, function ($query) {
                $query->whereHas('prisoner', function ($q) {
                    $q->where('first_name', 'like', '%' . $this->search . '%')
                        ->orWhere('last_name', 'like', '%' . $this->search . '%')
                        ->orWhere('prisoner_id', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->paroleType, function ($query) {
                $query->where('parole_type', $this->paroleType);
            })
            ->when($this->sortField, function ($query) {
                switch ($this->sortField) {
                    case 'name':
                        // Join with prisoners table to sort by name
                        $query->join('prisoners', 'prisoner_paroles.prisoner_id', '=', 'prisoners.id')
                            ->orderBy('prisoners.first_name', $this->sortDirection)
                            ->orderBy('prisoners.last_name', $this->sortDirection)
                            ->select('prisoner_paroles.*'); // Important to select only from primary table
                        break;

                    case 'id':
                        // Join with prisoners table to sort by prisoner_id
                        $query->join('prisoners', 'prisoner_paroles.prisoner_id', '=', 'prisoners.id')
                            ->orderBy('prisoners.prisoner_id', $this->sortDirection)
                            ->select('prisoner_paroles.*');
                        break;

                    case 'sentence_reduction':
                        $query->orderBy('sentence_reduction', $this->sortDirection);
                        break;

                    case 'created_at':
                        $query->orderBy('created_at', $this->sortDirection);
                        break;

                    default:
                        $query->latest();
                }
            }, function ($query) {
                $query->latest();
            });

        return view('livewire.view-prisoner-parole-list', [
            'prisonerParoles' => $query->paginate(10),
        ]);
    }
}
