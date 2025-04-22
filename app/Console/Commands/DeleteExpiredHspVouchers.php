<?php

namespace App\Console\Commands;

use App\Models\HotspotEpay;
use Illuminate\Console\Command;

class DeleteExpiredHspVouchers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-expired-hsp-vouchers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete expired Epay and Cash Hotspot vouchers';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        HotspotEpay::deleteExpiredVouchers();
    }
}
