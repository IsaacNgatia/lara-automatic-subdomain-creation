<?php

namespace App\Livewire\Admins\Auth;

use App\Models\Admin;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class ResetPassword extends Component
{
    public $email;
    public $token;
    public $password;
    public $password_confirmation;

    public function mount($token)
    {
        $this->token = $token;
        // $this->email = $email;
    }

    public function resetPassword()
    {
        $this->validate([
            'password' => 'required|min:6|confirmed',
        ]);

        $status = Password::broker('admins')->reset(
            [
                'email' => $this->email,
                'password' => $this->password,
                'password_confirmation' => $this->password_confirmation,
                'token' => $this->token
            ],
            function (Admin $admin) {
                $admin->forceFill([
                    'password' => Hash::make($this->password),
                ])->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            session()->flash('success', 'Password reset successfully! You can now login.');
            return redirect()->route('admin.login');
        } else {
            session()->flash('error', 'Invalid token or email.');
        }
    }
    public function render()
    {
        return view('livewire.admins.auth.reset-password');
    }
}
