<div class="grid grid-cols-12 gap-6">
    <div class="xl:col-span-12 col-span-12">
        <div class="box">
            <div class="box-header justify-between">
                <div class="box-title">
                    Cash Purchase Form
                </div>
            </div>
            <div class="box-body">
                @if (session()->has('resultError'))
                    <div x-data="{ show: true }" x-show="show" x-on:open-pppoe-error-message.window="show = true"
                        x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0"
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
                        class="alert alert-success" x-transition:leave="transition ease-in duration-300"
                        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <form wire:submit="createPurchase" class="grid grid-cols-1 lg:grid-cols-2 gap-4 mt-0">
                    <div>
                        <div class="text-sm md:text-base font-semibold box-header text-primary">Client Information</div>
                        <div class="grid grid-cols-12 gap-4 mt-4">
                            <div class=" col-span-12">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" value="{{ $mikrotikInfo->mikrotik_name }}"
                                    aria-label="username" disabled>
                            </div>
                            <div class="col-span-12">
                                <label class="form-label">Official Name</label>
                                <input type="text" class="form-control" value="{{ $customer->official_name }}"
                                    aria-label="official_name" disabled>
                            </div>
                            <div class="col-span-12">
                                <label for="status" class="form-label">Status</label>
                                <select class="ti-form-select rounded-sm !p-2" id="select-beast-disabled"
                                    autocomplete="off" disabled value="{{ $customer->status }}">
                                    <option value="inactive">Inactive</option>
                                    <option value="active" selected>Active</option>
                                </select>
                            </div>
                            <div class=" col-span-12">
                                <label class="form-label">Bill Amount</label>
                                <input type="text" class="form-control" placeholder="1000" aria-label="bill"
                                    value="{{ $customer->billing_amount }}" disabled>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="text-sm md:text-base font-semibold box-header text-primary">Payment Information
                        </div>
                        <div class="grid grid-cols-12 gap-4 mt-4">
                            <div class="col-span-12">
                                <label class="form-label">Phone Number</label>
                                <input type="text" class="form-control" value="{{ $customer->phone_number }}"
                                    aria-label="phone" disabled>
                            </div>
                            <div class=" col-span-12">
                                <label for="reference" class="form-label">Reference Number</label>
                                <input type="text" class="form-control" value="{{ $customer->reference_number }}"
                                    aria-label="reference_number" disabled>
                            </div>
                            <div class=" col-span-12">
                                <label class="form-label">Amount Received</label>
                                <input wire:model="amount" type="text" class="form-control" placeholder="1000"
                                    aria-label="amount">
                                @error('amount')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-span-12">
                                <label class="form-label">Transaction Comment (Optional)</label>
                                <input type="text" class="form-control" placeholder="Sth about the transaction"
                                    aria-label="comment">
                                @error('comment')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>

                    </div>
                    <div class="col-span-2">
                        <button type="submit" class="ti-btn btn-wave ti-btn-primary-full w-full">
                            <span wire:loading wire:target="createPurchase" class="me-2">Adding
                                Transaction</span>
                            <span wire:loading wire:target="createPurchase" class="loading"><i
                                    class="ri-loader-2-fill text-[1rem] animate-spin"></i></span>
                            <span wire:loading.class="hidden" wire:target="createPurchase" class="me-2">Add
                                Transaction</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
