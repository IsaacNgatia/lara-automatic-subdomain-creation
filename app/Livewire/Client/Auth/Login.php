<?php

namespace App\Livewire\Client\Auth;

use Livewire\Component;

class Login extends Component
{
    public string $username;
    public string $password;


    protected $rules = [
        'username' => 'required|string',
        'password' => 'required|min:6',
    ];
    public function submit()
    {
        $fields = $this->validate();

        if (auth()->guard('client')->attempt(['username' => $this->username, 'password' => $this->password])){
            return redirect()->route('client.overview');
        }

        // if (! Auth::attempt($fields)) {
        //     $this->addError('email', 'Invalid email or password');

        //     return;
        // }

        // session()->regenerate();

        // return redirect()->route('account.profile');

        session()->flash('error', 'Invalid credentials.');
    }
    public function render()
    {
        return view('livewire.client.auth.login');
    }

}
