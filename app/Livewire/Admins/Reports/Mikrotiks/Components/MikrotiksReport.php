<?php

namespace App\Livewire\Admins\Reports\Mikrotiks\Components;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class MikrotiksReport extends Component
{
    public $startingDate;
    public $endingDate;
    public $groupBy;
    public $mikrotikIds;
    public $totalTransactionsAmount = 0;
    public $totalTransactionsCount = 0;
    public $perPage = 10;

    public $results = [];

    public function mount($startingDate, $endingDate, $groupBy, $mikrotikIds)
    {
        $this->startingDate = Carbon::parse($startingDate)->startOfDay();
        $this->endingDate = Carbon::parse($endingDate)->endOfDay();
        $this->groupBy = $groupBy;
        $this->mikrotikIds = $mikrotikIds;

        $this->generateReport();
    }

    public function generateReport()
    {
        if ($this->groupBy === 'none') {
            $results = [];
            $totalTransactionsCount = 0;
            $totalTransactionsAmount = 0;

            foreach ($this->mikrotikIds as $mikrotikId) {
                $mikrotikName = DB::table('mikrotiks')->where('id', $mikrotikId)->value('name');
                $results[$mikrotikId]['name'] = $mikrotikName;
                $results[$mikrotikId]['total'] = 0;

                $sum =  DB::table('transactions')
                    ->where('mikrotik_id', $mikrotikId)
                    ->whereBetween('trans_time', [$this->startingDate, $this->endingDate])
                    ->sum('trans_amount');
                $results[$mikrotikId]['data'] = [
                    'label' => 'All',
                    'start' => $this->startingDate,
                    'end' => $this->endingDate,
                ];
                $results[$mikrotikId]['total'] = $sum;
            }
            // Calculate total transactions and amount across all mikrotiks and periods
            $totalTransactionsCount = DB::table('transactions')
                ->whereIn('mikrotik_id', $this->mikrotikIds)
                ->whereBetween('trans_time', [$this->startingDate, $this->endingDate])
                ->count();

            $totalTransactionsAmount = DB::table('transactions')
                ->whereIn('mikrotik_id', $this->mikrotikIds)
                ->whereBetween('trans_time', [$this->startingDate, $this->endingDate])
                ->sum('trans_amount');

            $this->results = [
                'labels' => [],
                'data' => $results,
                'total_count' => $totalTransactionsCount,
                'total_amount' => $totalTransactionsAmount,
            ];
            return;
        }

        $allPeriods = collect();
        $groupFormat = '';
        $range = [];

        switch ($this->groupBy) {
            case 'daily':
                $groupFormat = 'Y-m-d';
                $range = collect(range(0, $this->startingDate->diffInDays($this->endingDate)))
                    ->map(fn($i) => $this->startingDate->copy()->addDays($i));
                break;

            case 'weekly':
                $groupFormat = 'o-W'; // Year-week number
                $range = collect();
                $start = $this->startingDate->copy()->startOfWeek();
                while ($start <= $this->endingDate) {
                    $range->push($start->copy());
                    $start->addWeek();
                }
                break;

            case 'monthly':
                $groupFormat = 'Y-m';
                $range = collect(); // initialize collection
                $start = $this->startingDate->copy()->startOfMonth();
                while ($start <= $this->endingDate) {
                    $range->push($start->copy());
                    $start->addMonth();
                }
                break;

            case 'yearly':
                $groupFormat = 'Y';
                $range = collect(range($this->startingDate->year, $this->endingDate->year))
                    ->map(fn($year) => Carbon::create($year)->startOfYear());
                break;
        }

        $allPeriods = $range->map(function ($date) use ($groupFormat) {
            return [
                'label' => $date->format($groupFormat),
                'start' => $this->getPeriodStart($date),
                'end' => $this->getPeriodEnd($date),
            ];
        });

        $results = [];
        $totalTransactionsCount = 0;
        $totalTransactionsAmount = 0;

        foreach ($this->mikrotikIds as $mikrotikId) {
            $mikrotikName = DB::table('mikrotiks')->where('id', $mikrotikId)->value('name');
            $results[$mikrotikId]['name'] = $mikrotikName;
            $results[$mikrotikId]['total'] = 0;

            foreach ($allPeriods as $period) {
                $sum = DB::table('transactions')
                    ->where('mikrotik_id', $mikrotikId)
                    ->whereBetween('trans_time', [$period['start'], $period['end']])
                    ->sum('trans_amount');

                $results[$mikrotikId]['data'][$period['label']] = $sum;
                $results[$mikrotikId]['total'] += $sum;
            }
        }

        // Remove periods with no data across all mikrotiks
        $filteredPeriods = [];
        foreach ($allPeriods as $period) {
            $hasData = collect($results)->pluck('data')->pluck($period['label'])->sum() > 0;
            if ($hasData) {
                $filteredPeriods[] = $period['label'];
            }
        }

        // Calculate total transactions and amount across all mikrotiks and periods
        $totalTransactionsCount = DB::table('transactions')
            ->whereIn('mikrotik_id', $this->mikrotikIds)
            ->whereBetween('trans_time', [$this->startingDate, $this->endingDate])
            ->count();

        $totalTransactionsAmount = DB::table('transactions')
            ->whereIn('mikrotik_id', $this->mikrotikIds)
            ->whereBetween('trans_time', [$this->startingDate, $this->endingDate])
            ->sum('trans_amount');

        $this->results = [
            'labels' => $filteredPeriods,
            'data' => $results,
            'total_count' => $totalTransactionsCount,
            'total_amount' => $totalTransactionsAmount,
        ];
    }

    protected function getPeriodStart(Carbon $date)
    {
        return match ($this->groupBy) {
            'daily' => $date->copy()->startOfDay(),
            'weekly' => $date->copy()->startOfWeek(),
            'monthly' => $date->copy()->startOfMonth(),
            'yearly' => $date->copy()->startOfYear(),
        };
    }

    protected function getPeriodEnd(Carbon $date)
    {
        return match ($this->groupBy) {
            'daily' => $date->copy()->endOfDay(),
            'weekly' => $date->copy()->endOfWeek(),
            'monthly' => $date->copy()->endOfMonth(),
            'yearly' => $date->copy()->endOfYear(),
        };
    }


    public function render()
    {
        return view('livewire.admins.reports.mikrotiks.components.mikrotiks-report');
    }
}
