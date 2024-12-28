<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class ViewUserPermissions extends Component
{
    use WithPagination;

    public $search = '';
    public $sortField = '';
    public $sortDirection = 'asc';

    // Reset pagination when search changes
    public function updatingSearch()
    {
        $this->resetPage();
    }

    #[On('UserCreated')]
    public function handleUserCreatedEvent($event)
    {
        if ($event['status'] === 'success') {
            session()->flash('success', $event['message']);
        } else {
            session()->flash('error', $event['message']);
        }
    }

    #[On('userUpdated')]
    public function handleUserUpdatedEvent($event)
    {
        if ($event['status'] === 'success') {
            session()->flash('success', $event['message']);
        } else {
            session()->flash('error', $event['message']);
        }
    }

    public function deleteUser($userId)
    {
        $user = User::findOrFail($userId);

        try {
            $user->delete();
            session()->flash('success', 'Record Deleted Successfully');
        } catch (\Throwable $th) {
            session()->flash('error', 'Error:' . $th->getMessage());
        }
    }

    public function render()
    {
        $users = User::select('id', 'firstName', 'lastName', 'email', 'imgPath', 'role', 'created_at', 'updated_at')
            ->when($this->search, function($query) {
                $query->where(function($query) {
                    $query->where('firstName', 'like', '%' . $this->search . '%')
                        ->orWhere('lastName', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%')
                        ->orWhere('role', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->sortField, function($query) {
                if ($this->sortField === 'name') {
                    $query->orderBy('firstName', $this->sortDirection)
                          ->orderBy('lastName', $this->sortDirection);
                } else {
                    $query->orderBy($this->sortField, $this->sortDirection);
                }
            });

        return view('livewire.view-user-permissions', [
            'users' => $users->paginate(20)
        ]);
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
}
