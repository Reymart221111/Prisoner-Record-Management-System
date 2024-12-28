<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Throwable;

class UpdateUserPermission extends Component
{
    public $firstName;
    public $lastName;
    public $email;
    public $newPassword = ''; // Changed to newPassword with empty default
    public $role;
    public $recordId;
    public $user;

    protected function rules()
    {
        return [
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $this->recordId],
            'newPassword' => ['nullable', Password::defaults()],
            'role' => 'required|in:superadmin,admin,employee'
        ];
    }

    #[On('editUser')]
    public function handleEditEvent($recordId)
    {
        $this->recordId = $recordId;
        $this->user = User::findOrFail($this->recordId);

        if ($this->user) {
            $this->firstName = $this->user->firstName;
            $this->lastName = $this->user->lastName;
            $this->email = $this->user->email;
            $this->role = $this->user->role;

            debugbar()->info('current role:' . $this->role);
        }
    }

    public function updated($propertyName)
    {
        if ($propertyName === 'newPassword' && !empty($this->newPassword)) {
            $this->validate([
                'newPassword' => $this->rules()['newPassword'],
            ]);
        }

        $this->validateOnly($propertyName);
    }

    public function updateUser()
    {
        $validatedData = $this->validate();

        try {
            $user = User::findOrFail($this->recordId);

            $user->firstName = $validatedData['firstName'];
            $user->lastName = $validatedData['lastName'];
            $user->email = $validatedData['email'];
            $user->role = $validatedData['role'];

            if (!empty($this->newPassword)) {
                $user->password = Hash::make($this->newPassword);
            }

            // Save the changes
            $user->save(); //////Yawa save la ngayan diri update

            $this->dispatch('userUpdated', ['status' => 'success', 'message' => 'Record Updated Succesfully']);
            $this->dispatch('record-updated');
        } catch (Throwable $th) {
            $this->dispatch('user-updated', ['status' => 'error', 'message' => 'Error:' . $th->getMessage()]);
        }
    }

    public function render()
    {
        return view('livewire.update-user-permission');
    }
}
