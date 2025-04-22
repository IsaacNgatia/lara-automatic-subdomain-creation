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
                    <form wire:submit="createPurchaseForSelectedCustomer" class="sm:grid grid-cols-3 gap-4 items-center">
                        <div>
                            <label for="select-1" class="ti-form-select rounded-sm !py-2 !px-0 label">User Type</label>
                            <select wire:model.live="userType" class="ti-form-select rounded-sm !py-2 !px-3">
                                <option selected>Select User Type</option>
                                <option value="all" {{ $userType === 'all' ? 'selected' : '' }}>All</option>
                                <option value="static" {{ $userType === 'static' ? 'selected' : '' }}>Static</option>
                                <option value="pppoe" {{ $userType === 'pppoe' ? 'selected' : '' }}>PPPoE</option>
                                <option value="rhsp" {{ $userType === 'rhsp' ? 'selected' : '' }}>Recurring</option>
                            </select>
                            @error('userType')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label class="ti-form-select rounded-sm !py-2 !px-0 label">Select Customer</label>
                            <select wire:model="selectedCustomer" class="ti-form-select rounded-sm !py-2 !px-3"
                                data-trigger name="choices-single-default" id="choices-single-default">
                                <option selected>Select Customer</option>
                                @foreach ($customers as $customer)
                                    <option wire:key="{{ $customer->id }}" value="{{ $customer->id }}">
                                        {{ $customer->official_name }}</option>
                                @endforeach
                            </select>

                            <!-- End Select -->

                            @error('selectedCustomer')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="ti-btn btn-wave ti-btn-primary-full !mb-0 mt-4">
                            <span wire:loading wire:target="createPurchaseForSelectedCustomer" class="me-2">
                                Submitting</span>
                            <span wire:loading wire:target="createPurchaseForSelectedCustomer" class="loading"><i
                                    class="ri-loader-2-fill text-[1rem] animate-spin"></i></span>
                            <span wire:loading.class="hidden" wire:target="createPurchaseForSelectedCustomer"
                                class="me-2">Submit
                            </span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if ($createPurchase)
        <livewire:admins.payments.cash-purchase.create-purchase :customerId="$selectedCustomer" lazy />
    @endif
</div>
