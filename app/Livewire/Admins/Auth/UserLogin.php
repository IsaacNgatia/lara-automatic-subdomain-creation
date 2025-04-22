<?php

namespace App\Livewire\Admins\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserLogin extends Component
{
    public $email;
    public $password;

    public function submit()
    {
        // Validate fields
        $this->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Manually check the user from the users table
        $user = DB::table('admins')->where('email', $this->email)->first();

        if ($user && Hash::check($this->password, $user->password)) {
            // Success – store user info in session (or do something else)
            session(['user_id' => $user->id, 'user_name' => $user->name]);
            session()->flash('success', 'Login successful!');
            return redirect()->route('user.dashboard');  // For normal users
        } else {
            session()->flash('error', 'Invalid email or password.');
        }
    }

    public function render()
    {
        return view('livewire.admins.auth.user-login');
    }
}