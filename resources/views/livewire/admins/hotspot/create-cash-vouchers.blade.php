<div class="grid grid-cols-12 gap-6">
    <div class="xl:col-span-12 col-span-12">
        <div class="box">
            <div class="box-header justify-between">
                <div class="box-title">
                    Add Cash Hotspot Vouchers
                </div>
            </div>
            <div class="box-body">
                @if (session()->has('error'))
                    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" class="alert alert-danger"
                        x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0">
                        {{ session('error') }}
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
                <form wire:submit="createHotspotUser" class="grid grid-cols-12 gap-4 mt-0">
                    <div class="md:col-span-6 col-span-12">
                        <label class="form-label">Quantity</label>
                        <input wire:model="hotspotForm.quantity" type="text" class="form-control"
                            placeholder="Number of vouchers" aria-label="Quantity of vouchers">
                        @error('hotspotForm.quantity')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="md:col-span-6 col-span-12">
                        <label for="passwordStatus" class="form-label">Create with Password</label>
                        <select wire:model="hotspotForm.passwordStatus" id="passwordStatus"
                            class="form-select !py-[0.59rem]">
                            <option value="0" {{ $hotspotForm->passwordStatus == '0' ? 'selected' : '' }}>No
                            </option>
                            <option value="1" {{ $hotspotForm->passwordStatus == '1' ? 'selected' : '' }}>Yes
                            </option>
                        </select>
                        @error('hotspotForm.passwordStatus')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="md:col-span-6 col-span-12">
                        <label for="hspServer" class="form-label">Server</label>
                        <select wire:model="hotspotForm.server" id="hspServer" class="form-select !py-[0.59rem]">
                            <option selected>Choose ......</option>
                            @foreach ($servers as $serverName)
                                <option wire:key="{{ $serverName['.id'] }}" value="{{ $serverName['name'] }}">
                                    {{ $serverName['name'] }}</option>
                            @endforeach
                        </select>
                        @error('hotspotForm.server')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="md:col-span-6 col-span-12">
                        <label for="hspProfile" class="form-label">Profile</label>
                        <select wire:model="hotspotForm.profile" id="hspProfile" class="form-select !py-[0.59rem]">
                            <option selected>Choose ......</option>
                            @foreach ($userProfiles as $profile)
                                <option wire:key="{{ $profile['.id'] }}" value="{{ $profile['name'] }}">
                                    {{ $profile['name'] }}</option>
                            @endforeach
                        </select>
                        @error('hotspotForm.profile')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-span-12 md:col-span-6">
                        <label for="inputEmail4" class="form-label">Data Limit</label>
                        <div class="flex justify-between gap-4">
                            <select wire:model="hotspotForm.datalimit" id="dataLimit" class="form-select !py-[0.59rem]">
                                <option value="KBs" {{ $dataLimitSelected == 'KBs' ? 'selected' : '' }}>KBs</option>
                                <option value="MBs" {{ $dataLimitSelected == 'MBs' ? 'selected' : '' }}>MBs</option>
                                <option value="GBs" {{ $dataLimitSelected == 'GBs' ? 'selected' : '' }}>GBs</option>
                            </select>
                            <input wire:model="hotspotForm.datalimitValue" type="text" class="form-control"
                                id="dataLimitValue">
                        </div>
                        @error('hotspotForm.datalimit')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-span-12 md:col-span-6">
                        <label for="inputEmail4" class="form-label">Time Limit</label>
                        <div class="flex justify-between gap-4">
                            <select value="hotspotForm.timelimit" id="hspTimeLimit" class="form-select !py-[0.59rem]">
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
                            <input wire:model="hotspotForm.timelimitValue" type="text" class="form-control"
                                id="hspTimeLimitValue">
                        </div>
                        @error('hotspotForm.timelimitValue')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="md:col-span-6 col-span-12">
                        <label for="inputZip" class="form-label">Name Length</label>
                        <select wire:model="hotspotForm.voucherLength" id="voucherLength"
                            class="form-select !py-[0.59rem]">
                            <option value="4" {{ $lengthSelected == '4' ? 'selected' : '' }}>4</option>
                            <option value="5" {{ $lengthSelected == '5' ? 'selected' : '' }}>5</option>
                            <option value="6" {{ $lengthSelected == '6' ? 'selected' : '' }}>6</option>
                            <option value="7" {{ $lengthSelected == '7' ? 'selected' : '' }}>7</option>
                            <option value="8" {{ $lengthSelected == '8' ? 'selected' : '' }}>8</option>
                            <option value="9" {{ $lengthSelected == '9' ? 'selected' : '' }}>9</option>
                        </select>
                        @error('hotspotForm.voucherLength')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-span-12 md:col-span-6">
                        <label for="inputAddress" class="form-label">Price</label>
                        <input wire:model="hotspotForm.price" type="text" class="form-control" id="hspPrice"
                            placeholder="1234 Main St">
                        @error('hotspotForm.price')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-span-12">
                        <button type="submit"
                                    class="ti-btn ti-btn-primary-full ti-btn-loader btn-wave m-2 w-full">
                                    <span wire:loading.class="hidden" class="me-2">Generate Cash Vouchers</span>
                                    <span wire:loading wire.target="createHotspotUser" class="me-2">Creating
                                        Cash Vouchers</span>
                                    <span wire:loading wire.target="createHotspotUser" class="loading"><i
                                            class="ri-loader-2-fill text-[1rem] animate-spin"></i></span>
                                    @if (session()->has('success'))
                                        <span class="text-success">Create more</span>
                                    @endif
                                </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
