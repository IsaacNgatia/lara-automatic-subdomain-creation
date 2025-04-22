<?php

namespace App\Livewire\Admins\Customers;

use App\Models\Customer;
use App\Models\Transaction;
use App\Models\Wallet;
use DateTime;
use Livewire\Component;

class ViewProfile extends Component
{
    public $customerId;
    public $transactionsCount;
    public $walletCount;
    public $daysRemaining;
    public $spentPercentage;
    public function mount($customerId)
    {
        $this->customerId = $customerId;
        $customer = Customer::find($customerId);
        $referenceNumber = $customer->reference_number;
        $this->transactionsCount = Transaction::where(function ($query) use ($referenceNumber, $customerId) {
            $query->where('reference_number', $referenceNumber)
                ->orWhere('customer_id', $customerId);
        })->count();
        $this->walletCount = Wallet::where('customer_id', $customerId)->count();
        $this->daysRemaining = $this->getTimeDifference($customer->expiry_date);
        $this->spentPercentage = $this->calculateSpentPercentage($this->daysRemaining, $customer->billing_cycle);
        $this->spentPercentage = round($this->spentPercentage, 1);
    }
    private function getTimeDifference($expiryDate)
    {
        $now = new DateTime(); // Get the current datetime
        $expiry = new DateTime($expiryDate); // Convert the expiry date to a DateTime object

        // Check if the expiry date is in the past
        if ($expiry < $now) {
            return "Expired";
        }

        // Get the interval between the current time and the expiry date
        $interval = $now->diff($expiry);

        // Determine the largest unit of time and format the output
        if ($interval->y > 0) {
            return $interval->y . ' year' . ($interval->y > 1 ? 's' : '');
        } elseif ($interval->m > 0) {
            return $interval->m . ' month' . ($interval->m > 1 ? 's' : '');
        } elseif ($interval->d > 0) {
            return $interval->d . ' day' . ($interval->d > 1 ? 's' : '');
        } elseif ($interval->h > 0) {
            return $interval->h . ' hour' . ($interval->h > 1 ? 's' : '');
        } elseif ($interval->i > 0) {
            return $interval->i . ' minute' . ($interval->i > 1 ? 's' : '');
        } else {
            return 'Less than a minute';
        }
    }
    private function calculateSpentPercentage($remainingPeriod, $billingCycle)
    {
        // Helper function to convert a period string to minutes
        function periodToMinutes($period)
        {
            $timeUnits = [
                'minute' => 1,
                'hour' => 60,
                'day' => 1440,       // 24 hours
                'week' => 10080,     // 7 days
                'month' => 43200,    // 30 days
                'year' => 525600     // 365 days
            ];

            preg_match('/(\d+)\s*(\w+)/', strtolower($period), $matches);
            if (!$matches) {
                return 0; // Invalid input
            }

            $value = (int)$matches[1];
            $unit = rtrim($matches[2], 's'); // Remove plural 's' if it exists

            return isset($timeUnits[$unit]) ? $value * $timeUnits[$unit] : 0;
        }

        // Convert both periods to minutes
        $remainingMinutes = periodToMinutes($remainingPeriod);
        $billingMinutes = periodToMinutes($billingCycle);

        // Ensure no division by zero
        if ($billingMinutes === 0) {
            return 0;
        }

        // Calculate the percentage difference
        $percentage = (($billingMinutes - $remainingMinutes) / $billingMinutes) * 100;

        // Ensure the result is not negative
        return max(0, $percentage);
    }

    public function render()
    {
        return view('livewire.admins.customers.view-profile');
    }
}
