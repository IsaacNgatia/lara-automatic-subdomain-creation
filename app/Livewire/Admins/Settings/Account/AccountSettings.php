<?php

namespace App\Livewire\Admins\Settings\Account;

use App\Models\AccountSetting;
use App\Models\Admin;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class AccountSettings extends Component
{
    use WithFileUploads;
    public $logo;
    public $favicon;
    public $name;
    public $email;
    public $url;
    public $phone;
    public $address;
    public $user_url;

    public $admin;

    public $accountSettings;


    public function mount()
    {
        $this->admin =  Admin::where("id", auth()->guard('admin')->user()->id)->first();
        $this->accountSettings = $this->admin->accountSettings;
        $this->logo = $this->accountSettings?->logo;
        $this->favicon = $this->accountSettings?->favicon;
        $this->name = $this->accountSettings?->name;
        $this->email = $this->accountSettings?->email;
        $this->url = $this->accountSettings?->url;
        $this->phone = $this->accountSettings?->phone;
        $this->address = $this->accountSettings?->address;
        $this->user_url = $this->accountSettings?->user_url;
    }

    public function updateAccountInformation()
    {
        try {

            AccountSetting::updateOrCreate(
                ['admin_id' => $this->admin->id],
                [
                    'name' => $this->name,
                    'email' => $this->email,
                    'url' => $this->url,
                    'phone' => $this->phone,
                    'address' => $this->address,
                    'user_url' => $this->user_url,
                ]
            );
            session()->flash('success', 'Settings updated successfully.');
            return back();
        } catch (\Throwable $th) {
            session()->flash('error', $th->getMessage());
        }
    }

    public function updateLogo()
    {
        $this->validate([
            'logo' => 'image|max:2048',
        ]);

        $path = $this->logo->store('logos', 'public');
        if ($this->accountSettings?->logo) {
            Storage::disk('public')->delete($this->accountSettings->logo);
        }

        try {
            AccountSetting::updateOrCreate(
                ['admin_id' => $this->admin->id],
                [
                    'logo' => $path,
                ]
            );
            $this->reset('logo');
            $this->accountSettings = $this->admin->accountSettings;
            session()->flash('success', 'Logo updated successfully.');
            return back();
        } catch (\Throwable $th) {
            session()->flash('error', $th->getMessage());
        }
    }
    public function updateFavicon() {
        $this->validate([
            'favicon' => 'image|max:1024',
        ]);

        $path = $this->favicon->store('favicons', 'public');
        if ($this->accountSettings?->favicon) {
            Storage::disk('public')->delete($this->accountSettings->favicon);
        }

        try {
            AccountSetting::updateOrCreate(
                ['admin_id' => $this->admin->id],
                [
                    'favicon' => $path,
                ]
            );
            $this->reset('favicon');
            $this->accountSettings = $this->admin->accountSettings;
            session()->flash('success', 'Favicon updated successfully.');
            return back();
        } catch (\Throwable $th) {
            session()->flash('error', $th->getMessage());
        }
    }
    public function render()
    {
        return view('livewire.admins.settings.account.account-settings');
    }
}
