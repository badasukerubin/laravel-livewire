<?php

namespace App\Http\Livewire\Auth;

use App\User;
use Livewire\Component;
use Illuminate\Auth\Events\Registered;

class Register extends Component
{
    public $name;
    public $email;
    public $password;
    public $password_confirmation;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */

    /**
     * Component has updated
     *
     * @param $field
     * @return void
     */
    public function updated($field)
    {
        $this->validateOnly($field, [
            'email' => ['email', 'max:255', 'unique:users'],
            'password' => ['min:8']
        ]);
    }

    /**
     * Action on form submit
     *
     * @return void
     */
    public function submit()
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'min:8', 'confirmed']
        ]);

        event(new Registered($this->create()));

        auth()->attempt(['email' => $this->email, 'password' => $this->password]);

        return redirect(route('home'));
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create()
    {
        return User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
        ]);
    }

    public function render()
    {
        return view('livewire.auth.register');
    }
}
