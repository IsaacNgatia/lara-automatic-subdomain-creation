<!-- Start::row-1 -->
<div class="grid grid-cols-12 gap-x-6">
    <div class="xxl:col-span-4 xl:col-span-12 col-span-12">
        <div class="box overflow-hidden">
            <livewire:admins.customers.components.user-profile :customerId="$customerId" lazy />
        </div>
    </div>
    <div class="xxl:col-span-8 xl:col-span-12 col-span-12">
        <div class="grid grid-cols-12 gap-x-6">
            <div class="xl:col-span-12 col-span-12">
                <div class="box">
                    <div class="box-body !p-0">
                        <div
                            class="!p-4 border-b dark:border-defaultborder/10 border-dashed md:flex items-center justify-between">
                            <nav class="-mb-0.5 sm:flex md:space-x-6 rtl:space-x-reverse pb-2" role="tablist">
                                <a class="w-full sm:w-auto flex active hs-tab-active:font-semibold  hs-tab-active:text-white hs-tab-active:bg-primary rounded-md py-2 px-4 text-primary text-sm"
                                    href="javascript:void(0);" id="payments-tab" data-hs-tab="#payments-tab-pane"
                                    aria-controls="payments-tab-pane">
                                    <i class="bi bi-credit-card me-1 align-middle inline-block"></i>Payments
                                </a>
                                <a class="w-full sm:w-auto flex hs-tab-active:font-semibold  hs-tab-active:text-white hs-tab-active:bg-primary rounded-md  py-2 px-4 text-primary text-sm"
                                    href="javascript:void(0);" id="sms-tab" data-hs-tab="#sms-tab-pane"
                                    aria-controls="sms-tab-pane">
                                    <i class="bi bi-envelope me-1 align-middle inline-block"></i>SMS
                                </a>
                                <a class="w-full sm:w-auto flex hs-tab-active:font-semibold  hs-tab-active:text-white hs-tab-active:bg-primary rounded-md  py-2 px-4 text-primary text-sm"
                                    href="javascript:void(0);" id="tickets-tab" data-hs-tab="#tickets-tab-pane"
                                    aria-controls="tickets-tab-pane">
                                    <i class="bi bi-chat-dots me-1 align-middle inline-block"></i>Tickets
                                </a>
                                <a class="w-full sm:w-auto flex hs-tab-active:font-semibold  hs-tab-active:text-white hs-tab-active:bg-primary rounded-md  py-2 px-4 text-primary text-sm"
                                    href="javascript:void(0);" id="accounts-tab" data-hs-tab="#accounts-tab-pane"
                                    aria-controls="accounts-tab-pane">
                                    <i class="bi bi-user me-1 align-middle inline-block"></i>Related Accounts
                                </a>
                                <a class="w-full sm:w-auto flex hs-tab-active:font-semibold  hs-tab-active:text-white hs-tab-active:bg-primary rounded-md  py-2 px-4 text-primary text-sm"
                                    href="javascript:void(0);" id="activity-tab" data-hs-tab="#activity-tab-pane"
                                    aria-controls="activity-tab-pane">
                                    <i class="bi bi-activity me-1 align-middle inline-block"></i>Activity
                                </a>
                            </nav>
                            <div>
                                <p class="font-semibold mb-2">
                                    {{ $daysRemaining == 'Expired' ? 'Expired' : $daysRemaining . ' remaining' }} -
                                    <button class="text-primary text-[0.75rem]">Request STK</button>
                                </p>
                                <div class="progress progress-xs progress-animate">
                                    @php
                                        $progressClass = match (true) {
                                            $spentPercentage < 70 => 'bg-primary',
                                            $spentPercentage < 90 => 'bg-warning/70',
                                            default => 'bg-danger/80',
                                        };
                                    @endphp

                                    <div class="{{ $progressClass }}" style="width: {{ $spentPercentage }}%;">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="!p-4">
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane show active fade !p-0 !border-0" id="payments-tab-pane"
                                    role="tabpanel" aria-labelledby="payments-tab" tabindex="0">
                                    <div class="xl:col-span-12 col-span-12">
                                        <livewire:admins.customers.components.transactions-chart :customerId="$customerId" />
                                    </div>
                                    <div class="box-body">
                                        <div class="sm:border-b border-gray-200 dark:border-white/10">
                                            <nav class="sm:flex sm:space-x-2 sm:rtl:space-x-reverse" aria-label="Tabs"
                                                role="tablist">
                                                <button type="button"
                                                    class="w-full sm:w-auto hs-tab-active:font-semibold hs-tab-active:border-primary hs-tab-active:text-primary py-4 px-1 inline-flex items-center gap-2 border-b-[3px] border-transparent text-sm whitespace-nowrap text-defaulttextcolor hover:text-primary dark:text-[#8c9097] dark:text-white/50 active"
                                                    id="tabs-with-transactions-table"
                                                    data-hs-tab="#transactions-table-tab"
                                                    aria-controls="transactions-table-tab">
                                                    All Transactions<span
                                                        class="hs-tab-active:bg-primary hs-tab-active:text-white dark:hs-tab-active:bg-primary dark:hs-tab-active:text-white ms-1 py-0.5 px-1.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-black/20 dark:text-gray-300">{{ $transactionsCount < 100 ? $transactionsCount : ($transactionsCount > 1000 ? '999+' : '99+') }}</span>
                                                </button>
                                                <button type="button"
                                                    class="w-full sm:w-auto hs-tab-active:font-semibold hs-tab-active:border-primary hs-tab-active:text-primary py-4 px-1 inline-flex items-center gap-2 border-b-[3px] border-transparent text-sm whitespace-nowrap text-defaulttextcolor hover:text-primary dark:text-[#8c9097] dark:text-white/50"
                                                    id="tab-with-wallet-table" data-hs-tab="#wallet-table-tab"
                                                    aria-controls="wallet-table-tab">
                                                    Wallet <span
                                                        class="hs-tab-active:bg-primary hs-tab-active:text-white dark:hs-tab-active:bg-primary dark:hs-tab-active:text-white ms-1 py-0.5 px-1.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-black/20 dark:text-gray-300">{{ $walletCount < 100 ? $walletCount : ($walletCount > 1000 ? '999+' : '99+') }}</span>
                                                </button>

                                            </nav>
                                        </div>

                                        <div class="mt-3">
                                            <div id="transactions-table-tab" role="tabpanel"
                                                aria-labelledby="tabs-with-transactions-table">
                                                <livewire:admins.customers.components.transactions-table
                                                    :customerId="$customerId" lazy />
                                            </div>
                                            <div id="wallet-table-tab" class="hidden" role="tabpanel"
                                                aria-labelledby="tab-with-wallet-table">
                                                <livewire:admins.customers.components.wallet-table :customerId="$customerId"
                                                    lazy />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade !p-0 !border-0 hidden !rounded-md" id="sms-tab-pane"
                                    role="tabpanel" aria-labelledby="sms-tab" tabindex="0">
                                    <livewire:admins.customers.components.sms-chart :customerId="$customerId" />
                                    <livewire:admins.customers.components.sms-table :customerId="$customerId" lazy />
                                </div>
                                <div class="tab-pane fade !p-0 !border-0 hidden" id="tickets-tab-pane" role="tabpanel"
                                    aria-labelledby="tickets-tab" tabindex="0">
                                    <livewire:admins.customers.components.tickets-table />
                                </div>
                                <div class="tab-pane fade !p-0 !border-0 hidden" id="accounts-tab-pane" role="tabpanel"
                                    aria-labelledby="accounts-tab" tabindex="0">
                                    <livewire:admins.customers.components.child-accounts :customerId="$customerId" lazy/>
                                </div>


                                <div class="tab-pane fade !p-0 !border-0 hidden" id="activity-tab-pane" role="tabpanel"
                                    aria-labelledby="activity-tab" tabindex="0">
                                    <div class="box-body">
                                        <div class="sm:border-b border-gray-200 dark:border-white/10">
                                            <nav class="sm:flex sm:space-x-2 sm:rtl:space-x-reverse" aria-label="Tabs"
                                                role="tablist">
                                                <button type="button"
                                                    class="w-full sm:w-auto hs-tab-active:font-semibold hs-tab-active:border-primary hs-tab-active:text-primary py-4 px-1 inline-flex items-center gap-2 border-b-[3px] border-transparent text-sm whitespace-nowrap text-defaulttextcolor hover:text-primary dark:text-[#8c9097] dark:text-white/50 active"
                                                    id="tabs-with-badges-item-1" data-hs-tab="#system-tab"
                                                    aria-controls="system-tab">
                                                    System
                                                </button>
                                                <button type="button"
                                                    class="w-full sm:w-auto hs-tab-active:font-semibold hs-tab-active:border-primary hs-tab-active:text-primary py-4 px-1 inline-flex items-center gap-2 border-b-[3px] border-transparent text-sm whitespace-nowrap text-defaulttextcolor hover:text-primary dark:text-[#8c9097] dark:text-white/50"
                                                    id="tabs-with-badges-item-2" data-hs-tab="#network-tab"
                                                    aria-controls="network-tab">
                                                    Network
                                                </button>

                                            </nav>
                                        </div>

                                        <div class="mt-3">
                                            <div id="system-tab" role="tabpanel"
                                                aria-labelledby="tabs-with-badges-item-1">
                                                <livewire:admins.customers.components.system-activities />
                                            </div>
                                            <div id="network-tab" class="hidden" role="tabpanel"
                                                aria-labelledby="tabs-with-badges-item-2">
                                                <livewire:admins.customers.components.network-activity />
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
