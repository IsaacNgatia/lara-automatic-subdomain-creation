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
    public $prevLogo;
    public $favicon;
    public $name;
    public $email;
    public $adminUrl;
    public $phone;
    public $address;
    public $userUrl;
    public $hotspotTitle;

    public $admin;

    public $accountSettings;


    public function mount()
    {
        $this->logo = AccountSetting::where('key', 'logo_url')->first()->value;
        $this->favicon = AccountSetting::where('key', 'favicon_url')->first()->value;
        $this->name = AccountSetting::where('key', 'account_title')->first()->value;
        $this->email = AccountSetting::where('key', 'email')->first()->value;
        $this->adminUrl = route('admin.dashboard');
        $this->phone = AccountSetting::where('key', 'phone')->first()->value;
        $this->userUrl = route('client.overview');
        $this->hotspotTitle = AccountSetting::where('key', 'hotspot_title')->first()->value;
        $this->prevLogo = $this->logo;
    }

    public function updateAccountInformation()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:255',
            'hotspotTitle' => 'nullable|string|max:255',
            'adminUrl' => 'nullable|string|max:255',
            'userUrl' => 'nullable|string|max:255',
        ]);
        try {

            if ($this->name) {
                AccountSetting::updateOrCreate(
                    ['key' => 'account_title'],
                    ['value' => $this->name]
                );
            }

            if ($this->email) {
                AccountSetting::updateOrCreate(
                    ['key' => 'email'],
                    ['value' => $this->email]
                );
            }
            if ($this->phone) {
                AccountSetting::updateOrCreate(
                    ['key' => 'phone'],
                    ['value' => $this->phone]
                );
            }
            if ($this->hotspotTitle) {
                AccountSetting::updateOrCreate(
                    ['key' => 'hotspot_title'],
                    ['value' => $this->hotspotTitle]
                );
            }

            session()->flash('settingSuccess', 'Settings updated successfully.');
        } catch (\Throwable $th) {
            dd($th);
            session()->flash('settingError', $th->getMessage());
        }
    }
    public function saveLogo()
    {
        $this->validate([
            'logo' => 'image|max:2048',
        ]);

        $path = $this->logo->storeAs(path: 'public/logo', name: 'logo.png');

        try {
            AccountSetting::where('key', 'logo_url')->update([
                'value' => 'logo/logo.png',
            ]);
            session()->flash('logoSuccess', 'Logo updated successfully.');
        } catch (\Throwable $th) {
            session()->flash('logoError', $th->getMessage());
        }
    }
    public function updateFavicon()
    {
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
            session()->flash('logoSuccess', 'Favicon updated successfully.');
            return back();
        } catch (\Throwable $th) {
            session()->flash('logoError', $th->getMessage());
        }
    }
    public function render()
    {
        return view('livewire.admins.settings.account.account-settings');
    }
}
