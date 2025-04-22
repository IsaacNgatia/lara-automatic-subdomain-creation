<div class="grid grid-cols-12 gap-6">
    <div class="xl:col-span-12 col-span-12">
        <div class="box">
            <div class="box-header justify-between">
                <div class="box-title">
                    Update Epay Hotspot Package
                </div>
                <div class="flex justify-between items-center lg:w-1/2">
                    <div>
                        @if ($routerStatus == true && $checkingStatus == false)
                            <span class="badge bg-success text-white">Active</span>
                        @elseif ($checkingStatus == true && $routerStatus == false)
                            <div class="flex items-center gap-2">
                                <span> Checking Router for connection</span>
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
                    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" class="alert alert-danger"
                        x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0">
                        {{ session('resultError') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @elseif (session()->has('success'))
                    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" class="alert alert-success"
                        x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <form wire:submit="updateEpayPackage" class="grid grid-cols-12 gap-4 mt-0">
                    <div class="md:col-span-6 col-span-12">
                        <label for="title" class="form-label">Name to be Displayed</label>
                        <input wire:model="title" type="text" id="title" class="form-control"
                            placeholder="Unlimited 2hrs for 20/=" aria-label="title">
                        @error('title')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="md:col-span-6 col-span-12">
                        <label for="passwordStatus" class="form-label">Create with Password</label>
                        <select wire:model="passwordStatus" id="passwordStatus" class="form-select !py-[0.59rem]">
                            <option value="0" {{ $passwordStatus == 0 ? 'selected' : '' }}>No
                            </option>
                            <option value="1" {{ $passwordStatus == 1 ? 'selected' : '' }}>Yes
                            </option>
                        </select>
                        @error('passwordStatus')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="md:col-span-6 col-span-12">
                        <label for="hspServer" class="form-label">Server</label>
                        <select wire:model="serverSelected" id="hspServer"
                            class="form-select !py-[0.59rem] {{ !$routerStatus ? 'opacity-70' : '' }}"
                            {{ !$routerStatus ? 'disabled' : '' }}>
                            @foreach ($servers as $serverName)
                                <option wire:key="{{ $serverName['.id'] }}" value="{{ $serverName['name'] }}"
                                    @selected($serverName['name'] == $serverSelected)>
                                    {{ $serverName['name'] }}</option>
                            @endforeach
                        </select>
                        @error('serverSelected')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="md:col-span-6 col-span-12">
                        <label for="hspProfile" class="form-label">Profile</label>
                        <select wire:model="profileSelected" id="hspProfile"
                            class="form-select !py-[0.59rem] {{ !$routerStatus ? 'opacity-70' : '' }}"
                            {{ !$routerStatus ? 'disabled' : '' }}>
                            @foreach ($userProfiles as $profile)
                                <option wire:key="{{ $profile['.id'] }}" value="{{ $profile['name'] }}"
                                    @selected($profile['name'] == $profileSelected)>
                                    {{ $profile['name'] }}</option>
                            @endforeach
                        </select>
                        @error('profileSelected')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-span-12 md:col-span-6">
                        <label for="dataLimit" class="form-label">Data Limit</label>
                        <div class="flex justify-between gap-4">
                            <select wire:model="dataLimitUnit" id="dataLimit" class="form-select !py-[0.59rem]">
                                <option value="KBs" {{ $dataLimitUnit == 'KBs' ? 'selected' : '' }}>KBs</option>
                                <option value="MBs" {{ $dataLimitUnit == 'MBs' ? 'selected' : '' }}>MBs</option>
                                <option value="GBs" {{ $dataLimitUnit == 'GBs' ? 'selected' : '' }}>GBs</option>
                            </select>
                            <input wire:model="dataLimitValue" type="text" class="form-control" id="dataLimitValue"
                                placeholder="0 for unlimited">
                        </div>
                        @error('dataLimitValue')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-span-12 md:col-span-6">
                        <label for="hspTimeLimit" class="form-label">Time Limit</label>
                        <div class="flex justify-between gap-4">
                            <select wire:model="timeLimitUnit" id="hspTimeLimit" class="form-select !py-[0.59rem]">
                                <option value="minutes" {{ $timeLimitUnit == 'minutes' ? 'selected' : '' }}>Minutes
                                </option>
                                <option value="hours" {{ $timeLimitUnit == 'hours' ? 'selected' : '' }}>Hours
                                </option>
                                <option value="days" {{ $timeLimitUnit == 'days' ? 'selected' : '' }}>Days
                                </option>
                                <option value="weeks" {{ $timeLimitUnit == 'weeks' ? 'selected' : '' }}>Weeks
                                </option>
                                <option value="months" {{ $timeLimitUnit == 'months' ? 'selected' : '' }}>Months
                                </option>
                                <option value="years" {{ $timeLimitUnit == 'years' ? 'selected' : '' }}>Years
                                </option>
                            </select>
                            <input wire:model="timeLimitValue" type="text" class="form-control"
                                id="hspTimeLimitValue" placeholder="3">
                        </div>
                        @error('timeLimitValue')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="md:col-span-6 col-span-12">
                        <label for="voucherLength" class="form-label">Name Length</label>
                        <select wire:model="lengthSelected" id="voucherLength" class="form-select !py-[0.59rem]">
                            <option value="4" {{ $lengthSelected == '4' ? 'selected' : '' }}>4</option>
                            <option value="5" {{ $lengthSelected == '5' ? 'selected' : '' }}>5</option>
                            <option value="6" {{ $lengthSelected == '6' ? 'selected' : '' }}>6</option>
                            <option value="7" {{ $lengthSelected == '7' ? 'selected' : '' }}>7</option>
                            <option value="8" {{ $lengthSelected == '8' ? 'selected' : '' }}>8</option>
                            <option value="9" {{ $lengthSelected == '9' ? 'selected' : '' }}>9</option>
                        </select>
                        @error('lengthSelected')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-span-12 md:col-span-6">
                        <label for="hspPrice" class="form-label">Price</label>
                        <input wire:model="price" type="text" class="form-control" id="hspPrice"
                            placeholder="100">
                        @error('price')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-span-12">
                        <button type="submit" class="ti-btn btn-wave ti-btn-primary-full w-full">
                            <span wire:loading wire:target="updateEpayPackage" class="me-2">Updating
                                Epay Hotspot Package</span>
                            <span wire:loading wire:target="updateEpayPackage" class="loading"><i
                                    class="ri-loader-2-fill text-[1rem] animate-spin"></i></span>
                            <span wire:loading.class="hidden" wire:target="updateEpayPackage" class="me-2">Update
                                Epay Hotspot Package</span></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
