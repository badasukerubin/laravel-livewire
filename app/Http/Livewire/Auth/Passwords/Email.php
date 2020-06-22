<?php

namespace App\Http\Livewire\Auth\Passwords;

use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Support\Facades\Password;
use Livewire\Component;

class Email extends Component
{
    public $email;

    /**
     * Action on form submit
     *
     * @return void
     */
    public function submit()
    {
        $this->validate([
            'email' => ['required', 'string', 'email', 'max:255'],
        ]);

        $response = Password::sendResetLink(['email' => $this->email]);

        return $response == Password::RESET_LINK_SENT
            ? redirect()->back()->with('status', trans($response))
            : redirect()->back()->with('error', trans($response));
    }

    public function render()
    {
        return view('livewire.auth.passwords.email');
    }
}
