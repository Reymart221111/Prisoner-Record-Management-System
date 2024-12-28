<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Livewire\Component;
use Throwable;

class StoreUserRole extends Component
{
    public $firstName;
    public $lastName;
    public $email;
    public $password;
    public $role;

    public function rules()
    {
        return [
            'firstName' => ['required', 'min:2', 'max:89', 'string'],
            'lastName' => ['required', 'min:2', 'max:89', 'string'],
            'email' => ['required', 'min:2', 'max:89', 'email', 'unique:users,email'],
            'password' => ['required', Password::defaults()],
            'role' => [
                'required',
                'in:' . (Auth::user()->role === 'admin' ? 'employee' : 'admin,employee'),
            ],
        ];
    }


    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function storeUser()
    {
        $validatedData = $this->validate();

        try {
            User::create($validatedData);

            $this->dispatch('UserCreated', [
                'status' => 'success',
                'message' => 'User created succesfully'
            ]);

            $this->dispatch('record-updated');
        } catch (Throwable $th) {
            $this->dispatch('UserCreated', [
                'status' => 'error',
                'message' => 'Error:' . $th,
            ]);
        }
    }
    public function render()
    {
        return view('livewire.store-user-role');
    }
}
