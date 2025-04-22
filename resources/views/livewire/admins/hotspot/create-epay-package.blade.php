<div class="grid grid-cols-12 gap-6">
    <div class="xl:col-span-12 col-span-12">
        <div class="box">
            <div class="box-header justify-between">
                <div class="box-title">
                    Add Epay Hotspot Package
                </div>
            </div>
            <div class="box-body">
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
                <form wire:submit="createEpayPackage" class="grid grid-cols-12 gap-4 mt-0">
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
                        <select wire:model="serverSelected" id="hspServer" class="form-select !py-[0.59rem]">
                            <option selected>Choose ......</option>
                            @foreach ($servers as $serverName)
                                <option wire:key="{{ $serverName['.id'] }}" value="{{ $serverName['name'] }}">
                                    {{ $serverName['name'] }}</option>
                            @endforeach
                        </select>
                        @error('serverSelected')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="md:col-span-6 col-span-12">
                        <label for="hspProfile" class="form-label">Profile</label>
                        <select wire:model="profileSelected" id="hspProfile" class="form-select !py-[0.59rem]">
                            <option selected>Choose ......</option>
                            @foreach ($userProfiles as $profile)
                                <option wire:key="{{ $profile['.id'] }}" value="{{ $profile['name'] }}">
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
                            <select wire:model="datalimit" id="dataLimit" class="form-select !py-[0.59rem]">
                                <option value="KBs" {{ $dataLimitSelected == 'KBs' ? 'selected' : '' }}>KBs</option>
                                <option value="MBs" {{ $dataLimitSelected == 'MBs' ? 'selected' : '' }}>MBs</option>
                                <option value="GBs" {{ $dataLimitSelected == 'GBs' ? 'selected' : '' }}>GBs</option>
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
                            <select wire:model="timeLimitSelected" id="hspTimeLimit" class="form-select !py-[0.59rem]">
                                <option value="minutes" {{ $timeLimitSelected == 'minutes' ? 'selected' : '' }}>Minutes
                                </option>
                                <option value="hours" {{ $timeLimitSelected == 'hours' ? 'selected' : '' }}>Hours
                                </option>
                                <option value="days" {{ $timeLimitSelected == 'days' ? 'selected' : '' }}>Days
                                </option>
                                <option value="weeks" {{ $timeLimitSelected == 'weeks' ? 'selected' : '' }}>Weeks
                                </option>
                                <option value="months" {{ $timeLimitSelected == 'months' ? 'selected' : '' }}>Months
                                </option>
                                <option value="years" {{ $timeLimitSelected == 'years' ? 'selected' : '' }}>Years
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
                        <button type="submit" class="ti-btn btn-wave ti-btn-primary-full w-full">Add Epay
                            Package</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
