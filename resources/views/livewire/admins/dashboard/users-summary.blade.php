<div class="grid grid-cols-12 gap-x-6">
    <div class="xxl:col-span-6 xl:col-span-6 lg:col-span-6 md:col-span-6 sm:col-span-12 col-span-12">
        <div class="box">
            <div class="box-body">
                <div class="flex flex-wrap items-start gap-2">
                    <div class="me-1">
                        <span class="avatar avatar-lg bg-primary">
                            <i class="ti ti-wallet text-[1.25rem] text-white"></i>
                        </span>
                    </div>
                    <div class="flex-grow">
                        <h5 class="block font-semibold text-[1.125rem]">{{ current_currency() }}
                            {{ number_format((int) $currentSumSubscription) }}</h5>
                        <div class="flex justify-between items-center">
                            <div class="text-[#8c9097] dark:text-white/50 text-[0.75rem]">
                                {{ now(env('APP_TIMEZONE', 'Africa/Nairobi'))->format('F') }}<br />Collections
                            </div>
                            <div
                                class="{{ $currentSumSubscription > $previousSumSubscription ? 'text-success' : 'text-danger' }}">
                                <i
                                    class="{{ $currentSumSubscription > $previousSumSubscription ? 'ti ti-trending-up' : 'ti ti-trending-down' }} text-[1rem] me-1 align-middle inline-flex"></i>
                                @if ($previousSumSubscription != 0)
                                    {{ number_format((($currentSumSubscription - $previousSumSubscription) / $previousSumSubscription) * 100, 2) }}%
                                @else
                                    0%
                                @endif
                            </div>
                        </div>
                        <a href="javascript:void(0);" class="text-primary text-[0.75rem]">View All<i
                                class="ti ti-arrow-narrow-right ms-2 font-semibold inline-block"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="xxl:col-span-6 xl:col-span-6 lg:col-span-6 md:col-span-6 sm:col-span-12 col-span-12">
        <div class="box">
            <div class="box-body">
                <div class="flex flex-wrap gap-2 items-start">
                    <div class="me-1">
                        <span class="avatar avatar-lg bg-secondary text-white">
                            <i class="ti ti-users text-[1.25rem]"></i>
                        </span>
                    </div>
                    <div class="flex-grow">
                        <h5 class="block font-semibold text-[1.125rem] ">{{ $totalUsers }}</h5>
                        <div class="flex justify-between items-center">
                            <div class="text-[#8c9097] dark:text-white/50 text-[0.75rem]">Total Users</div>
                        </div>
                        <a href="javascript:void(0);" class="text-secondary text-[0.75rem]">View All<i
                                class="ti ti-arrow-narrow-right ms-2 font-semibold inline-block"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="xxl:col-span-6 xl:col-span-6 lg:col-span-6 md:col-span-6 sm:col-span-12 col-span-12">
        <div class="box">
            <div class="box-body">
                <div class="flex flex-wrap gap-2 items-start">
                    <div class="me-1">
                        <span class="avatar avatar-lg bg-warning text-white">
                            <i class="ti ti-id text-[1.25rem]"></i>
                        </span>
                    </div>
                    <div class="flex-grow">
                        <h5 class="block font-semibold text-[1.125rem] ">{{ $activeUsers }}</h5>
                        <div class="flex justify-between items-center">
                            <div class="text-[#8c9097] dark:text-white/50 text-[0.75rem]">Active Users
                            </div>
                        </div>
                        <a href="javascript:void(0);" class="text-warning text-[0.75rem]">View All<i
                                class="ti ti-arrow-narrow-right ms-2 font-semibold inline-block"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="xxl:col-span-6 xl:col-span-6 lg:col-span-6 md:col-span-6 sm:col-span-12 col-span-12">
        <div class="box">
            <div class="box-body">
                <div class="flex flex-wrap gap-2 items-start">
                    <div class="me-1">
                        <span class="avatar avatar-lg bg-danger text-white">
                            <i class="ti ti-gift text-[1.25rem]"></i>
                        </span>
                    </div>
                    <div class="flex-grow">
                        <h5 class="block font-semibold text-[1.125rem] ">{{ $inactiveUsers }}</h5>
                        <div class="flex justify-between items-center">
                            <div class="text-[#8c9097] dark:text-white/50 text-[0.75rem]">Inactive Users</div>
                        </div>
                        <a href="javascript:void(0);" class="text-danger text-[0.75rem]">View All<i
                                class="ti ti-arrow-narrow-right ms-2 font-semibold inline-block"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
