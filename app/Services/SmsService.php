<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

use App\Models\Customer;
use App\Models\HotspotCash;
use App\Models\HotspotEpay;
use App\Models\Mikrotik;
use App\Models\Sms;
use App\Models\SmsConfig;
use DateTime;
use DateTimeZone;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Config;

class SmsService
{
    /**
     * Handles the sending of SMS messages.
     *
     * @param Request $request The incoming request containing the recipient's phone number and the message.
     * @return \Illuminate\Http\JsonResponse The response containing the status, message ID, and other details.
     * @throws \Illuminate\Validation\ValidationException If the request does not contain valid data.
     */
    public function send($to, $message, $subject)
    {
        try {
            // Validate the parameters
            if (empty($to) || empty($message)) {
                return [
                    'status' => 'error',
                    'message' => 'Recipient and message are required.',
                ];
            }

            // Check for a working SMS provider
            $providerCount = SmsConfig::where('is_working', true)->count();
            if ($providerCount == 0) {
                return [
                    'status' => 'error',
                    'message' => 'Account has no working SMS provider configured.',
                ];
            }

            $recipients = 0;

            // Check for and process each possible input type
            if (!empty($to['id'])) {
                $recipients += $this->processCustomersById($to['id'], $message, $subject);
            } elseif (!empty($to['reference'])) {
                $recipients += $this->processCustomersById($to['reference'], $message, $subject);
            } elseif (!empty($to['locations'])) {
                $recipients += $this->processCustomersByLocations($to, $message, $subject);
            } elseif (!empty($to['mikrotiks'])) {
                $recipients += $this->processCustomersByMikrotiks($to, $message, $subject);
            } elseif (!empty($to['phone'])) {
                $recipients += $this->processPhone($to['phone'], $message, $subject);
            } else {
                return [
                    'status' => 'error',
                    'message' => 'No valid recipient data provided.',
                ];
            }

            // Return success message
            return [
                'status' => 'success',
                'message' => "SMS sent successfully to $recipients recipients.",
            ];
        } catch (\Throwable $th) {
            return [
                'status' => 'error',
                'message' => $th->getMessage(),
            ];
        }
    }
    public function testSmsConfiguration($to, $message, $subject, $smsConfigId)
    {
        $smsConfig = SmsConfig::find($smsConfigId);
        $response = $this->sendSMSWithProvider($to, $message, $smsConfig);

        Sms::create([
            'recipient' => $to,
            'message' => $message,
            'is_sent' => $response['status'],
            'subject' => $subject,
            'message_id' => $response['message_id'] ?? 'unknown',
        ]);
        if ($response['status'] == 0) {
            return ['success' => false, 'message' => 'Message failed to send', 'reason' => $response['message']];
        }
        $smsConfig->update(['is_working' => true]);
        return ['success' => true, 'message' => 'message sent successfully'];
    }
    public function sendToHspClient($data, $message, $subject = 'Epay Hotspot')
    {
        $phone = $data['phone'];
        $type = $data['hsp_type'] ?? null;

        if (empty($phone) || empty($message) || empty($type)) {
            return [
                'status' => 'error',
                'message' => 'Recipient and message and type are required.',
            ];
        }

        // Check for a working SMS provider
        $providerCount = SmsConfig::where('is_working', true)->count();
        if ($providerCount === 0) {
            return [
                'status' => 'error',
                'message' => 'Account has no working SMS provider configured.',
            ];
        }
        $config = SmsConfig::where('is_working', true)->first();
        if (!$config) {
            throw new Exception('No working SMS provider configured.');
        }
        if ($type && $type === 'cash') {
            $voucher = HotspotCash::find($data['voucher-id']);
        } else if ($type && $type === 'epay') {
            $voucher = HotspotEpay::find($data['voucher-id']);
        }

        $response = $this->sendSMSWithProvider($phone, $this->replacePlaceholdersForVoucher($voucher, $message), $config);
        Sms::create([
            'recipient' => $phone,
            'message' => $message,
            'is_sent' => $response['status'],
            'subject' => $subject,
            'message_id' => $response['message_id'] ?? 'unknown',
        ]);
        return 1;
    }

    private function processCustomersById(array $ids, $message, $subject)
    {
        $recipients = 0;
        foreach ($ids as $customerId) {
            $customer = Customer::find($customerId);
            if ($customer) {
                $this->sendMessageAndLog($customer, $message, $subject);
                $recipients++;
            }
        }
        return $recipients;
    }

    private function processCustomersByLocations(array $to, $message, $subject)
    {
        $recipients = 0;

        // Build the query based on the values of 'inactive' and 'active'
        $query = Customer::whereIn('location', $to['locations']);

        if (!empty($to['inactive']) && $to['inactive'] === true) {
            $query->where('status', 'inactive');
        }

        if (!empty($to['active']) && $to['active'] === true) {
            $query->Where('status', 'active');
        }

        // Get the filtered customers
        $customers = $query->get();

        // Process each customer
        foreach ($customers as $customer) {
            $this->sendMessageAndLog($customer, $message, $subject);
            $recipients++;
        }

        return $recipients;
    }


    /**
     * Process and send SMS messages to customers associated with specified Mikrotik devices.
     *
     * This function retrieves customers linked to the given Mikrotik IDs, filters them based on
     * their active/inactive status if specified, and sends SMS messages to each customer.
     *
     * @param array $to An array containing 'mikrotiks' (array of Mikrotik IDs), and optionally
     *                  'inactive' and 'active' boolean flags for filtering customers.
     * @param string $message The SMS message content to be sent to customers.
     * @param string $subject The subject or category of the SMS message.
     *
     * @return int The total number of recipients (customers) who were sent the SMS message.
     */
    private function processCustomersByMikrotiks(array $to, $message, $subject)
    {
        $recipients = 0;
        foreach ($to['mikrotiks'] as $mikrotikId) {
            $query = Mikrotik::find($mikrotikId)->customers();
            if (!empty($to['inactive']) && $to['inactive'] === true) {
                $query->where('status', 'inactive');
            } elseif (!empty($to['active']) && $to['active'] === true) {
                $query->where('status', 'active');
            }

            $customers = $query->get();
            foreach ($customers as $customer) {
                $this->sendMessageAndLog($customer, $message, $subject);
                $recipients++;
            }
        }
        return $recipients;
    }

    /**
     * Processes and sends an SMS to a single phone number.
     *
     * This function sends an SMS message to the specified phone number using the configured SMS provider,
     * and then logs the message details in the database.
     *
     * @param string $phone   The recipient's phone number.
     * @param string $message The content of the SMS message to be sent.
     * @param string $subject The subject or category of the SMS message.
     *
     * @return int Returns 1 to indicate that one message has been processed and sent.
     */
    private function processPhone($phone, $message, $subject)
    {
        $response = $this->checkWorkingSmsConfig($phone, $message);
        Sms::create([
            'recipient' => $phone,
            'message' => $message,
            'is_sent' => $response['status'],
            'subject' => $subject,
            'message_id' => $response['message_id'] ?? 'unknown',
        ]);
        return 1;
    }

    /**
     * Sends an SMS message to a customer, logs the message, and updates the customer's information.
     *
     * @param \App\Models\Customer $customer The customer to send the SMS message to.
     * @param string $message The message content to be sent.
     * @param string $subject The subject of the SMS message.
     *
     * @return void
     */
    private function sendMessageAndLog($customer, $message, $subject)
    {
        $phone = $customer->phone_number;
        $customizedMessage = $this->replacePlaceholders($customer, $message);
        $response = $this->checkWorkingSmsConfig($phone, $customizedMessage);

        Sms::create([
            'recipient' => $phone,
            'message' => $customizedMessage,
            'is_sent' => $response['status'],
            'subject' => $subject,
            'customer_id' => $customer->id,
            'message_id' => $response['message_id'],
        ]);
    }

    private function checkWorkingSmsConfig($to, $message)
    {
        $config = SmsConfig::where('is_working', true)->first();
        if (!$config) {
            throw new Exception('No working SMS provider configured.');
        }

        return $this->sendSMSWithProvider($to, $message, $config);
    }

    /**
     * Handles the sending of SMS messages using a specified provider.
     *
     * @param string $provider The name of the SMS provider.
     * @param string $to The recipient's phone number.
     * @param string $message The content of the SMS message.
     * @return array The response containing the status, message ID, and other details.
     * @throws Exception If the specified provider is unsupported.
     */
    private function sendSMSWithProvider($to, $message, SmsConfig $config)
    {
        try {
            $provider = $config->smsProvider->name;
            // Determine the correct provider logic
            switch (strtolower($provider)) {
                case 'celcomafrica':
                case 'textsms':
                case 'afrinet':
                case 'advanta':
                    // Use the same code for these providers
                    $providerResponse = $this->sendViaTextSMS($to, $message, $config);
                    break;
                case 'bytewave':
                case 'talksasa':
                    $providerResponse = $this->sendViaBytewave($to, $message, $config);
                    break;
                case 'africastalking':
                    $providerResponse = $this->sendViaAfricastalking($to, $message, $config);
                    break;
                case 'hostpinnacle':
                    $providerResponse = $this->sendViaHostpinnacle($to, $message, $config);
                    break;
                case 'mobilesasa':
                    $providerResponse = $this->sendViaMobilesasa($to, $message, $config);
                    break;
                case 'afrokatt':
                    $providerResponse = $this->sendViaAfroкatt($to, $message, $config);
                    break;
                case 'sasatelkom':
                    $providerResponse = $this->sendViaSasatelkom($to, $message, $config);
                    break;
                case 'mspace':
                    $providerResponse = $this->sendViaMspace($to, $message, $config);
                    break;
                case 'smsleopard':
                    $providerResponse = $this->sendViaSmsleopard($to, $message, $config);
                    break;
                case 'mobitech':
                    $providerResponse = $this->sendViaMobitech($to, $message, $config);
                    break;
                default:
                    throw new Exception("Unsupported SMS provider: $provider");
            }
            switch (strtolower($provider)) {
                case 'celcomafrica':
                case 'textsms':
                case 'afrinet':
                case 'advanta':
                    $sendSmsResponse = collect($providerResponse['responses'][0]);
                    $messageId = $sendSmsResponse->get('messageid', 'NULL');
                    break;
                case 'bytewave':
                case 'talksasa':
                    if ($providerResponse['status'] == 'error') {
                        $response['status'] = 0;
                        $response['message_id'] = null;
                        $response['message'] = $providerResponse['message'];
                        return $response;
                    }
                    $responseData = collect($providerResponse['data']);

                    $messageId = $responseData->get('id', null);
                    break;
                case 'africastalking':
                    $messageId = $providerResponse['SMSMessageData']['Recipients']['Recipient']['messageId'] ?? null;
                    break;
                case 'hostpinnacle':
                    $messageId = $providerResponse['transactionId'] ?? null;
                    break;
                case 'mobilesasa':
                    $messageId = $providerResponse['messageId'] ?? null;
                    break;
                case 'afrokatt':
                    $messageId = $providerResponse['message_id'] ?? null;
                    break;
                case 'sasatelkom':
                    // Normalize the response string by removing any line breaks
                    $cleanResponse = str_replace(["\r\n", "\n", "\r"], '', $providerResponse);

                    $resultArray = explode(',', $cleanResponse);

                    if (count($resultArray) >= 3) {
                        // Extract only the $messageId
                        $messageId = trim($resultArray[0]);
                    } else {
                        // Handle cases where the response format is unexpected
                        $messageId = null;
                    }
                    break;
                case 'mspace':
                    $current_time = new DateTime('now', new DateTimeZone('Africa/Nairobi'));
                    $formatted_time = $current_time->format('YmdHis');
                    $messageId = 'mspc-' . $formatted_time;
                    break;
                case 'smsleopard':
                    $recipients = $providerResponse['recipients'];

                    if (!empty($recipients)) {
                        $firstRecipient = $recipients[0];
                        $recipientId = $firstRecipient['id'];
                    } else {
                        $recipientId = null;
                    }

                    $messageId = $recipientId;
                    break;
                case 'mobitech':
                    $messageId = $providerResponse[0]['message_id'] ?? null;
                    break;
                default:
                    throw new Exception("Unsupported SMS provider: $provider");
            }

            // Assuming provider response contains a status and message ID
            if ($messageId) {
                $response['status'] = 1;
                $response['message_id'] = $messageId;
            } elseif (empty($messageId)) {
                $response['status'] = 0;
                $response['message_id'] = null;
                $response['message'] = $providerResponse;
            }
        } catch (Exception $e) {
            // Handle exceptions
            $response['status'] = 0;
            $response['message'] = $e->getMessage();
        }

        return $response;
    }
    /**
     * Sends an SMS message using the TextSMS provider.
     *
     * @param string $to The recipient's phone number.
     * @param string $message The message content.
     *
     * @return \Illuminate\Http\JsonResponse The response from the SMS provider.
     */
    // private function sendViaTextSMS($to, $message, SmsConfig $config)
    // {
    //     // afrinet balance_url = 'https://sms.imarabiz.com/api/services/getbalance/'
    //     // advanta balance_url = 'https://quicksms.advantasms.com/api/services/getbalance/'

    //     // Get the SMS provider from the environment

    //     $provider = strtolower($config->smsProvider->name);

    //     // Determine the URL based on the provider
    //     switch ($provider) {
    //         case 'celcomafrica':
    //             $url = 'https://isms.celcomafrica.com/api/services/sendsms/';
    //             break;
    //         case 'textsms':
    //             $url = 'https://sms.textsms.co.ke/api/services/sendsms/';
    //             break;
    //         case 'afrinet':
    //             $url = 'https://sms.imarabiz.com/api/services/sendsms/';
    //             break;
    //         case 'advanta':
    //             $url = 'https://quicksms.advantasms.com/api/services/sendsms/';
    //             break;
    //         default:
    //             // Return an error response if the provider is not supported
    //             return response()->json([
    //                 'status' => 'FAILED',
    //                 'message' => 'Provider not supported',
    //             ], 400);
    //     }

    //     // Prepare the POST data
    //     $curl_post_data = [
    //         'partnerID' => $config->sender_id,
    //         'apikey' => $config->api_key,
    //         'mobile' => $to,
    //         'message' => $message,
    //         'shortcode' => $config->short_code,
    //         'pass_type' => $config->output_type,
    //     ];

    //     // Initialize cURL
    //     $curl = curl_init();

    //     // Set cURL options
    //     curl_setopt_array($curl, [
    //         CURLOPT_URL => $url,
    //         CURLOPT_RETURNTRANSFER => true,
    //         CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
    //         CURLOPT_POST => true,
    //         CURLOPT_POSTFIELDS => json_encode($curl_post_data),
    //     ]);

    //     // Execute cURL request
    //     $curl_response = curl_exec($curl);

    //     // Handle cURL errors
    //     if (curl_errno($curl)) {
    //         $error_msg = curl_error($curl);
    //         curl_close($curl);
    //         return response()->json([
    //             'status' => 'FAILED',
    //             'message' => 'cURL error: ' . $error_msg,
    //         ], 500);
    //     }

    //     // Close cURL
    //     curl_close($curl);

    //     // Return the response from the SMS provider
    //     return response()->json(json_decode($curl_response, true));
    // }

    private function sendViaTextSMS($to, $message, SmsConfig $config): array
    {
        // Get the SMS provider from the environment
        $provider = strtolower($config->smsProvider->name);

        // Determine the URL based on the provider
        $url = match ($provider) {
            'celcomafrica' => 'https://isms.celcomafrica.com/api/services/sendsms/',
            'textsms' => 'https://sms.textsms.co.ke/api/services/sendsms/',
            'afrinet' => 'https://sms.imarabiz.com/api/services/sendsms/',
            'advanta' => 'https://quicksms.advantasms.com/api/services/sendsms/',
            default => null,
        };

        // Return an error response if the provider is not supported
        if (!$url) {
            return [
                'status' => 'FAILED',
                'message' => 'Provider not supported',
            ];
        }

        // Prepare the POST data
        $postData = [
            'partnerID' => $config->sender_id,
            'apikey' => $config->api_key,
            'mobile' => $to,
            'message' => $message,
            'shortcode' => $config->short_code,
            'pass_type' => $config->output_type,
        ];

        // Make the HTTP POST request using Laravel's Http facade
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post($url, $postData);

        // Handle HTTP errors
        if ($response->failed()) {
            return [
                'status' => 'FAILED',
                'message' => 'HTTP request failed: ' . $response->body(),
            ];
        }

        // Return the response from the SMS provider
        return $response->json();
    }

    /**
     * Sends an SMS message using the Bytewave or Talksasa provider.
     *
     * @param string $to The recipient's phone number.
     * @param string $message The message content.
     *
     * @return array The response from the SMS provider.
     */
    private function sendViaBytewave(string $to, string $message, SmsConfig $config): array
    {
        // bytewave balance_url = 'https://portal.bytewavenetworks.com/api/v3/balance'
        // talksasa balance_url = 'https://bulksms.talksasa.com/api/v3/balance'

        $twoFiveFour = $this->replaceZeroWithTwoFiftyFour($to);
        $senderId = $config->sender_id;
        $provider = $config->smsProvider->name;

        // Determine the correct URL based on the provider
        switch (strtolower($provider)) {
            case 'bytewave':
                $url = 'https://portal.bytewavenetworks.com/api/v3/sms/send';
                $authToken = 'testToken';
                break;
            case 'talksasa':
                // $url = 'https://bulksms.talksasa.com/api/v3/sms/send';
                $url = 'https://sms.ispkenya.co.ke/api/v3/sms/send';
                $authToken = $config->api_key;
                break;
            default:
                // Return an error response or throw an exception if the provider is not supported
                return [
                    'status' => 'FAILED',
                    'message' => 'Provider not supported',
                ];
        }

        // Prepare the payload
        $payload = [
            'recipient' => $twoFiveFour,
            'sender_id' => $senderId,
            'type' => 'plain',
            'message' => $message,
        ];

        // Send the POST request using Laravel's Http client
        $response = Http::withToken($authToken)
            ->withHeaders(['Content-Type' => 'application/json'])
            ->post($url, $payload);

        // Return the response as an array
        return $response->json();
    }
    /**
     * Sends an SMS message using the Africastalking provider.
     *
     * @param string $to The recipient's phone number.
     * @param string $message The message content.
     *
     * @return array The response from the SMS provider.
     */
    private function sendViaAfricastalking(string $to, string $message): array
    {
        $twoFiveFour = $this->replaceZeroWithTwoFiftyFour($to);
        $encodedMessage = $this->replaceSpacesWithUrlEncoding($message);
        $url = 'https://api.africastalking.com/version1/messaging';
        $apiKey = env('SMS_API_KEY');
        $shortCode = env('SMS_SHORT_CODE');
        $senderId = env('SMS_PARTNER_ID');

        // Prepare the payload
        $payload = [
            'username' => $shortCode,
            'message' => $encodedMessage,
            'to' => '+' . $twoFiveFour,
            'from' => $senderId,
        ];

        // Send the POST request using Laravel's Http client
        $response = Http::withHeaders([
            'apiKey' => $apiKey,
            'Content-Type' => 'application/x-www-form-urlencoded',
        ])->asForm()->post($url, $payload);

        // Parse the XML response
        $xml = simplexml_load_string($response->body());

        // Convert XML to an array
        $responseArray = json_decode(json_encode($xml), true);

        // Return the response as an array
        return $responseArray;
    }
    /**
     * Sends an SMS message using the Hostpinnacle provider.
     *
     * @param string $to The recipient's phone number.
     * @param string $message The message content.
     *
     * @return array The response from the SMS provider.
     */
    private function sendViaHostpinnacle(string $to, string $message): array
    {
        // Hostpinnacle balance_url = 'https://smsportal.hostpinnacle.co.ke/SMSApi/account/readstatus'
        $twoFiveFour = $this->replaceZeroWithTwoFiftyFour($to);
        $encodedMessage = $this->replaceSpacesWithUrlEncoding($message);
        $url = 'https://smsportal.hostpinnacle.co.ke/SMSApi/send';

        $apiCredentials = [
            'userid' => env('SMS_USERNAME'),
            'password' => env('SMS_PASS'),
            'apikey' => env('SMS_API_KEY'),
        ];

        $smsDetails = [
            'mobile' => $twoFiveFour,
            'msg' => $encodedMessage,
            'senderid' => env('SMS_PARTNER_ID'),
            'msgType' => 'text',
            'dltEntityId' => '',
            'dltTemplateId' => '',
            'duplicatecheck' => 'true',
            'output' => env('SMS_OUTPUT_TYPE', 'json'),
            'sendMethod' => 'quick',
        ];

        // Combine API credentials and SMS details
        $postData = array_merge($apiCredentials, $smsDetails);

        // Send the HTTP POST request
        $response = Http::withHeaders([
            'Content-Type' => 'application/x-www-form-urlencoded',
            'apikey' => env('SMS_API_KEY'),
        ])->asForm()->post($url, $postData);

        // Return the response as an array
        return $response->json();
    }
    /**
     * Sends an SMS message using the Mobilesasa provider.
     *
     * @param string $to The recipient's phone number.
     * @param string $message The message content.
     *
     * @return array The response from the SMS provider.
     */
    private function sendViaMobilesasa(string $to, string $message): array
    {
        $twoFiveFour = $this->replaceZeroWithTwoFiftyFour($to);
        $senderId = env('SMS_PARTNER_ID');
        $authToken = env('SEND_SMS_TOKEN');
        $url = 'https://api.mobilesasa.com/v1/send/message';

        // Prepare the payload
        $payload = [
            'phone' => $twoFiveFour,
            'senderID' => $senderId,
            'message' => $message,
        ];

        // Send the POST request using Laravel's Http client
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $authToken,
            'Content-Type' => 'application/json',
        ])->post($url, $payload);

        // Return the response as an array
        return $response->json();
    }
    /**
     * Sends an SMS message using the Afroкatt provider.
     *
     * @param string $to The recipient's phone number.
     * @param string $message The message content.
     *
     * @return array The response from the SMS provider.
     */
    private function sendViaAfroкatt(string $to, string $message): array
    {
        // afrokatt balance_url = 'https://account.afrokatt.com/sms/api?action=check-balance&api_key=YOUR_KEY&username=USERNAME'
        $twoFiveFour = $this->replaceZeroWithTwoFiftyFour($to);
        $encodedMessage = $this->replaceSpacesWithUrlEncoding($message);
        $senderId = env('SMS_PARTNER_ID');
        $authToken = env('SMS_API_KEY');
        $cookie = env('SEND_SMS_COOKIE');
        $url = 'https://account.afrokatt.com/sms/api?';

        // Construct the URL with query parameters
        $request = $url . 'action=send-sms&api_key=' . urlencode($authToken) . '&to=' . $twoFiveFour . '&from=' . urlencode($senderId) . '&sms=' . $encodedMessage;

        // Send the POST request using Laravel's Http client
        $response = Http::withHeaders([
            'Cookie' => 'laravel_session=' . $cookie,
        ])->post($request);

        // Return the response as an array
        return $response->json();
    }
    /**
     * Sends an SMS message using the Sasatelkom provider.
     *
     * @param string $to The recipient's phone number.
     * @param string $message The message content.
     *
     * @return string The response from the SMS provider.
     */
    private function sendViaSasatelkom(string $to, string $message): string
    {
        $twoFiveFour = $this->replaceZeroWithTwoFiftyFour($to);
        $encoded_string = $this->replaceSpacesWithUrlEncoding($message);
        $encoded_senderId = $this->replaceSpacesWithUrlEncoding(getenv('SMS_PARTNER_ID'));
        $payload = [
            'user' => env('SMS_USERNAME'),
            'pwd' => env('SMS_PASS'),
            'senderid' => $encoded_senderId,
            'mobileno' => $twoFiveFour,
            'msgtext' => $encoded_string,
            'priority' => 'High',
            'CountryCode' => 'ALL',
        ];

        $queryString = http_build_query($payload);
        $url = env('SMS_URL') . '?' . $queryString;

        $response = Http::withOptions([
            'verify' => false, // Disable SSL verification if necessary
        ])->get($url);

        return $response->body();
    }
    /**
     * Sends an SMS message using the Mspace provider.
     *
     * @param string $to The recipient's phone number.
     * @param string $message The message content.
     *
     * @return array The response from the SMS provider.
     */
    private function sendViaMspace(string $to, string $message): array
    {
        $encodedMessage = $this->replaceSpacesWithUrlEncoding($message);
        $username = env('SMS_USERNAME');
        $password = env('SMS_PASSWORD');

        // Construct the URL
        $url = sprintf(
            '%s/username=%s/password=%s/senderid=%s/recipient=%s/message=%s',
            env('SMS_URL'),
            urlencode($username),
            urlencode($password),
            urlencode($username),
            urlencode($to),
            urlencode($encodedMessage)
        );

        // Send the GET request using Laravel's Http client
        $response = Http::get($url);

        // Return the response as an array
        return $response->json();
    }
    /**
     * Sends an SMS message using the Smsleopard provider.
     *
     * @param string $to The recipient's phone number.
     * @param string $message The message content.
     *
     * @return array The response from the SMS provider.
     */

    private function sendViaSmsleopard(string $to, string $message): array
    {
        $senderId = env('SMS_PARTNER_ID');
        $url = 'https://api.smsleopard.com/v1/sms/send';
        $apiKey = env('SMS_API_KEY');
        $smsApiSecret = env('SMS_API_SECRET');
        $encodedMessage = $this->replaceSpacesWithUrlEncoding($message);
        $authToken = $this->base64Encoding($apiKey, $smsApiSecret);

        // Prepare the query parameters
        $queryParams = [
            'message' => $encodedMessage,
            'destination' => $to,
            'source' => $senderId,
        ];

        // Send the GET request using Laravel's Http client
        $response = Http::withHeaders([
            'Authorization' => 'Basic ' . $authToken,
        ])->get($url, $queryParams);

        // Return the response as an array
        return $response->json();
    }
    /**
     * Sends an SMS message using the Mobitech provider.
     *
     * @param string $to The recipient's phone number.
     * @param string $message The message content.
     *
     * @return array The response from the SMS provider.
     */

    private function sendViaMobitech(string $to, string $message): array
    {
        $payload = [
            'service_id' => env('SMS_PARTNER_ID'),
            'mobile' => $to,
            'message' => $message,
            'sender_name' => env('SMS_SHORT_CODE'),
            'response_type' => env('SMS_OUTPUT_TYPE', 'json'),
        ];

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'h_api_key' => env('SMS_API_KEY'),
        ])->post('https://api.mobitechtechnologies.com/sms/sendsms', $payload);

        return $response->json();
    }
    /**
     * Replaces a leading zero in a phone number with "+254" and returns the modified number.
     *
     * @param string $to The phone number to be modified.
     *
     * @return string The modified phone number with "+254" prepended.
     */
    private function replaceZeroWithTwoFiftyFour(string $to): string
    {
        // If the number starts with a zero, remove it
        if (substr($to, 0, 1) === '0') {
            return '+254' . substr($to, 1); // Remove the leading zero and prepend +254
        }

        // If the number does not start with zero, assume it’s already in international format
        return '+254' . $to; // Adjust this if necessary based on your input format
    }
    /**
     * Replaces a space character in a string with its URL-encoded equivalent (%20).
     *
     * @param string $string The input string where spaces need to be replaced.
     *
     * @return string The input string with spaces replaced by '%20'.
     */
    function replaceSpacesWithUrlEncoding($string)
    {
        // Use rawurlencode() for proper URL encoding
        return str_replace(' ', '%20', rawurlencode($string));
    }
    /**
     * Combines the provided strings with a colon and encodes the result in base64.
     *
     * @param string $string1 The first string to be combined.
     * @param string $string2 The second string to be combined.
     *
     * @return string The combined strings, encoded in base64.
     */
    function base64Encoding($string1, $string2)
    {
        // Combine api_key and api_secret with a colon
        $credentials = $string1 . ':' . $string2;

        // Convert the combined string to base64 encoding
        $base64_credentials = base64_encode($credentials);
        return $base64_credentials;
    }
    private function replacePlaceholders($customer, $message)
    {
        // Define the placeholders and their corresponding customer properties
        $placeholders = [
            '{reference_number}' => $customer->reference_number ?? '',
            '{official_name}' => $customer->official_name ?? 'customer',
            '{phone}' => $customer->phone_number ?? '',
            '{bill}' => $customer->billing_amount ?? '',
            '{expiry_date}' => $customer->expiry_date ?? '',
            '{user_url}' => url('client/overview') ?? '',
        ];

        // Replace each placeholder in the string with its value
        $resultString = str_replace(array_keys($placeholders), array_values($placeholders), $message);

        return $resultString;
    }
    private function replacePlaceholdersForVoucher($voucher, $message)
    {
        // Define the placeholders and their corresponding customer properties
        $placeholders = [
            '{first_name}' => $voucher->first_name ?? 'customer',
            '{hsp_amount_received}' => $voucher->price ?? '',
            '{hsp_username}' => $voucher->username ?? '',
            '{hsp_password}' => $voucher->password ?? '',
            '{hsp_datalimit}' => $voucher->data_limit ?? '',
            '{hsp_timelimit}' => $voucher->time_limit ?? '',
            '{expiry_date}' => $voucher->expiry_date ?? '',
            '{payment_date}' => $voucher->payment_date ?? '',
        ];

        // Replace each placeholder in the string with its value
        $resultString = str_replace(array_keys($placeholders), array_values($placeholders), $message);

        return $resultString;
    }
    private function generateAuthToken(string $url): ?string
    {
        // Credentials (replace with actual credentials if needed)
        $credentials = [
            'username' => 'your_username',
            'password' => 'your_password',
        ];

        $response = Http::withHeaders(['Content-Type' => 'application/json'])
            ->post($url, $credentials);

        if ($response->successful()) {
            return $response->json()['token'] ?? null;
        }

        return null;
    }
}
