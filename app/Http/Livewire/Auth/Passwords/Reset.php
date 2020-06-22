<?php

namespace App\Http\Livewire\Auth\Passwords;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Livewire\Component;

class Reset extends Component
{
    public $email;
    public $token;
    public $password;
    public $password_confirmation;
    protected $request;

    public function mount(Request $request)
    {
        $this->request = $request;
        $this->email = $request->email;
        $this->token = $request->token;
    }

    /**
     * Action on form submit
     *
     * @return void
     */
    public function submit()
    {
        $this->validate([
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'min:8', 'confirmed']
        ]);

        $response = Password::reset(['email' => $this->email, 'token' => $this->token, 'password' => $this->password], function ($user, $password) {
            $this->resetPassword($user, $password);
        });

        return $response == Password::PASSWORD_RESET
            ? redirect('/home')
            : redirect()->back()->with('error', trans($response));
    }

    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword  $user
     * @param  string  $password
     * @return void
     */
    protected function resetPassword($user, $password)
    {
        $this->setUserPassword($user, $password);

        $user->save();

        event(new PasswordReset($user));

        auth()->guard()->login($user);
    }

    /**
     * Set the user's password.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword  $user
     * @param  string  $password
     * @return void
     */
    protected function setUserPassword($user, $password)
    {
        $user->password = $password;
    }

    public function render($token = null)
    {
        return view('livewire.auth.passwords.reset')->with(
            ['token' => $token, 'email' => $this->email]
        );
    }
}
