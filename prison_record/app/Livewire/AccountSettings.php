<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class AccountSettings extends Component
{
    public $username;
    public $firstName;
    public $lastName;
    public $email;

    public function mount()
    {
        $user = Auth::user();
        $this->username = $user->username;
        $this->firstName = $user->firstName;
        $this->lastName = $user->lastName;
        $this->email = $user->email;
    }

    protected function rules()
    {
        return [
            'username' => 'required|min:2|max:50|unique:users,username,'. Auth::id(),
            'firstName' => 'required|min:2|max:255',
            'lastName' => 'required|min:2|max:255',
            'email' => 'required|email|max:80|unique:users,email,' . Auth::id(),
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function updateProfile()
    {
        $validatedData = $this->validate();

        $user = Auth::user();
        $user->update([
            'username' => $this->username,
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'email' => $this->email,
        ]);

        session()->flash('message', 'Profile updated successfully!');
        $this->dispatch('profile-updated');
    }

    public function render()
    {
        return view('livewire.account-settings');  // Point to the component view
    }
}