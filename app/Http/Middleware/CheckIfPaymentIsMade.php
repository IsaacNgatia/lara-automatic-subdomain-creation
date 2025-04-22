<?php

namespace App\Http\Middleware;

use App\Models\Account;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class CheckIfPaymentIsMade
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            // Check the account status
            $accountStatus = true;
            // $accountStatus = Account::checkAccountStatus();

            // If the account is active, proceed to the next middleware/request
            if ($accountStatus === true) {
                return $next($request);
            }

            // If the account is not active, redirect to the "account.locked" route
            if ($accountStatus === false) {
                return redirect()->route('account.locked');
            }

            // If $accountStatus is neither true nor false, handle it as an error
            return response()->json([
                'status' => 'error',
                'message' => 'Your account is not active. Kindly contact your provider for assistance.',
                'details' => $accountStatus, // Include the account status for debugging or additional context
            ], 500);
        } catch (Exception $e) {
            // Log the error and return a 500 response
            Log::error('Error in account status middleware: ' . $e->getMessage());
            return response('Internal Server Error', 500);
        }
    }
}
