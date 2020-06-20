<?php

namespace App\Http\Livewire\Auth;

use Livewire\Component;

class Login extends Component
{
    public $email;
    public $password;
    public $remember;

    /**
     * Action on form submit
     *
     * @return void
     */
    public function submit()
    {
        $this->validate([
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'min:8']
        ]);

        $auth = auth()->attempt(['email' => $this->email, 'password' => $this->password], $this->remember);

        return $auth
            ? redirect(route('home'))
            : redirect()->back()->with('error', 'The credentials do not exist in our database');
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
