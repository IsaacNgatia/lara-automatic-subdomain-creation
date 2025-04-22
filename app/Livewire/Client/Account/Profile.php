<?php

namespace App\Livewire\Client\Account;

use App\Livewire\Forms\Client\Account\ProfileForm;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Profile extends Component
{
    public ProfileForm $profileForm;

    public $user;

    public $official_name;
    public $house_number;
    public $email;
    public $phone_number;
    public $monthly_bill;
    public $status;

    public $activeTab = 'profile';

    public $password, $current_password, $confirm;

    public function mount()
    {
        $this->user = auth()->guard('client')->user();
        $this->official_name = $this->user->official_name;
        $this->house_number = $this->user->house_number;
        $this->email = $this->user->email;
        $this->phone_number = $this->user->phone_number;
        $this->monthly_bill = $this->user->monthly_bill;
        $this->status = $this->user->status;
    }
    public function setActiveTab($tab){
        $this->activeTab = $tab;
    }

    public function updateProfile()
    {
        $this->validate([
            'official_name' => 'required|string|max:255',
            // 'house_number' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $this->user->id,
            'phone_number' => 'required|string|max:15',
            'monthly_bill' => 'required|numeric',
            'status' => 'required|string|max:50',
        ]);

        $this->user->update([
            'official_name' => $this->official_name,
            // 'house_number' => $this->house_number,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'monthly_bill' => $this->monthly_bill,
            'status' => $this->status,
        ]);

        session()->flash('message', 'Profile updated successfully.');
    }

    public function updatePassword(){
        $this->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if (!Hash::check($this->current_password, $this->user->password)) {
            session()->flash('error', 'Current password does not match.');
            return;
        }

        $this->user->update([
            'password' => Hash::make($this->password),
        ]);

        session()->flash('message', 'Password updated successfully.');
    }
    public function render()
    {
        return view('livewire.client.account.profile');
    }
}
