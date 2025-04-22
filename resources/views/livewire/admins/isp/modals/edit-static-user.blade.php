<div class="grid grid-cols-12 gap-6">
    <div class="xl:col-span-12 col-span-12">
        <div class="box">
            <div class="box-header justify-between">
                <div class="box-title">
                    Update Static User
                </div>
                <div class="flex justify-between items-center lg:w-1/2">
                    <div>
                        @if ($routerStatus == true && $checkingStatus == false)
                            <span class="badge bg-success text-white">Active</span>
                        @elseif ($checkingStatus == true && $routerStatus == false)
                            <div class="flex items-center gap-2">
                                <span> Checking Router for connection...</span>
                                <div class="ti-spinner text-light" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>
                        @else
                            <button wire:click="checkRouterStatus" type="button"
                                class="ti-btn ti-btn-secondary btn-wave">Check Status</button>
                        @endif

                    </div>
                </div>
            </div>
            <div x-data="{ routerStatus: @js($routerStatus) }" x-init="$nextTick(() => { $dispatch('checkout-status'); if (!routerStatus) { setTimeout(() => { $dispatch('checkout-status') }, 5000) } })" class="box-body">
                @if (session()->has('resultError'))
                    <div x-data="{ show: true }" x-show="show" x-on:open-static-error-message.window="show = true"
                        x-init="setTimeout(() => show = false, 50000)" x-transition:leave="transition ease-in duration-300"
                        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                        class="alert alert-outline-danger alert-dismissible fade show flex" role="alert"
                        id="static-error">
                        <div class="sm:flex-shrink-0">
                            {{ session('resultError') }}
                        </div>
                        <div class="ms-auto">
                            <div class="mx-1 my-1">
                                <button type="button" x-on:click="show = false"
                                    class="inline-flex  rounded-sm  focus:outline-none focus:ring-0 focus:ring-offset-0 "
                                    data-hs-remove-element="#static-error">
                                    <span class="sr-only">Dismiss</span>
                                    <svg class="h-3 w-3" width="16" height="16" viewBox="0 0 16 16"
                                        fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                        <path
                                            d="M0.92524 0.687069C1.126 0.486219 1.39823 0.373377 1.68209 0.373377C1.96597 0.373377 2.2382 0.486219 2.43894 0.687069L8.10514 6.35813L13.7714 0.687069C13.8701 0.584748 13.9882 0.503105 14.1188 0.446962C14.2494 0.39082 14.3899 0.361248 14.5321 0.360026C14.6742 0.358783 14.8151 0.38589 14.9468 0.439762C15.0782 0.493633 15.1977 0.573197 15.2983 0.673783C15.3987 0.774389 15.4784 0.894026 15.5321 1.02568C15.5859 1.15736 15.6131 1.29845 15.6118 1.44071C15.6105 1.58297 15.5809 1.72357 15.5248 1.85428C15.4688 1.98499 15.3872 2.10324 15.2851 2.20206L9.61883 7.87312L15.2851 13.5441C15.4801 13.7462 15.588 14.0168 15.5854 14.2977C15.5831 14.5787 15.4705 14.8474 15.272 15.046C15.0735 15.2449 14.805 15.3574 14.5244 15.3599C14.2437 15.3623 13.9733 15.2543 13.7714 15.0591L8.10514 9.38812L2.43894 15.0591C2.23704 15.2543 1.96663 15.3623 1.68594 15.3599C1.40526 15.3574 1.13677 15.2449 0.938279 15.046C0.739807 14.8474 0.627232 14.5787 0.624791 14.2977C0.62235 14.0168 0.730236 13.7462 0.92524 13.5441L6.59144 7.87312L0.92524 2.20206C0.724562 2.00115 0.611816 1.72867 0.611816 1.44457C0.611816 1.16047 0.724562 0.887983 0.92524 0.687069Z"
                                            fill="currentColor" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                @elseif (session()->has('success'))
                    <div x-data="{ show: true }" x-show="show" x-on:open-static-success-message.window="show = true"
                        x-init="setTimeout(() => show = false, 5000)" class="alert alert-success"
                        x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <form wire:submit="updateStaticUser" class="grid grid-cols-1 lg:grid-cols-3 gap-4 mt-0">
                    <div>
                        <div class="text-sm md:text-base font-semibold box-header">Personal Information</div>
                        <div class="grid grid-cols-12 gap-4 mt-4">
                            <div class=" col-span-12">
                                <label for="staticMikrotikName" class="form-label">Username</label>
                                <input wire:model.live="username" type="text"
                                    class="form-control {{ !$routerStatus ? 'text-muted' : '' }}"
                                    placeholder="Enter username" aria-label="Mikrotik Name" id="staticMikrotikName"
                                    {{ !$routerStatus ? 'disabled' : '' }}>
                                @error('username')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-span-12">
                                <label for="staticOfficialName" class="form-label">Official Name</label>
                                <input wire:model="officialName" type="text" class="form-control"
                                    placeholder="First name" aria-label="Official Name" id="staticOfficialName">
                                @error('officialName')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-span-12">
                                <label for="staticEmail" class="form-label">Email</label>
                                <input wire:model="email" type="email" class="form-control" id="staticEmail"
                                    aria-label="Email">
                            </div>

                            <div class="col-span-12">
                                <label for="staticLocation" class="form-label">Location</label>
                                <input wire:model="location" type="text" class="form-control" id="staticLocation"
                                    placeholder="Nairobi" aria-label="User's Location">
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="text-sm md:text-base font-semibold box-header">Mikrotik Information</div>
                        <div class="grid grid-cols-12 gap-4 mt-4">
                            <div class=" col-span-12">
                                <label for="staticServicePlan" class="form-label">Select Service Plan</label>
                                <div class="flex justify-between gap-4">
                                    <select id="staticServicePlan" class="form-select !py-[0.59rem]"
                                        aria-label="Static Service Plan">
                                        <option selected>Choose...</option>
                                        <option>...</option>
                                    </select>
                                    <button type="button" class="ti-btn btn-wave ti-btn-primary-full">Add</button>
                                </div>
                            </div>

                            <div class=" col-span-12">
                                <label for="staticTargetAddress" class="form-label">Ip Address</label>
                                <input wire:model="ip" type="text"
                                    class="form-control {{ !$routerStatus ? 'text-muted' : '' }}"
                                    id="staticTargetAddress" aria-label="Ip Address"
                                    {{ !$routerStatus ? 'disabled' : '' }}>
                                @error('ip')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class=" col-span-12">
                                <label for="staticMaxLimit" class="form-label">Max Limit</label>
                                <input wire:model="maxLimit" type="text"
                                    class="form-control {{ !$routerStatus ? 'text-muted' : '' }}" id="staticMaxLimit"
                                    aria-label="User Speed Limit" {{ !$routerStatus ? 'disabled' : '' }}>
                                @error('maxLimit')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            {{-- <div class="col-span-12 ">
                                <label for="staticUserStatus" class="form-label">Status</label>
                                <select wire:model="status" id="staticUserStatus"
                                    class="form-select !py-[0.59rem] {{ !$routerStatus ? 'opacity-70' : '' }}"
                                    aria-label="User Status" {{ !$routerStatus ? 'disabled' : '' }}>
                                    <option value="yes" @selected($status == 'yes')>Enabled</option>
                                    <option value="no" @selected($status == 'no')>Disabled</option>
                                </select>
                            </div> --}}
                        </div>
                    </div>

                    <div>
                        <div class="text-sm md:text-base font-semibold box-header">Payment Information</div>
                        <div class="grid grid-cols-12 gap-4 mt-4">
                            <div class=" col-span-12">
                                <label for="staticReferenceNo" class="form-label">Reference Number</label>
                                <div class="flex justify-between gap-4">
                                    <input wire:model.live="referenceNumber" type="text" class="form-control"
                                        placeholder="Reference Number" id="staticReferenceNo"
                                        aria-label="User Reference Number">
                                    <button wire.click="generateUniqueReferenceNumber" type="button"
                                        class="ti-btn btn-wave ti-btn-primary-full">Generate</button>
                                </div>
                                @error('referenceNumber')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class=" col-span-12">
                                <label for="billingAmount" class="form-label">Bill Amount</label>
                                <input wire:model="bill" id="billingAmount" type="text" class="form-control"
                                    placeholder="Billing Amount" aria-label="Billing Amount">
                                @error('bill')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class=" col-span-12">
                                <label for="staticBillingCycle" class="form-label">Billing Cycle</label>
                                <div class="flex justify-between gap-4">
                                    <select wire:model="billingCycle" id="staticBillingCycle"
                                        class="form-select !py-[0.59rem]">
                                        <option value="days" @selected($billingCycle == 'days')>Days</option>
                                        <option value="weeks" @selected($billingCycle == 'weeks')>Weeks</option>
                                        <option value="months" @selected($billingCycle == 'months')>Months</option>
                                        <option value="years" @selected($billingCycle == 'years')>Years</option>
                                    </select>
                                    <input wire:model="billingCycleValue" type="text" class="form-control"
                                        id="staticBillingCycleValue" value="1">
                                    @error('billingCycleValue')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-span-12">
                                <label for="staticPhone" class="form-label">Phone Number</label>
                                <input wire:model="phone" type="text" class="form-control"
                                    placeholder="Phone Number" aria-label="User Phone Number" id="staticPhone">
                                @error('phone')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class=" col-span-12">
                                <label for="staticExpiryDate" class="form-label">Expiry date</label>
                                <input wire:model="expiryDate" type="datetime-local"
                                    class="form-control {{ !$routerStatus ? 'text-muted' : '' }}"
                                    id="input-datetime-local" {{ !$routerStatus ? 'disabled' : '' }}>
                                @error('expiryDate')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>
                        <div class="col-span-12">
                            <button type="submit"
                                class="ti-btn ti-btn-primary-full ti-btn-loader btn-wave m-2 w-full">

                                <span wire:loading wire:target="updateStaticUser" class="me-2">Updating
                                    User</span>
                                <span wire:loading wire:target="updateStaticUser" class="loading"><i
                                        class="ri-loader-2-fill text-[1rem] animate-spin"></i></span>

                                <span class="me-2">Update</span>
                            </button>
                        </div>
                    </div>
            </div>

            </form>
        </div>
    </div>
</div>
</div>
