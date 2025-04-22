<?php

namespace App\Livewire\Admins\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;

class Login extends Component
{
    public string $email;
    public string $password;


    protected $rules = [
        'email' => 'required|email',
        'password' => 'required|min:6',
    ];
    protected $messages = [
        'email.required' => 'Please enter your email to login.',
        'email.email' => 'Please enter a valid email to login.',
        'password.required' => 'Please enter your password to login.',
    ];
    
public function submit()
{
    $fields = $this->validate(); // Validate form inputs (email, password)

    // Get the user from the admin table
    $user = Admin::where('email', $this->email)->first();

    // Get the current host
    $currentHost = request()->getHost();
    \Log::info('Current host:', ['host' => $currentHost]);

    // Determine if the current host is the main domain
    $isMainDomain = in_array($currentHost, ['ispkenya.xyz', 'localhost', '127.0.0.1']);
    \Log::info('Is main domain:', ['isMainDomain' => $isMainDomain]);

    // Check if user exists
    if (!$user) {
        \Log::info('User not found for email:', ['email' => $this->email]);
        session()->flash('error', 'Invalid credentials.');
        return redirect()->route('admin.login');
    }

    // Log user subdomain for debugging
    \Log::info('User subdomain:', ['subdomain' => $user->subdomain]);

    // Case 1: User has subdomain, must use subdomain
    if (!empty($user->subdomain) && $isMainDomain) {
        \Log::info('User has subdomain and is on main domain, redirecting to login');
        session()->flash('error', 'Invalid credentials.');
        return redirect()->route('admin.login');
    }

    // Case 2: User has no subdomain, must use main domain
    if (empty($user->subdomain) && !$isMainDomain) {
        \Log::info('User has no subdomain and is on subdomain, redirecting to login');
        session()->flash('error', 'Invalid credentials.');
        return redirect()->route('admin.login');
    }

    // Attempt authentication
    \Log::info('Attempting authentication for:', ['email' => $this->email]);
    if (auth()->guard('admin')->attempt(['email' => $this->email, 'password' => $this->password])) {
        \Log::info('Authentication successful, redirecting to dashboard');
        return redirect()->route('admin.dashboard');
    }

    // Authentication failed
    \Log::info('Authentication failed');
    session()->flash('error', 'Invalid credentials.');
    return redirect()->route('admin.login');
}
    
    
    // public function submit()
    // {
    //     dd('here');
    //     $fields = $this->validate();

    //     // Get the user first to check their role
    //     $user = Admin::where('email', $this->email)->first();

    //     // Get the current host
    //     $currentHost = request()->getHost();
        
    //     // Check if user exists and has role_id = 3 (subdomain user) AND is trying to login through main domain
    //     if ($user && $user->role_id == 3 && !str_contains($currentHost, '.')) {
    //         session()->flash('error', 'You cannot login through the main domain. Please use your subdomain.');
    //         return;
    //     }

    //     if (auth()->guard('admin')->attempt(['email' => $this->email, 'password' => $this->password])) {
    //         return redirect()->route('admin.dashboard');
    //     }

    //     // if (! Auth::attempt($fields)) {
    //     //     $this->addError('email', 'Invalid email or password');

    //     //     return;
    //     // }

    //     // session()->regenerate();

    //     // return redirect()->route('account.profile');

    //     session()->flash('error', 'Invalid credentials.');
    // }

    public function sendPasswordRecoveryEmail()
    {
        dd('Please Wait');
    }
    public function render()
    {
        return view('livewire.admins.auth.login');
    }
}
