<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Account extends Model
{
    protected $connection = 'manager_db';
    protected $table = 'customers';

    public static function checkAccountStatus()
    {
        try {
            // Get the subdomain and domain from the APP_URL
            $urlDetails = self::getAppUrlDetails();
            $subdomain = $urlDetails['subdomain'];
            $domain = $urlDetails['domain'];

            // Query the database to check if a matching row exists and is active
            $row = self::where('subdomain', $subdomain)
                ->where('domain', $domain)
                ->first();

            // Return true if the row exists and is active, otherwise false
            if (!$row) {
                return 'account is missing';
            }
            return $row && $row->status === 'active';
        } catch (Exception $e) {
            // Log the error for debugging purposes
            Log::error('Error in checkAccountStatus: ' . $e->getMessage());

            // Return false in case of any error
            return $e->getMessage();
        }
    }
    /**
     * Get the subdomain and domain from the APP_URL in the .env file.
     *
     * @return array
     */
    private static function getAppUrlDetails()
    {
        // Get the APP_URL from the .env file
        // $appUrl = 'https://demo.ispkenya.co.ke';
        $appUrl = env('APP_URL');

        // Parse the URL to extract components
        $parsedUrl = parse_url($appUrl);

        // Extract the host (e.g., subdomain.domain.tld)
        $host = $parsedUrl['host'] ?? '';

        // Split the host into parts
        $hostParts = explode('.', $host);

        // Determine the subdomain and domain
        if (count($hostParts) > 2) {
            // If there are more than 2 parts, the first part is the subdomain
            $subdomain = $hostParts[0];
            $domain = implode('.', array_slice($hostParts, 1));
        } else {
            // Otherwise, there is no subdomain
            $subdomain = null;
            $domain = $host;
        }

        // Return the result as an array
        return [
            'subdomain' => $subdomain,
            'domain' => $domain,
        ];
    }
}
