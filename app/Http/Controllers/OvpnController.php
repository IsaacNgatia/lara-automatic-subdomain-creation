<?php

namespace App\Http\Controllers;

use App\Models\Mikrotik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use Symfony\Component\HttpFoundation\StreamedResponse;

class OvpnController extends Controller
{
    public function downloadFile($file)
    {
        // Ensure the file exists
        if (!Storage::exists($file)) {
            abort(404, 'File not found.');
        }

        // Return the file as a download response
        return Storage::download($file);
    }
    public function fetchClientFile(Request $request)
    {
        $fileUrl = $request->input('file_url'); // Get file URL from request

        // Extract relevant parts from the URL
        $pattern = "/mikrotik\/openvpn\/([^\/]+)\/([^\/]+)\/(.+)$/";
        if (!preg_match($pattern, $fileUrl, $matches)) {
            return response()->json(['error' => 'Invalid file URL'], 400);
        }

        [$fullMatch, $folderName, $password, $fileName] = $matches;

        // Extract Mikrotik ID from folder name (assumes it's at the end, like "demo_mikrotik1")
        if (!preg_match('/(\d+)$/', $folderName, $idMatches)) {
            return response()->json(['error' => 'Invalid Mikrotik ID'], 400);
        }

        $mikrotikId = $idMatches[1];

        // Validate router ID and password
        // $mikrotik = Mikrotik::find($mikrotikId);
        // if (!$mikrotik || $mikrotik->password !== $password) {
        //     return response()->json(['error' => 'Unauthorized or router not found'], 403);
        // }

        // Define the file path
        $filePath = "/etc/openvpn/client/$folderName/$fileName";

        // Check if file exists
        if (!file_exists($filePath)) {
            return response()->json(['error' => 'File not found'], 404);
        }

        // Return file as response for download
        return response()->file($filePath);
    }
    public function setupRouter(Request $request)
    {
        try {
            $routerName = $request->input('router_name'); // e.g., "adnet-mikrotik2"
            dd($routerName);

            // Get the next available values separately
            $nextApiIp = $this->getNextValue('proxy_pass', ':8728;'); // API IP
            $nextPublicIp = $nextApiIp; // Same IP for API & Public
            $nextApiPort = $this->getNextPort('listen', 8728);  // Next available API port
            $nextPublicPort = $this->getNextPort('listen', 8291); // Next available Public port

            // Debugging Output (Optional)
            // Log::info('New Router Setup:', $newDetails);

            // Update nginx.conf
            $updateNginxResult = $this->updateNginxConfig($routerName, $nextApiIp, $nextPublicIp, $nextApiPort, $nextPublicPort);
            return $updateNginxResult;

            // Execute OpenVPN commands
            $this->runOpenVPNCommands($routerName, $nextApiIp);

            // Restart Nginx
            $process = new Process(['sudo', 'systemctl', 'restart', 'nginx']);
            $process->setTimeout(10);
            $process->run();

            if (!$process->isSuccessful()) {
                throw new \Exception('Failed to restart Nginx: ' . $process->getErrorOutput());
            }

            return response()->json(['message' => 'Router setup completed successfully.', 'data' => $updateNginxResult]);
        } catch (\Exception $e) {
            Log::error('Router setup failed: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to setup router', 'message' => $e->getMessage()], 500);
        }
    }
    private function getNextValue($key, $delimiter)
    {
        $configPath = '/etc/nginx/nginx.conf';
        $contents = File::get($configPath);

        preg_match_all("/$key\s+([\d.]+)$delimiter/", $contents, $matches);

        if (!empty($matches[1])) {
            $lastValue = end($matches[1]); // Get the last matched value
            return $this->incrementValue($lastValue);
        }
    }

    /**
     * Extracts the next available port for a given service type.
     *
     * @param string $key The key to search for (e.g., "listen").
     * @param int $expectedProxyPort The expected proxy pass port (e.g., 8728 for API, 8291 for Public IP).
     * @return int The next available port.
     */
    private function getNextPort($key, $expectedProxyPort)
    {
        $configPath = '/etc/nginx/nginx.conf';
        $contents = File::get($configPath);

        // preg_match_all("/$key\s+(\d+);[\s\S]+?proxy_pass\s+([\d.]+):$expectedProxyPort;/", $contents, $matches);
        preg_match_all("/$key\s+(\d+);[\s\S]{1,70}?proxy_pass\s+([\d.]+):$expectedProxyPort;/", $contents, $matches);


        if (!empty($matches[1])) {
            $lastPort = end($matches[1]); // Get the last used port for this type
            return $this->incrementValue($lastPort);
        }

        // Default starting ports if none exist
        return ($expectedProxyPort == 8728) ? 1000 : 5000;
    }

    /**
     * Updates the nginx.conf file by adding a new router configuration.
     */
    private function updateNginxConfig($routerName, $apiIp, $publicIp, $apiPort, $publicPort)
    {
        $configPath = '/etc/nginx/nginx.conf';
        $contents = File::get($configPath);

        $newBlock = <<<EOL

    server {
        #$routerName - API
        listen     $apiPort;
        proxy_connect_timeout 2s;
        proxy_timeout 1m;
        proxy_pass  $apiIp:8728;
    }

    server {
        #$routerName - Public IP
        listen     $publicPort;
        proxy_connect_timeout 2s;
        proxy_timeout 1m;
        proxy_pass  $publicIp:8291;
    }
EOL;

        // Check if there is an existing "stream { ... }" block
        if (preg_match('/stream\s*{/', $contents, $matches, PREG_OFFSET_CAPTURE)) {
            // Find the position of the closing "}" of the stream block
            $streamStartPos = $matches[0][1];
            $closingBracePos = strrpos(substr($contents, $streamStartPos), '}') + $streamStartPos;

            if ($closingBracePos !== false) {
                // Insert the newBlock before the closing "}" of the stream block
                $contents = substr_replace($contents, "$newBlock\n", $closingBracePos, 0);
            }
        } else {
            // If no stream block is found, add the block before the last closing "}"
            $lastClosingBracePos = strrpos($contents, '}');

            if ($lastClosingBracePos !== false) {
                // Insert before the last closing "}"
                $contents = substr_replace($contents, "$newBlock\n", $lastClosingBracePos, 0);
            } else {
                // If no closing "}" exists, just append the new block
                $contents .= "\n$newBlock\n";
            }
        }

        // Write to file using sudo
        $escapedContent = escapeshellarg($contents);
        shell_exec("echo $escapedContent | sudo tee $configPath > /dev/null");

        return response()->json(['message' => 'Nginx config updated successfully.']);

        // File::put($configPath, $contents);
    }

    /**
     * Increments an IP address or a numeric value.
     */
    private function incrementValue($value)
    {
        if (strpos($value, '.') !== false) {
            // It's an IP address
            $parts = explode('.', $value);
            $parts[3]++; // Increment last octet
            return implode('.', $parts);
        } else {
            // It's a port number
            return (int)$value + 1;
        }
    }


    private function runOpenVPNCommands($routerName, $apiIp)
    {
        $commands = [
            ['sudo', 'bash', '-c', 'echo "Password@2022" | /etc/easy-rsa/easyrsa build-client-full ' . $routerName . ' nopass'],
            ['sudo', 'mkdir', '-p', "/etc/openvpn/client/$routerName"],
            ['sudo', 'cp', '-rp', "/etc/easy-rsa/pki/ca.crt", "/etc/openvpn/client/$routerName"],
            ['sudo', 'cp', '-rp', "/etc/easy-rsa/pki/issued/$routerName.crt", "/etc/openvpn/client/$routerName"],
            ['sudo', 'cp', '-rp', "/etc/easy-rsa/pki/private/$routerName.key", "/etc/openvpn/client/$routerName"],
            ['sudo', 'bash', '-c', 'echo "ifconfig-push ' . $apiIp . ' 255.255.0.0" > /etc/openvpn/ccd/' . $routerName],
        ];

        foreach ($commands as $command) {
            $process = new Process($command);
            $process->setTimeout(60); // Timeout to prevent hanging

            try {
                $process->mustRun();
            } catch (ProcessFailedException $exception) {
                Log::error("Command failed: " . implode(' ', $command) . "\nError: " . $exception->getMessage());
                throw new \Exception("Failed to execute command: " . implode(' ', $command));
            }
        }
    }
}
