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
                        Add New Package
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
                                        Recuring Hotspot
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
            <livewire:admins.service-plans.edit-static-service-plan :routerId="$switcher->router" />
        @elseif ($switcher->userType === 'pppoe')
            <!-- PPPoE Form -->
            <livewire:admins.service-plans.edit-p-p-po-e-service-plan :routerId="$switcher->router" :pppoeProfiles="$pppoeProfiles" />
        @elseif ($switcher->userType === 'hotspot')
            <!-- Hotspot Manual Form -->
            <livewire:admins.service-plans.edit-hotspot-service-plan :routerId="$switcher->router" :servers="$hspServers"
                :userProfiles="$hspUserProfiles" />
        @endif
    @endif
</div>
