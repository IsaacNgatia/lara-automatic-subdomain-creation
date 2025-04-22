<?php

namespace App\Livewire\Admins\Dashboard;

use Livewire\Component;

class AdminLogs extends Component
{
    public function mount()
    {

        // dd($this->adminLogs);
    }

    public function render()
    {
        $logs = \App\Models\AdminLog::latest()
            ->where('action', 'Login')
            ->join('admins', 'admins.id', '=', 'admin_logs.admin_id')
            ->select(
                'admin_logs.*',
                'admins.username as admin_name',
                'admins.email as admin_email',
                'admins.profile_photo_path as admin_profile'
            )
            ->paginate(4);
        return view('livewire.admins.dashboard.admin-logs', ['adminLogs' => $logs]);
    }
}
