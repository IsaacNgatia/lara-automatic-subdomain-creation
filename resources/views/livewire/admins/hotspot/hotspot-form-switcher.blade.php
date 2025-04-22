<div>
    <div class="grid grid-cols-12 gap-6">
        <div class="xl:col-span-12 col-span-12">
            <div class="box">
                <div class="box-header justify-between">
                    <div class="box-title">
                        Add New Vouchers
                    </div>
                </div>
                <div class="box-body">
                    <form wire:submit.prevent="submitHspSwitcherForm" class="sm:grid grid-cols-3 gap-4 items-center">
                        <div>
                            <select wire:model.live="hspSwitcher.routerId"
                                data-hs-select='{"hasSearch": true, "searchClasses": "block w-full text-sm border-gray-200 rounded-sm focus:border-primary focus:ring-primary before:absolute before:inset-0 before:z-[1] dark:bg-bodybg dark:border-white/10 dark:text-white/70 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-primary py-2 px-3 dark:placeholder:text-white/50","searchWrapperClasses": "bg-white p-2 -mx-1 sticky top-0 dark:bg-bodybg", "placeholder": "Select Mikrotik...", "toggleTag": "<button type=\"button\"><span class=\"me-2\" data-icon></span><span class=\"text-gray-800 dark:text-gray-200\" data-title></span></button>",   "toggleClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-3 px-4 pe-9 flex text-nowrap w-full cursor-pointer bg-white border border-gray-200 rounded-sm text-start text-sm focus:border-primary focus:ring-primary before:absolute before:inset-0 before:z-[1] dark:bg-bodybg dark:border-white/10 dark:text-white/70 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-primary", "dropdownClasses": "mt-2 max-h-72 pb-1 px-1 space-y-0.5 z-20 w-full bg-white border border-gray-200 rounded-sm overflow-hidden overflow-y-auto dark:bg-bodybg dark:border-white/10", "optionClasses": "py-2 px-4 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-sm focus:outline-none focus:bg-gray-100 dark:bg-bodybg dark:hover:bg-bodybg dark:text-gray-200 dark:focus:bg-bodybg", "optionTemplate": "<div><div class=\"flex items-center\"><div class=\"me-2\" data-icon></div><div class=\"text-gray-800 dark:text-gray-200\" data-title></div></div></div>"}'
                                class="{{ $routers->isEmpty() ? 'disabled opacity-50' : '' }}"
                                {{ $routers->isEmpty() ? 'disabled' : '' }}>
                                @if ($routers->isEmpty() || $routers == null)
                                    <option>No Mikrotik Available</option>
                                @endif
                                @if ($routers->isNotEmpty())
                                    @foreach ($routers as $router)
                                        <option value="{{ $router->id }}" wire:key="{{ $router->id }}"
                                            data-hs-select-option='{
                                        "icon": "<img class=\"inline-block size-4 rounded-full\" src=\"{{ $this->getRouterStatusIcon($router->id) }}\" alt=\"Router\" />"
                                    }'>
                                            {{ $router->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            @error('hspSwitcher.routerId')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="flex items-center justify-around md:justify-evenly gap-3 mt-4 md:mt-0">
                            <div class="form-check form-check-md flex items-center form-check-inline">
                                <input wire:model="voucherType" class="form-check-input" type="radio" value="epay"
                                    id="epay" name="userType" {{ $voucherType === 'epay' ? 'checked' : '' }}>
                                <label class="form-check-label" for="epay">
                                    Epay Package
                                </label>
                            </div>
                            <div class="form-check form-check-md flex items-center form-check-inline">
                                <input wire:model="voucherType" class="form-check-input" type="radio" value="cash"
                                    id="cash" name="userType" {{ $voucherType === 'cash' ? 'checked' : '' }}>
                                <label class="form-check-label" for="cash">
                                    Cash Vouchers
                                </label>
                            </div>
                            <div class="form-check form-check-md flex items-center form-check-inline">
                                <input wire:model="voucherType" wire:model="voucherType" class="form-check-input"
                                    type="radio" value="recurring" id="recurring" name="userType"
                                    {{ $voucherType === 'recurring' ? 'checked' : '' }}>
                                <label class="form-check-label" for="recurring">
                                    Recurring User
                                </label>
                            </div>

                        </div>
                        <button type="submit"
                            class="ti-btn ti-btn-primary-full ti-btn-loader btn-wave m-2 w-full  {{ $routers->isEmpty() ? 'disabled opacity-50' : '' }}"
                            {{ $routers->isEmpty() ? 'disabled' : '' }}>
                            <span wire:loading.class="hidden" class="me-2">Submit</span>
                            <span wire:loading wire.target="submitHspSwitcherForm" class="me-2">Checking Router for
                                Connection</span>
                            <span wire:loading wire.target="submitHspSwitcherForm" class="loading"><i
                                    class="ri-loader-2-fill text-[1rem] animate-spin"></i></span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- @if ($errors->any())
    <div class="grid grid-cols-12 gap-4">
        <div class="xxl:col-span-6 col-span-12">
            <div class="alert alert-danger overflow-hidden !p-0" role="alert"
                id="dismiss-alert65">
                <div class="p-4 bg-danger text-white flex justify-between">
                    <h6 class="aletr-heading mb-0 text-[1rem]"> @foreach ($errors->all() as $error)
                        {{ $error }}
                    @endforeach
                    </h6>
                    <button type="button"
                        class="inline-flex  rounded-sm  focus:outline-none focus:ring-0 focus:ring-offset-0 "
                        data-hs-remove-element="#dismiss-alert65">
                        <span class="sr-only">Dismiss</span>
                        <svg class="h-3 w-3" width="16" height="16" viewBox="0 0 16 16"
                            fill="none" xmlns="http://www.w3.org/2000/svg"
                            aria-hidden="true">
                            <path
                                d="M0.92524 0.687069C1.126 0.486219 1.39823 0.373377 1.68209 0.373377C1.96597 0.373377 2.2382 0.486219 2.43894 0.687069L8.10514 6.35813L13.7714 0.687069C13.8701 0.584748 13.9882 0.503105 14.1188 0.446962C14.2494 0.39082 14.3899 0.361248 14.5321 0.360026C14.6742 0.358783 14.8151 0.38589 14.9468 0.439762C15.0782 0.493633 15.1977 0.573197 15.2983 0.673783C15.3987 0.774389 15.4784 0.894026 15.5321 1.02568C15.5859 1.15736 15.6131 1.29845 15.6118 1.44071C15.6105 1.58297 15.5809 1.72357 15.5248 1.85428C15.4688 1.98499 15.3872 2.10324 15.2851 2.20206L9.61883 7.87312L15.2851 13.5441C15.4801 13.7462 15.588 14.0168 15.5854 14.2977C15.5831 14.5787 15.4705 14.8474 15.272 15.046C15.0735 15.2449 14.805 15.3574 14.5244 15.3599C14.2437 15.3623 13.9733 15.2543 13.7714 15.0591L8.10514 9.38812L2.43894 15.0591C2.23704 15.2543 1.96663 15.3623 1.68594 15.3599C1.40526 15.3574 1.13677 15.2449 0.938279 15.046C0.739807 14.8474 0.627232 14.5787 0.624791 14.2977C0.62235 14.0168 0.730236 13.7462 0.92524 13.5441L6.59144 7.87312L0.92524 2.20206C0.724562 2.00115 0.611816 1.72867 0.611816 1.44457C0.611816 1.16047 0.724562 0.887983 0.92524 0.687069Z"
                                fill="currentColor" />
                        </svg>
                    </button>
                </div>

                <div class="p-3">
                    <p class="mb-0">You can test the router status by clicking the button below.</p>
                    <button wire:click="checkRouterStatus" class="ti-btn ti-btn-primary-full ti-btn-loader btn-wave m-2 w-full max-w-56">
                        <span wire:loading.class="hidden" class="me-2">Check Router Status</span>
                        <span wire:loading wire.target="checkRouterStatus" class="me-2">Checking...</span>
                        <span wire:loading wire.target="checkRouterStatus" class="loading"><i
                                class="ri-loader-2-fill text-[1rem] animate-spin"></i></span>
                    </button>
                </div>
            </div>
        </div>
    @endif --}}
    @if ($submitted && $routerStatus)
        @if ($voucherType === 'epay')
            {{-- Hotspot Epay Hotspot Package Form --}}
            <livewire:admins.hotspot.create-epay-package :servers="$hspServers" :userProfiles="$hspUserProfiles" :routerId="$hspSwitcher->routerId" />
        @elseif ($voucherType === 'cash')
            <!-- Hotspot Cash Form -->
            <livewire:admins.hotspot.create-cash-vouchers :servers="$hspServers" :userProfiles="$hspUserProfiles" />
        @elseif ($voucherType === 'recurring')
            <!-- Recurring Vouchers Form -->
            <livewire:admins.hotspot.create-recurring-voucher :servers="$hspServers" :userProfiles="$hspUserProfiles" />
        @endif
    @endif
</div>
