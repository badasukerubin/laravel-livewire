<?php

namespace App\Http\Livewire\Auth;

use Livewire\Component;

class Verify extends Component
{
    public function render()
    {
        if (auth()->user()->hasVerifiedEmail()) {
            redirect(route('home'));
        }

        return view('livewire.auth.verify');
    }

    /**
     * Resend the email verification notification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function resend()
    {
        if (auth()->user()->hasVerifiedEmail()) {
            redirect(route('home'));
        }

        auth()->user()->sendEmailVerificationNotification();

        redirect()->back()->with('resent', true);
    }
}
