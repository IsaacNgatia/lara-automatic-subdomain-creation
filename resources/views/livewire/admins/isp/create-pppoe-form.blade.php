<div class="grid grid-cols-12 gap-6">
    <div class="xl:col-span-12 col-span-12">
        <div class="box">
            <div class="box-header justify-between">
                <div class="box-title">
                    Add PPPoE User
                </div>
            </div>
            <div class="box-body">
                @if (session()->has('resultError'))
                    <div x-data="{ show: true }" x-show="show" x-on:open-pppoe-error-message.window="show = true"
                        x-init="setTimeout(() => show = false, 50000)" x-transition:leave="transition ease-in duration-300"
                        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                        class="alert alert-outline-danger alert-dismissible fade show flex" role="alert"
                        id="pppoe-error">
                        <div class="sm:flex-shrink-0">
                            {{ session('resultError') }}
                        </div>
                        <div class="ms-auto">
                            <div class="mx-1 my-1">
                                <button type="button" x-on:click="show = false"
                                    class="inline-flex  rounded-sm  focus:outline-none focus:ring-0 focus:ring-offset-0 "
                                    data-hs-remove-element="#pppoe-error">
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
                    <div x-data="{ show: true }" x-show="show" x-on:open-pppoe-success-message.window="show = true"
                        x-init="setTimeout(() => show = false, 5000)" class="alert alert-success"
                        x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <form wire:submit="createPppoeUser" class="grid grid-cols-1 lg:grid-cols-3 gap-4 mt-0">
                    <div>
                        <div class="text-sm md:text-base font-semibold box-header bg-primary text-center text-white">
                            Personal Information</div>
                        <div class="grid grid-cols-12 gap-4 mt-4">
                            <div class="col-span-12">
                                <label class="form-label">Official Name</label>
                                <input wire:model="pppoeForm.officialName" type="text" class="form-control"
                                    placeholder="Official name" aria-label="User Official name">
                                @error('pppoeForm.officialName')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class=" col-span-12">
                                <label for="pppoeUserParentAccount" class="form-label">Select Parent
                                    Account(Optional)</label>
                                <select wire:model="pppoeForm.parentAccount" id="pppoeUserParentAccount"
                                    class="form-select !py-[0.59rem]">
                                    <option selected>Choose Parent Account ...</option>
                                    @foreach ($customerProfiles as $customerProfile)
                                        <option wire:key="{{ $customerProfile['.id'] }}"
                                            value="{{ $customerProfile['id'] }}">
                                            {{ $customerProfile['official_name'] }}</option>
                                    @endforeach
                                </select>
                                @error('pppoeForm.parentAccount')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-span-12">
                                <label for="pppoeUserEmail" class="form-label">Email</label>
                                <input wire:model="pppoeForm.email" type="email" class="form-control"
                                    placeholder="Email" id="pppoeUserEmail">
                                @error('pppoeForm.email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-span-12">
                                <label for="inputAddress" class="form-label">Address</label>
                                <input wire:model="pppoeForm.location" type="text" class="form-control"
                                    id="inputAddress" placeholder="1234-00100 Nairobi">
                                @error('pppoeForm.location')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="text-sm md:text-base font-semibold box-header bg-primary text-center text-white">
                            Mikrotik Information</div>
                        <div class="grid grid-cols-12 gap-4 mt-4">
                            <div class=" col-span-12">
                                <label class="form-label">Username</label>
                                <input wire:model.live="pppoeForm.username" type="text" class="form-control"
                                    placeholder="Jane Doe" aria-label="User name">
                                @error('pppoeForm.username')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class=" col-span-12">
                                <label for="pppoePass" class="form-label">PPPoE Password</label>
                                <div class="flex justify-between gap-4">
                                    <input wire:model.live="pppoeForm.password" type="text" class="form-control"
                                        id="pppoePass" placeholder="PPPoE Password">
                                    <button wire:click="generateRandomPassword" type="button"
                                        class="ti-btn btn-wave ti-btn-primary-full">Random</button>
                                </div>
                                @error('pppoeForm.password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class=" col-span-12">
                                <label for="inputState" class="form-label">Select Package</label>
                                <div class="flex justify-between gap-4">
                                    <select id="inputState" class="form-select !py-[0.59rem]"
                                        wire:model.live.debounce.750ms="pppoeForm.service_plan_id">
                                        <option selected>Choose a package</option>
                                        @foreach ($servicePlans as $servicePlan)
                                            <option value="{{ $servicePlan->id }}">{{ $servicePlan->name }}</option>
                                        @endforeach
                                    </select>
                                    <button wire:click="addPPPoEServicePlan" type="button"
                                        class="ti-btn btn-wave ti-btn-primary-full">Add</button>
                                </div>
                            </div>
                            <div class=" col-span-12">
                                <label for="remoteAddress" class="form-label">Remote Address</label>
                                <input wire:model="pppoeForm.remoteAddress" type="text" class="form-control"
                                    id="remoteAddress" placeholder="Remote Address">
                                @error('pppoeForm.remoteAddress')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class=" col-span-12">
                                <label for="pppoeUserProfile" class="form-label">Profile</label>
                                <select wire:model="pppoeForm.profile" id="pppoeUserProfile"
                                    class="form-select !py-[0.59rem]">
                                    <option selected>Choose Profile ...</option>
                                    @foreach ($pppoeProfiles as $profile)
                                        <option wire:key="{{ $profile['.id'] }}" value="{{ $profile['name'] }}">
                                            {{ $profile['name'] }}</option>
                                    @endforeach
                                </select>
                                @error('pppoeForm.profile')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="text-sm md:text-base font-semibold box-header bg-primary text-center text-white">
                            Payment Information</div>
                        <div class="grid grid-cols-12 gap-4 mt-4">
                            <div class=" col-span-12">
                                <label for="referenceNumber" class="form-label">Reference Number</label>
                                <div class="flex justify-between gap-4">
                                    <input wire:model.live="pppoeForm.referenceNumber" type="text"
                                        class="form-control" placeholder="Reference Number"
                                        aria-label="Reference Number" id="referenceNumber">
                                    <button wire:click="generateUniqueReferenceNumber" type="button"
                                        class="ti-btn btn-wave ti-btn-primary-full">Generate</button>
                                </div>
                                @error('pppoeForm.referenceNumber')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class=" col-span-9">
                                <label for="billingAmount" class="form-label">Bill Amount</label>
                                <input wire:model="pppoeForm.bill" id="billingAmount" type="number"
                                    class="form-control" placeholder="Billing Amount" aria-label="Billing Amount"
                                    style="-webkit-appearance: none; margin: 0; -moz-appearance: textfield;">
                                @error('pppoeForm.bill')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-span-3">
                                <label for="installationFee" class="form-label">Installation</label>
                                <input wire:model="pppoeForm.installationFee" id="installationFee" type="number"
                                    class="form-control" placeholder="Fee" aria-label="Installation Fee"
                                    style="-webkit-appearance: none; margin: 0; -moz-appearance: textfield;">
                                @error('pppoeForm.installationFee')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-span-12">
                                <label for="pppoeBillingCycleValue" class="form-label">Billing Cycle</label>
                                <div class="flex justify-between gap-4">
                                    <select wire:model.live.debounce.750ms="pppoeForm.billingCycle"
                                        id="pppoeBillingCycle" class="form-select !py-[0.59rem]">
                                        <option value="days" @selected($pppoeForm->billingCycle == 'days')>Days</option>
                                        <option value="weeks" @selected($pppoeForm->billingCycle == 'weeks')>Weeks</option>
                                        <option value="months" @selected($pppoeForm->billingCycle == 'months')>Months</option>
                                        <option value="years" @selected($pppoeForm->billingCycle == 'years')>Years</option>
                                    </select>
                                    <input wire:model.live.debounce.750ms="pppoeForm.billingCycleValue" type="text"
                                        class="form-control" id="pppoeBillingCycleValue" value="1">
                                    @error('pppoeForm.billingCycleValue')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-span-12">
                                <label for="pppoePhone" class="form-label">Phone Number</label>
                                <input wire:model="pppoeForm.phone" id="pppoePhone" type="text"
                                    class="form-control" placeholder="Phone Number" aria-label="User Phone Number">
                                @error('pppoeForm.phone')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class=" col-span-12">
                                <label for="pppoeExpiryDate" class="form-label">Expiry date</label>
                                <input wire:model="pppoeForm.expiryDate" type="datetime-local" class="form-control"
                                    id="input-datetime-local">
                                @error('pppoeForm.expiryDate')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-span-12 flex justify-between px-4">
                                <div class="form-check">
                                    <input wire:model="pppoeForm.sendSms" class="form-check-input" type="checkbox"
                                        id="sendSms">
                                    <label class="form-check-label" for="sendSms">
                                        Send sms
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input wire:model="pppoeForm.sendEmail" class="form-check-input" type="checkbox"
                                        id="sendEmail">
                                    <label class="form-check-label" for="sendEmail">
                                        Send email
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-span-12">
                            <button type="submit" class="ti-btn btn-wave ti-btn-primary-full w-full">
                                <span wire:loading class="me-2">Creating
                                    User</span>
                                <span wire:loading class="loading"><i
                                        class="ri-loader-2-fill text-[1rem] animate-spin"></i></span>
                                @if (session()->has('success'))
                                    <span class="me-2">Create another</span>
                                @else
                                    <span wire:loading.class="hidden" class="me-2">Submit</span>
                                @endif
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <x-modal>
            @slot('slot')
                <livewire:admins.isp.modals.create-p-p-po-e-service-plan :routerId="$rId" />
            @endslot
        </x-modal>
    </div>
</div>
