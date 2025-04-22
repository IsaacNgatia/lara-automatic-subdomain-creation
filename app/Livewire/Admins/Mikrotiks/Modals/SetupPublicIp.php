<?php

namespace App\Livewire\Admins\Mikrotiks\Modals;

use App\Models\Mikrotik;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Carbon\Carbon;

class SetupPublicIp extends Component
{
    // public $files = [];
    public function mount()
    {
        // $this->files = array_filter(Storage::files('public/client-mikrotiks'), function ($file) {
        //     return pathinfo($file, PATHINFO_EXTENSION) === 'rsc';
        // });
    }
    public function createOvpnFiles()
    {
        $createPublicIp = Mikrotik::createOvpnFiles($this->getNextRouterName());
        $this->render();
    }
    private function getNextRouterName()
    {
        // Fetch the latest Mikrotik ID and increment it
        $latestMikrotik = Mikrotik::latest('id')->first();
        $nextId = $latestMikrotik ? $latestMikrotik->id + 1 : 1;

        // Get the APP_URL from the .env file
        $appUrl = config('app.url');

        // Extract subdomain or first part of the domain
        $parsedUrl = parse_url($appUrl);
        $host = $parsedUrl['host'] ?? '';

        // Split the domain into parts
        $parts = explode('.', $host);

        if (count($parts) > 2) {
            // There's a subdomain, use it
            $subdomain = $parts[0];
        } else {
            // No subdomain, use the first part of the domain
            $subdomain = $parts[0];
        }

        // Generate the new router name
        return strtolower($subdomain) . "-mikrotik" . $nextId;
    }

    public function downloadFile($file)
    {
        // Define the allowed directory
        $allowedDirectory = 'public/client-mikrotiks/';

        // Ensure the file is within the allowed directory
        if (!str_starts_with($file, $allowedDirectory)) {
            abort(403, 'Unauthorized file access.');
        }
        Log::info("Downloading file: " . $file); // Log instead of dd()

        if (!Storage::exists($file)) {
            abort(404, 'File not found.');
        }

        return response()->streamDownload(function () use ($file) {
            echo Storage::get($file);
        }, basename($file));
    }


    function formatLastModifiedTime($timestamp)
    {
        $date = Carbon::createFromTimestamp($timestamp);
        $now = Carbon::now(env('APP_TIMEZONE', 'Africa/Nairobi'));

        // If within the last 1 week, return time difference (e.g., "3 hrs ago")
        if ($date->greaterThanOrEqualTo($now->subWeek())) {
            return $date->diffForHumans();
        }

        // If 1 to 2 weeks ago, return "last week"
        if ($date->greaterThanOrEqualTo($now->subWeeks(1))) {
            return 'last week';
        }
        if ($date->greaterThanOrEqualTo($now->subWeeks(2))) {
            return '2 weeks';
        }

        // Otherwise, return formatted datetime
        return $date->format('Y-m-d H:i:s');
    }

    public function render()
    {
        // $files = array_filter(
        //     Storage::files('public/client-mikrotiks'),
        //     function ($file) {
        //         $filename = pathinfo($file, PATHINFO_FILENAME); // Get the filename without extension
        //         return pathinfo($file, PATHINFO_EXTENSION) === 'rsc' && (!str_starts_with($filename, 'demo') && !str_starts_with($filename, 'test'));
        //     }
        // );
        $files = Storage::files('public/client-mikrotiks');

        $filteredFiles = [];

        foreach ($files as $file) {
            $filename = pathinfo($file, PATHINFO_FILENAME);
            $extension = pathinfo($file, PATHINFO_EXTENSION);

            if ($extension === 'rsc' && !str_starts_with($filename, 'demo') && !str_starts_with($filename, 'test')) {
                $filteredFiles[] = [
                    'file' => $file,
                    'last_modified' => Storage::lastModified($file), // Store as timestamp for sorting
                    'last_modified_readable' => date('Y-m-d H:i:s', Storage::lastModified($file)), // Human-readable format
                ];
            }
        }

        // Sort files by last modified time in descending order (newest first)
        usort($filteredFiles, function ($a, $b) {
            return $b['last_modified'] <=> $a['last_modified']; // Descending order
        });




        // Sort files by last modified time in descending order (most recent first)
        // usort($files, function ($a, $b) {
        //     return Storage::lastModified($b) - Storage::lastModified($a);
        // });
        return view('livewire.admins.mikrotiks.modals.setup-public-ip', ['files' => $filteredFiles]);
    }
}
