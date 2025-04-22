<?php

namespace App\Livewire\Admins\Auth;

use App\Models\AccountSetting;
use Livewire\Component;

class Login extends Component
{
    public string $email;
    public string $password;
    public $title;


    protected $rules = [
        'email' => 'required|email',
        'password' => 'required|min:6',
    ];
    protected $messages = [
        'email.required' => 'Please enter your email to login.',
        'email.email' => 'Please enter a valid email to login.',
        'password.required' => 'Please enter your password to login.',
    ];
    public function mount()
    {
        $this->title = AccountSetting::where('key', 'account_title')->first()->value;
    }
    public function submit()
    {
        $fields = $this->validate();

        if (auth()->guard('admin')->attempt(['email' => $this->email, 'password' => $this->password])) {
            return redirect()->route('admin.dashboard');
        }

        // if (! Auth::attempt($fields)) {
        //     $this->addError('email', 'Invalid email or password');

        //     return;
        // }

        // session()->regenerate();

        // return redirect()->route('account.profile');

        session()->flash('error', 'Invalid credentials.');
    }

    public function sendPasswordRecoveryEmail()
    {
        dd('Please Wait');
    }
    public function render()
    {
        return view('livewire.admins.auth.login');
    }
}
