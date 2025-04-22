<div class="box" style="margin-bottom: 0rem">
    <div class="box-header justify-between">
        <div class="box-title">Transactions</div>
        <div class="hs-dropdown ti-dropdown">
            <a href="javascript:void(0);" class="text-[0.75rem] px-2 font-normal text-[#8c9097] dark:text-white/50"
                aria-expanded="false">
                2024<i class="ri-arrow-down-s-line align-middle ms-1 inline-block"></i>
            </a>
            <ul class="hs-dropdown-menu ti-dropdown-menu hidden" role="menu">
                <li><a class="ti-dropdown-item !py-2 !px-[0.9375rem] !text-[0.8125rem] !font-medium block"
                        href="javascript:void(0);">2023</a></li>
                <li><a class="ti-dropdown-item !py-2 !px-[0.9375rem] !text-[0.8125rem] !font-medium block"
                        href="javascript:void(0);">2022</a></li>
                <li><a class="ti-dropdown-item !py-2 !px-[0.9375rem] !text-[0.8125rem] !font-medium block"
                        href="javascript:void(0);">2021</a></li>
            </ul>
        </div>
    </div>
    <div class="box-body">
        <div class="sm:grid sm:grid-cols-12 lg:ps-[3rem] pb-2 sm:gap-0 gap-y-3">
            <div class="xl:col-span-4 lg:col-span-4 md:col-span-4 sm:col-span-4">
                <div class="mb-1 earning first-half ms-4">First Half</div>
                <div class="mb-0">
                    <span
                        class="mt-1 text-[1rem] font-semibold">{{ current_currency() }}{{ $this->formatToK($firstHalfSum) }}</span>
                    <span
                        class="badge {{ $firstHalfSum > $secondHalfSum ? 'bg-success/10 text-success' : 'bg-danger/10 text-danger' }} !px-1 !py-2 text-[0.625rem]">
                        @if ($secondHalfSum != 0)
                            {{ number_format((($firstHalfSum - $secondHalfSum) / $secondHalfSum) * 100, 2) }}%
                        @else
                            0%
                        @endif
                    </span>
                </div>
            </div>
            <div class="xl:col-span-4 lg:col-span-4 md:col-span-4 sm:col-span-4">
                <div class="mb-1 earning top-gross ms-4">Highest Payment
                </div>
                <div class="mb-0">
                    <span class="mt-1 text-[1rem] font-semibold">{{ current_currency() }}
                        {{ number_format(max($monthlyTransactions)) ?? 0 }}</span>
                </div>
            </div>
            <div class="xl:col-span-4 lg:col-span-4 md:col-span-4 sm:col-span-4">
                <div class="mb-1 earning second-half ms-3">Second Half
                </div>
                <div class="mb-0">
                    <span
                        class="mt-1 text-[1rem] font-semibold">{{ current_currency() }}{{ $this->formatToK($secondHalfSum) }}</span>
                    <span
                        class="badge {{ $secondHalfSum > $firstHalfSum ? 'bg-success/10 text-success' : 'bg-danger/10 text-danger' }} !px-1 !py-2 text-[0.625rem]">
                        @if ($firstHalfSum != 0)
                            {{ number_format((($secondHalfSum - $firstHalfSum) / $firstHalfSum) * 100, 2) }}%
                        @else
                            0%
                        @endif
                    </span>
                </div>
            </div>
        </div>
        <script>
            window.monthlyTransactions = @json($monthlyTransactions);
        </script>
        <div id="transactions-chart"></div>
    </div>
</div>
