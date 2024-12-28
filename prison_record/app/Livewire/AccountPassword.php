<?php

namespace App\Livewire;

use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Livewire\Component;

class AccountPassword extends Component
{
    public $current_password;
    public $password;
    public $password_confirmation;

    protected function rules()
    {
        return [
            'current_password' => 'required|current_password',
            'password' => ['required', Password::defaults()],
            'password_confirmation' => ['required', 'same:password'],
        ];
    }

    protected $messages = [
        'current_password.current_password' => 'The current password is incorrect.',
        'password_confirmation.same' => 'The password confirmation does not match.',
    ];

    public function updated($propertyName)
    {
        // If updating password field, only validate password requirements
        if ($propertyName === 'password') {
            $this->validateOnly('password', [
                'password' => ['required', Password::defaults()]
            ]);
        }

        // If updating confirmation field, validate the match
        if ($propertyName === 'password_confirmation' && !empty($this->password_confirmation)) {
            $this->validateOnly('password_confirmation', [
                'password_confirmation' => ['required', 'same:password']
            ]);
        }
    }

    public function updatePassword()
    {
        // Full validation on form submission
        $this->validate();

        Auth::user()->update([
            'password' => Hash::make($this->password)
        ]);

        $this->reset(['current_password', 'password', 'password_confirmation']);

        session()->flash('message', 'Password updated successfully!');
    }

    public function render()
    {
        return view('livewire.account-password');
    }
}
