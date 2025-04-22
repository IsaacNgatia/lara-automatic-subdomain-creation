<div class="xl:col-span-12 col-span-12">
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
                                {{ number_format((int) $todaysCollections) }}</h5>
                            <div class="flex justify-between items-center">
                                <div class="text-[#8c9097] dark:text-white/50 text-[0.75rem]">Today's
                                    Collections
                                </div>
                                <div
                                    class="{{ $todaysCollections > $yesterCollections ? 'text-success' : 'text-danger' }}">
                                    <i
                                        class="{{ $todaysCollections > $yesterCollections ? 'ti ti-trending-up' : 'ti ti-trending-down' }} text-[1rem] me-1 align-middle inline-flex"></i>
                                    @if ($yesterCollections != 0)
                                        {{ number_format((($todaysCollections - $yesterCollections) / $yesterCollections) * 100, 2) }}%
                                    @else
                                        0%
                                    @endif
                                </div>
                            </div>
                            <a target="_blank" href="{{ route('payments.all', ['start_date' => $currentDate]) }}"
                                class="text-primary text-[0.75rem]">View All<i
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
                            <h5 class="block font-semibold text-[1.125rem] ">{{ current_currency() }}
                                {{ number_format((int) $monthCollections) }}</h5>
                            <div class="flex justify-between items-center">
                                <div class="text-[#8c9097] dark:text-white/50 text-[0.75rem]">
                                    {{ now(env('APP_TIMEZONE', 'Africa/Nairobi'))->format('F') }}
                                    Subscriptions
                                </div>
                                <div
                                    class="{{ $monthCollections > $previousMonthCollections ? 'text-success' : 'text-danger' }}">
                                    <i
                                        class="{{ $monthCollections > $previousMonthCollections ? 'ti ti-trending-up' : 'ti ti-trending-down' }} text-[1rem] me-1 align-middle inline-flex"></i>
                                    @if ($previousMonthCollections != 0)
                                        {{ number_format((($monthCollections - $previousMonthCollections) / $previousMonthCollections) * 100, 2) }}%
                                    @else
                                        0%
                                    @endif
                                </div>
                            </div>
                            <a target="_blank"
                                href="{{ route('payments.all', ['start_date' => $firstDateOfCurrentMonth, 'end_date' => $lastDateOfCurrentMonth]) }}"
                                class="text-secondary text-[0.75rem]">View All<i
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
                            <h5 class="block font-semibold text-[1.125rem] ">{{ current_currency() }}
                                {{ number_format((int) $yearCollections) }}</h5>
                            <div class="flex justify-between items-center">
                                <div class="text-[#8c9097] dark:text-white/50 text-[0.75rem]">
                                    {{ now(env('APP_TIMEZONE', 'Africa/Nairobi'))->format('Y') }}
                                    Collections
                                </div>
                                <div
                                    class="{{ $yearCollections > $previousYearCollections ? 'text-success' : 'text-danger' }}">
                                    <i
                                        class="{{ $yearCollections > $previousYearCollections ? 'ti ti-trending-up' : 'ti ti-trending-down' }} text-[1rem] me-1 align-middle inline-flex"></i>
                                    @if ($previousYearCollections != 0)
                                        {{ number_format((($yearCollections - $previousYearCollections) / $previousYearCollections) * 100, 2) }}%
                                    @else
                                        0%
                                    @endif
                                </div>
                            </div>
                            <a target="_blank"
                                href="{{ route('payments.all', ['start_date' => $firstDateOfCurrentYear, 'end_date' => $lastDateOfCurrentYear]) }}"
                                class="text-warning text-[0.75rem]">View All<i
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
                            <h5 class="block font-semibold text-[1.125rem] ">{{ current_currency() }} 0.00</h5>
                            <div class="flex justify-between items-center">
                                <div class="text-[#8c9097] dark:text-white/50 text-[0.75rem]">
                                    {{ now(env('APP_TIMEZONE', 'Africa/Nairobi'))->format('F') }}
                                    Expenses
                                </div>
                                <div class="text-success"><i
                                        class="ti ti-trending-up text-[1rem] me-1 align-middle inline-flex"></i>+100.00%
                                </div>
                            </div>
                            <a href="javascript:void(0);" class="text-danger text-[0.75rem]">View All<i
                                    class="ti ti-arrow-narrow-right ms-2 font-semibold inline-block"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
