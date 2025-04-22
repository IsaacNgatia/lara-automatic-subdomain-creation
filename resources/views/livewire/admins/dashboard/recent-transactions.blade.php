<div class="xl:col-span-3 col-span-12">
    <div class="box">
        <div class="box-header">
            <div class="box-title">Most Recent Transactions</div>
        </div>
        <div class="box-body">
            <ul class="list-none courses-instructors mb-0">
                @if (count($transactions) == 0)
                    <li class="text-center">
                        <span class="text-gray-600">No transactions found</span>
                    </li>
                @endif
                @foreach ($transactions as $transaction)
                    <li>
                        <div class="flex">
                            <div class="flex flex-grow items-center">
                                <div class="me-2">
                                    <span class="avatar avatar-rounded">
                                        @switch($transaction['payment_gateway'])
                                            @case('mpesa')
                                            <img src="{{ asset('build/assets/images/brand-logos/mpesa-logo.png') }}" @break
                                                @case('cash') <img
                                                src="{{ asset('build/assets/images/brand-logos/cash.png') }}" @break
                                            @endswitch alt="transactions">
                                    </span>
                                </div>
                                <div>
                                    <span
                                        class="block font-semibold">{{ $transaction['first_name'] . ' ' . $transaction['last_name'] }}</span>
                                    <span class="text-[#8c9097] dark:text-white/50">
                                        @switch($transaction['payment_gateway'])
                                            @case('mpesa')
                                                M-PESA
                                            @break

                                            @case('cash')
                                                CASH
                                            @break
                                        @endswitch
                                    </span>
                                </div>
                            </div>
                            <div class="text-end">
                                <span class="block text-primary font-semibold">{{ current_currency() }}
                                    {{ $transaction['trans_amount'] }}</span>
                                <span class="text-[#8c9097] dark:text-white/50">{{ $transaction['trans_time'] }}</span>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
