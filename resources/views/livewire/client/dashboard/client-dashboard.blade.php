<div>
    <div class="grid grid-cols-12 gap-x-6">
        <div class="xl:col-span-12 col-span-12">
            <div class="grid grid-cols-12 gap-x-6">
                <div class="xl:col-span-7 col-span-12">
                    <div class="grid grid-cols-12 gap-x-6">
                        <div class="xl:col-span-4 lg:col-span-6 md:col-span-6 col-span-12">
                            <livewire:client.dashboard.profile />
                        </div>
                        <div class="xl:col-span-4 lg:col-span-6 md:col-span-6 col-span-12">
                            <livewire:client.dashboard.download-tracking />
                        </div>
                        <div class="xl:col-span-4 lg:col-span-6 md:col-span-6 col-span-12">
                            <livewire:client.dashboard.upload-tracking />
                        </div>
                    </div>
                </div>
                <div class="xl:col-span-5 col-span-12">
                    <div class="box">
                        <div class="box-body !p-0">
                            <div
                                class="flex flex-wrap items-center border-b border-dashed dark:border-defaultborder/10">
                                <livewire:client.dashboard.subscription-status />
                                <livewire:client.dashboard.expiry-date />
                            </div>
                            <div class="flex flex-wrap items-center">
                                <livewire:client.dashboard.billing-amount />
                                <livewire:client.dashboard.subscription-package />

                            </div>
                        </div>
                    </div>
                </div>
                <div class="xl:col-span-4 col-span-12">
                    <div class="grid grid-cols-12 gap-x-6">
                        <div class="xl:col-span-12 col-span-12">
                            <livewire:client.dashboard.account-balance />
                        </div>
                        <div class="xl:col-span-12 col-span-12">
                            <livewire:client.dashboard.recent-activity />
                        </div>
                        <div class="xl:col-span-12 col-span-12">
                            <livewire:client.dashboard.recent-tickets />
                        </div>
                    </div>
                </div>
                <div class="xl:col-span-8 col-span-12">
                    <div class="grid grid-cols-12 gap-x-6">
                        <div class="xl:col-span-12 col-span-12">
                            <livewire:client.dashboard.payment-trend />
                        </div>
                        <div class="xl:col-span-12 col-span-12">
                            <livewire:client.dashboard.bandwidth-rate />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
