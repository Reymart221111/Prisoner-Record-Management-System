<?php

namespace App\Livewire;

use App\Models\TransfferedPrisoner;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class ViewTransfferedPrisoners extends Component
{
    use WithPagination;

    public $search = '';
    public $sortField = '';
    public $date_from = '';
    public $date_to = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'sortField' => ['except' => ''],
        'date_from' => ['except' => ''],
        'date_to' => ['except' => '']
    ];

    #[On('record-updated')]
    public function handleUpdateEvent($event)
    {
        if ($event['status'] === 'success') {
            session()->flash('success', $event['message']);
        } elseif ($event['status'] === 'error') {
            session()->flash('error', $event['message']);
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $transfferedPrisoners = TransfferedPrisoner::with('prisoner')
            ->when($this->search, function ($query) {
                $query->whereHas('prisoner', function ($subQuery) {
                    $subQuery->where('first_name', 'like', '%' . $this->search . '%')
                        ->orWhere('last_name', 'like', '%' . $this->search . '%')
                        ->orWhere('prisoner_id', 'like', '%' . $this->search . '%');
                })
                    ->orWhere('death_cause', 'like', '%' . $this->search . '%');
            })
            ->when($this->date_from, function ($query) {
                $query->whereDate('transfer_date', '>=', $this->date_from);
            })
            ->when($this->date_to, function ($query) {
                $query->whereDate('transfer_date', '<=', $this->date_to);
            })
            ->when($this->sortField, function ($query) {
                switch ($this->sortField) {
                    case 'name':
                        $query->select('transffered_prisoners.*')
                            ->join('prisoners', 'transffered_prisoners.prisoner_id', '=', 'prisoners.id')
                            ->orderBy('prisoners.last_name')
                            ->orderBy('prisoners.first_name');
                        break;
                    case 'id':
                        $query->select('transffered_prisoners.*')
                            ->join('prisoners', 'transffered_prisoners.prisoner_id', '=', 'prisoners.id')
                            ->orderBy('prisoners.prisoner_id');
                        break;
                    case 'transfer_date':
                        $query->orderBy('transfer_date');
                        break;
                    case 'created_at':
                        $query->orderBy('created_at');
                        break;
                    default:
                        $query->orderBy('created_at', 'desc');
                }
            });

        return view('livewire.view-transffered-prisoners', [
            'transfferedPrisoners' => $transfferedPrisoners->paginate(10)
        ]);
    }
}
