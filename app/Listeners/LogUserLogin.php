<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogUserLogin
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        // dd($_SERVER);
        //Access the logged in user
        $user = $event->user;
        // Log the user's login details in the admin logs table
        \App\Models\AdminLog::create([
            'admin_id' => $user->id,
            'action' => 'Login',
            'entity_type' => 'admin',
            'entity_id' => $user->id,
            'ip_address' => request()->ip(),
            'status' => 'success',
            'description' => "Admin: {$user->username} logged in from IP address: " . request()->ip(),
            'user_agent' => $this->getBriefBrowserInfo(request()->userAgent()),
            'platform' => $this->getOS($_SERVER['HTTP_USER_AGENT']),
        ]);
    }
    // Function to get OS name from user agent
    private function getOS($ua)
    {
        $osName = '';
        $os_array = array(
            '/windows nt 10/i'      => 'Windows 10',
            '/windows nt 6.3/i'     => 'Windows 8.1',
            '/windows nt 6.2/i'     => 'Windows 8',
            '/windows nt 6.1/i'     => 'Windows 7',
            '/windows nt 6.0/i'     => 'Windows Vista',
            '/windows nt 5.2/i'     => 'Windows Server 2003/XP x64',
            '/windows nt 5.1/i'     => 'Windows XP',
            '/windows nt 5.0/i'     => 'Windows 2000',
            '/windows me/i'         => 'Windows ME',
            '/win98/i'              => 'Windows 98',
            '/win95/i'              => 'Windows 95',
            '/win16/i'              => 'Windows 3.11',
            '/macintosh|mac os x/i' => 'Mac OS X',
            '/mac_powerpc/i'        => 'Mac OS 9',
            '/linux/i'              => 'Linux',
            '/ubuntu/i'             => 'Ubuntu',
            '/iphone/i'             => 'iPhone',
            '/ipod/i'               => 'iPod',
            '/ipad/i'               => 'iPad',
            '/android/i'            => 'Android',
            '/blackberry/i'         => 'BlackBerry',
            '/webos/i'              => 'Mobile'
        );

        foreach ($os_array as $regex => $value) {
            if (preg_match($regex, $ua)) {
                $osName = $value;
                break;
            }
        }
        return $osName != '' ? $osName : "Other";
    }
    private function getBriefBrowserInfo($userAgent)
    {
        $pattern = '/(Firefox|Chrome|Safari|Edge|IE|Opera)\//';

        if (preg_match($pattern, $userAgent, $matches)) {
            $browser = $matches[0];
            $version = substr($userAgent, strpos($userAgent, $browser) + strlen($browser));
            $version = explode('/', $version)[0];

            return "$browser $version";
        }

        return 'Unknown';
    }
}
