{{-- <div x-data x-init="$nextTick(() => {
    const selectElement = document.querySelector('select[wire\\:model=\'router\']');
    if (selectElement) {
        new HSSelect(selectElement);
    }
})">

    <!-- select mikrotik and router -->
    <div class="grid grid-cols-12 gap-6">
        <div class="xl:col-span-12 col-span-12">
            <div class="box">
                <div class="box-header justify-between">
                    <div class="box-title">
                        Add New User
                    </div>
                </div>
                <div class="box-body">
                    <form wire:submit.prevent="checkRouterStatus" class="sm:grid grid-cols-3 gap-4 items-center">
                        <div>
                            <select wire:model.live="switcher.router"
                                class="ti-form-select rounded-sm !py-2 !px-3 {{ $routers->isEmpty() ? 'disabled opacity-50' : '' }}">
                                @if ($routers->isEmpty() || $routers == null)
                                    <option>No Mikrotik Available</option>
                                @endif
                                @if ($routers->isNotEmpty())
                                    @foreach ($routers as $router)
                                        <option value="{{ $router->id }}" wire:key="{{ $router->id }}">
                                            {{ $router->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            @error('switcher.router')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <div class="flex items-center justify-around md:justify-evenly mt-4 md:mt-0">
                                <div class="form-check form-check-md flex items-center form-check-inline">
                                    <input wire:model="switcher.userType" class="form-check-input" type="radio" value="static"
                                        id="static-customer" name="customerType"
                                        {{ $switcher->userType === 'static' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="static-customer">
                                        Static
                                    </label>
                                </div>
                                <div class="form-check form-check-md flex items-center form-check-inline">
                                    <input wire:model="switcher.userType" class="form-check-input" type="radio" value="pppoe"
                                        id="pppoe-customer" name="customerType"
                                        {{ $switcher->userType === 'pppoe' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="pppoe-customer">
                                        PPPoE
                                    </label>
                                </div>
                                <div class="form-check form-check-md flex items-center form-check-inline">
                                    <input wire:model="switcher.userType" class="form-check-input" type="radio" value="hotspot"
                                        id="hotspot-voucher" name="customerType"
                                        {{ $switcher->userType === 'hotspot' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="hotspot-voucher">
                                        Hotspot
                                    </label>
                                </div>
                            </div>
                            @error('userType')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <button type="submit"
                            class="ti-btn ti-btn-primary-full ti-btn-loader btn-wave m-2 w-full {{ $routers->isEmpty() ? 'disabled opacity-50' : '' }}"
                            {{ $routers->isEmpty() ? 'disabled' : '' }}>
                            <span wire:loading.class="hidden" class="me-2">Submit</span>
                            <span wire:loading wire.target="submitStaticForm" class="me-2">Checking Router
                                Connection</span>
                            <span wire:loading wire.target="submitStaticForm" class="loading"><i
                                    class="ri-loader-2-fill text-[1rem] animate-spin"></i></span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @if ($submitted && $routerStatus)
        @if ($switcher->userType === 'static')
            <!-- Static Form -->
            <livewire:admins.isp.create-static-form :routerId="$switcher->router" />
        @elseif ($switcher->userType === 'pppoe')
            <!-- PPPoE Form -->
            <livewire:admins.isp.create-pppoe-form :routerId="$switcher->router" :pppoeProfiles="$pppoeProfiles" />
        @elseif ($switcher->userType === 'hotspot')
            <!-- Hotspot Manual Form -->
            <livewire:admins.hotspot.create-epay-vouchers :routerId="$switcher->router" :servers="$hspServers" :userProfiles="$hspUserProfiles" />
        @endif
    @endif
</div> --}}

{{-- <div x-data x-init="$nextTick(() => {
    const selectElement = document.querySelector('select[wire\\:model=\'switcher.router\']');
    if (selectElement) {
        new HSSelect(selectElement);
    }
})">

    <!-- Select Mikrotik and Router -->
    <div class="grid grid-cols-12 gap-6">
        <div class="xl:col-span-12 col-span-12">
            <div class="box relative">
                <!-- Centered Loader -->
                <div wire:loading wire:target="checkRouterStatus" class="absolute inset-0 bg-white bg-opacity-75 flex items-center justify-center z-10">
                    <div class="text-center">
                        <i class="ri-loader-2-fill text-primary text-4xl animate-spin"></i>
                        <p class="mt-2 text-primary font-semibold">Loading...</p>
                    </div>
                </div>

                <div class="box-header justify-between">
                    <div class="box-title">
                        Add New User
                    </div>
                </div>
                <div class="box-body">
                    <form wire:submit.prevent="checkRouterStatus" class="sm:grid grid-cols-3 gap-4 items-center">
                        <!-- Router Select -->
                        <div>
                            <select wire:model.live="switcher.router"
                                class="ti-form-select rounded-sm !py-2 !px-3 {{ $routers->isEmpty() ? 'disabled opacity-50' : '' }}">
                                @if ($routers->isEmpty() || $routers == null)
                                    <option>No Mikrotik Available</option>
                                @endif
                                @if ($routers->isNotEmpty())
                                    @foreach ($routers as $router)
                                        <option value="{{ $router->id }}" wire:key="{{ $router->id }}">
                                            {{ $router->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            @error('switcher.router')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- User Type Selection -->
                        <div>
                            <div class="flex items-center justify-around md:justify-evenly mt-4 md:mt-0">
                                <div class="form-check form-check-md flex items-center form-check-inline">
                                    <input wire:model="switcher.userType" class="form-check-input" type="radio" value="static"
                                        id="static-customer" name="customerType">
                                    <label class="form-check-label" for="static-customer">
                                        Static
                                    </label>
                                </div>
                                <div class="form-check form-check-md flex items-center form-check-inline">
                                    <input wire:model="switcher.userType" class="form-check-input" type="radio" value="pppoe"
                                        id="pppoe-customer" name="customerType">
                                    <label class="form-check-label" for="pppoe-customer">
                                        PPPoE
                                    </label>
                                </div>
                                <div class="form-check form-check-md flex items-center form-check-inline">
                                    <input wire:model="switcher.userType" class="form-check-input" type="radio" value="hotspot"
                                        id="hotspot-voucher" name="customerType">
                                    <label class="form-check-label" for="hotspot-voucher">
                                        Hotspot
                                    </label>
                                </div>
                            </div>
                            @error('userType')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div>
                            <button type="submit"
                                class="ti-btn ti-btn-primary-full ti-btn-loader btn-wave m-2 w-full {{ $routers->isEmpty() ? 'disabled opacity-50' : '' }}"
                                {{ $routers->isEmpty() ? 'disabled' : '' }}>
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
                <!-- Error Message -->
                @if ($errorMessage)
                    <div class="mt-4 text-center text-danger">
                        {{ $errorMessage }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Conditional Forms -->
    @if ($submitted && $routerStatus)
        @if ($switcher->userType === 'static')
            <!-- Static Form -->
            <livewire:admins.isp.create-static-form :routerId="$switcher->router" />
        @elseif ($switcher->userType === 'pppoe')
            <!-- PPPoE Form -->
            <livewire:admins.isp.create-pppoe-form :routerId="$switcher->router" :pppoeProfiles="$pppoeProfiles" />
        @elseif ($switcher->userType === 'hotspot')
            <!-- Hotspot Manual Form -->
            <livewire:admins.hotspot.create-epay-vouchers :routerId="$switcher->router" :servers="$hspServers" :userProfiles="$hspUserProfiles" />
        @endif
    @endif
</div> --}}


<div x-data x-init="$nextTick(() => {
    const selectElement = document.querySelector('select[wire\\:model=\'switcher.router\']');
    if (selectElement) {
        new HSSelect(selectElement);
    }
})">

    <!-- Select Mikrotik and Router -->
    <div class="grid grid-cols-12 gap-6">
        <div class="xl:col-span-12 col-span-12">
            <div class="box relative">
                <!-- Centered Loader -->
                {{-- <div wire:loading wire:target="checkRouterStatus"
                    class="absolute inset-0 bg-white bg-opacity-75 flex items-center justify-center z-10">
                    <div class="text-center">
                        <i class="ri-loader-2-fill text-primary text-4xl animate-spin"></i>
                        <p class="mt-2 text-primary font-semibold">Loading...</p>
                    </div>
                </div> --}}

                <div wire:loading wire:target="checkRouterStatus">
                    <x-loader message="Checking router for connection" />
                </div>

                <div class="box-header justify-between">
                    <div class="box-title">
                        Add New User
                    </div>
                </div>
                <div class="box-body">
                    <form wire:submit.prevent="checkRouterStatus" class="sm:grid grid-cols-3 gap-4 items-center">
                        <!-- Router Select -->
                        <div>
                            <select wire:model.live="switcher.router"
                                class="ti-form-select rounded-sm !py-2 !px-3 {{ $routers->isEmpty() ? 'disabled opacity-50' : '' }}">
                                @if ($routers->isEmpty() || $routers == null)
                                    <option>No Mikrotik Available</option>
                                @endif
                                @if ($routers->isNotEmpty())
                                    @foreach ($routers as $router)
                                        <option value="{{ $router->id }}" wire:key="{{ $router->id }}">
                                            {{ $router->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            @error('switcher.router')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- User Type Selection -->
                        <div>
                            <div class="flex items-center justify-around md:justify-evenly mt-4 md:mt-0">
                                <div class="form-check form-check-md flex items-center form-check-inline">
                                    <input wire:model="switcher.userType" class="form-check-input" type="radio"
                                        value="static" id="static-customer" name="customerType">
                                    <label class="form-check-label" for="static-customer">
                                        Static
                                    </label>
                                </div>
                                <div class="form-check form-check-md flex items-center form-check-inline">
                                    <input wire:model="switcher.userType" class="form-check-input" type="radio"
                                        value="pppoe" id="pppoe-customer" name="customerType">
                                    <label class="form-check-label" for="pppoe-customer">
                                        PPPoE
                                    </label>
                                </div>
                                <div class="form-check form-check-md flex items-center form-check-inline">
                                    <input wire:model="switcher.userType" class="form-check-input" type="radio"
                                        value="hotspot" id="hotspot-voucher" name="customerType">
                                    <label class="form-check-label" for="hotspot-voucher">
                                        Hotspot
                                    </label>
                                </div>
                            </div>
                            @error('userType')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div>
                            <button type="submit"
                                class="ti-btn ti-btn-primary-full ti-btn-loader btn-wave m-2 w-full {{ $routers->isEmpty() ? 'disabled opacity-50' : '' }}"
                                {{ $routers->isEmpty() ? 'disabled' : '' }}>
                                Submit
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Error Message -->
                @if ($errorMessage)
                    <x-response-card type="error" title="Error" message="{{ $errorMessage }}" />
                @endif
            </div>
        </div>
    </div>


    <!-- Conditional Forms -->
    @if ($submitted && $routerStatus)
        @if ($switcher->userType === 'static')
            <!-- Static Form -->
            <livewire:admins.isp.create-static-form :routerId="$switcher->router" />
        @elseif ($switcher->userType === 'pppoe')
            <!-- PPPoE Form -->
            <livewire:admins.isp.create-pppoe-form :routerId="$switcher->router" :pppoeProfiles="$pppoeProfiles" />
        @elseif ($switcher->userType === 'hotspot')
            <!-- Hotspot Manual Form -->
            <livewire:admins.hotspot.create-epay-vouchers :routerId="$switcher->router" :servers="$hspServers" :userProfiles="$hspUserProfiles" />
        @endif
    @endif
</div>
