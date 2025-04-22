<?php

namespace App\Livewire\Admins\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Password;

class PasswordRecovery extends Component
{
    public $email;

    protected $rules = [
        'email' => 'required|email|exists:admins,email',
        // 'email' => 'required|email|exists:admins, email',
    ];

    protected $messages = [
        'email.required' => 'The email field is required.',
        'email.email' => 'The email must be a valid email address.',
        'email.exists' => 'This email does not exists.'
    ];

    public function sendResetLink()
    {
        $this->validate();
        $status = Password::broker('admins')->sendResetLink([
            'email' => $this->email
        ]);

        if ($status === Password::RESET_LINK_SENT) {
            session()->flash('success', 'Password reset link sent!');
        } else {
            session()->flash('error', 'Something went wrong!');
        }
    }
    public function render()
    {
        return view('livewire.admins.auth.password-recovery');
    }
}
