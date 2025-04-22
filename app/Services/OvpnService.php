<?php

namespace App\Services;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use ZipArchive;

class OvpnService
{

    public function updateOvpnScript($username, $password, $certificateUser)
    {
        $sourceFile = '/etc/openvpn/demo_mikrotik1.rsc';
        $destinationDir = 'public/client-mikrotiks';
        $destinationFile = "$destinationDir/$certificateUser.rsc";

        // Ensure the storage directory exists
        Storage::makeDirectory($destinationDir);

        // Check if the source file exists
        if (!file_exists($sourceFile)) {
            return ['error' => 'Source file not found'];
        }

        // Read the file contents
        $script = file_get_contents($sourceFile);

        // Get APP_URL from .env
        $appUrl = rtrim(config('app.url'), '/');

        // Generate new values
        $certificate = "{$certificateUser}.crt_0";
        $rscUrl1 = "$appUrl/api/fetch-client-file/$certificateUser/$password/$certificateUser.crt";
        $rscUrl2 = "$appUrl/api/fetch-client-file/$certificateUser/$password/$certificateUser.key";
        $rscUrl3 = "$appUrl/api/fetch-client-file/$certificateUser/$password/ca.crt";

        // Replace placeholders in the script
        $updatedScript = str_replace(
            [
                ':local username "ispkenya"',
                ':local password "password"',
                ':local certificate "demo_mikrotik1.crt_0"',
                ':local certificateUser "demo_mikrotik1"',
                ':local rscUrl1 "https://demo.ispkenya.co.ke/mikrotik/openvpn/demo_mikrotik1/BvsdN3sfv9sv/demo_mikrotik1.crt"',
                ':local rscUrl2 "https://demo.ispkenya.co.ke/mikrotik/openvpn/demo_mikrotik1/BvsdN3sfv9sv/demo_mikrotik1.key"',
                ':local rscUrl3 "https://demo.ispkenya.co.ke/mikrotik/openvpn/demo_mikrotik1/BvsdN3sfv9sv/ca.crt"'
            ],
            [
                ':local username "' . $username . '"',
                ':local password "' . $password . '"',
                ':local certificate "' . $certificate . '"',
                ':local certificateUser "' . $certificateUser . '"',
                ':local rscUrl1 "' . $rscUrl1 . '"',
                ':local rscUrl2 "' . $rscUrl2 . '"',
                ':local rscUrl3 "' . $rscUrl3 . '"'
            ],
            $script
        );

        // Save the updated script to storage
        Storage::put($destinationFile, $updatedScript);

        return ['message' => 'Ovpn script updated successfully', 'file' => $destinationFile];
    }

    function createZipFile($routerName)
    {
        $zipFilePath = storage_path("app/public/$routerName.zip"); // Final zip location

        // Paths to include
        $folderPath = "/etc/openvpn/client/$routerName"; // External folder
        $filePath = base_path("your-project-file.txt"); // Adjust the file path

        $zip = new ZipArchive;
        if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {

            // Add the folder
            if (file_exists($folderPath)) {
                $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($folderPath));
                foreach ($files as $file) {
                    if (!$file->isDir()) {
                        $relativePath = substr($file->getRealPath(), strlen($folderPath) + 1);
                        $zip->addFile($file->getRealPath(), "client-files/$relativePath");
                    }
                }
            }

            // Add the file
            if (file_exists($filePath)) {
                $zip->addFile($filePath, "project-files/" . basename($filePath));
            }

            $zip->close();
            return response()->download($zipFilePath);
        } else {
            return response()->json(['error' => 'Failed to create zip'], 500);
        }
    }
    public function setupFiles($routerName)
    {
        try {

            // Get the next available values separately
            $nextApiIp = $this->getNextValue('proxy_pass', ':8728;'); // API IP
            $nextPublicIp = $nextApiIp; // Same IP for API & Public
            $nextApiPort = $this->getNextPort('listen', 8728);  // Next available API port
            $nextPublicPort = $this->getNextPort('listen', 8291); // Next available Public port
            $newDetails = [
                'router_name' => $routerName,
                'api_ip' => $nextApiIp,
                'public_ip' => $nextPublicIp,
                'api_port' => $nextApiPort,
                'public_port' => $nextPublicPort,
            ];

            // Debugging Output (Optional)
            Log::info('New Router Setup:', $newDetails);

            // Update nginx.conf
            $updateNginxResult = $this->updateNginxConfig($routerName, $nextApiIp, $nextPublicIp, $nextApiPort, $nextPublicPort);

            // Execute OpenVPN commands
            $this->runOpenVPNCommands($routerName, $nextApiIp);

            // Reload Nginx
            // $process = new Process(['sudo', 'systemctl', 'reload', 'nginx']);
            // $process->setTimeout(10);
            // $process->run();

            // if (!$process->isSuccessful()) {
            //     throw new \Exception('Failed to reload Nginx: ' . $process->getErrorOutput());
            // }

            return ['success' => true, 'message' => 'Router setup completed successfully.', 'data' => $updateNginxResult, 'api_port' => $nextApiPort];
        } catch (\Exception $e) {
            Log::error('Router setup failed: ' . $e->getMessage());
            return ['success' => false, 'error' => 'Failed to setup router', 'message' => $e->getMessage()];
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

        return ['message' => 'Nginx config updated successfully.'];

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
            // ['sudo', 'bash', '-c', 'echo "Password@2022" | /etc/easy-rsa/easyrsa build-client-full ' . $routerName . ' nopass'],
            ['sudo', 'mkdir', '-p', "/etc/openvpn/client/$routerName"],
            // ['sudo', 'cp', '-rp', "/etc/easy-rsa/pki/ca.crt", "/etc/openvpn/client/$routerName"],
            // ['sudo', 'cp', '-rp', "/etc/easy-rsa/pki/issued/$routerName.crt", "/etc/openvpn/client/$routerName"],
            // ['sudo', 'cp', '-rp', "/etc/easy-rsa/pki/private/$routerName.key", "/etc/openvpn/client/$routerName"],
            // ['sudo', 'bash', '-c', 'echo "ifconfig-push ' . $apiIp . ' 255.255.0.0" > /etc/openvpn/ccd/' . $routerName],
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
