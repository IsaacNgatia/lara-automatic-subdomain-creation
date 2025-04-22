<div class="grid grid-cols-12 gap-6">
    <div class="xl:col-span-12 col-span-12">
        <div class="box">
            <div class="box-header justify-between">
                <div class="box-title">
                    Add Expiry SMS Template
                </div>
            </div>
            <div class="box-body">
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
                <form wire:submit="addTemplate" class="space-y-4 mt-0">
                    <div class="grid grid-cols-12 gap-4">
                        <div class="col-span-6">
                            <label for="expenseTypeName" class="form-label">Select Day to Send SMS</label>
                            <select wire:model.live="dayToSend" id="day-to-send" class="form-select !py-[0.59rem]">
                                <option value="0" {{ $dayToSend == 0 ? 'selected' : '' }}>Exact Day</option>
                                <option value="1" {{ $dayToSend == 1 ? 'selected' : '' }}>1 Day</option>
                                <option value="2" {{ $dayToSend == 2 ? 'selected' : '' }}>2 Days</option>
                                <option value="3" {{ $dayToSend == 3 ? 'selected' : '' }}>3 Days</option>
                                <option value="4" {{ $dayToSend == 4 ? 'selected' : '' }}>4 Days</option>
                                <option value="5" {{ $dayToSend == 5 ? 'selected' : '' }}>5 Days</option>
                                <option value="6" {{ $dayToSend == 6 ? 'selected' : '' }}>6 Days</option>
                                <option value="7" {{ $dayToSend == 7 ? 'selected' : '' }}>7 Days</option>
                            </select>
                            @error('dayToSend')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-span-6">
                            <label for="expenseTypeName" class="form-label">Before/After</label>
                            <select wire:model.live="beforeAfter" id="before-after"
                                class="form-select !py-[0.59rem] disabled:opacity-50"
                                {{ $dayToSend == 0 ? 'disabled' : '' }}>
                                @if ($dayToSend == 0)
                                    <option value="n/a" selected>Not Applicable</option>
                                @else
                                    <option value="before" {{ $beforeAfter == 'before' ? 'selected' : '' }}>Before
                                    </option>
                                    <option value="after" {{ $beforeAfter == 'after' ? 'selected' : '' }}>After
                                    </option>
                                @endif
                            </select>
                            @error('beforeAfter')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-span-12">
                            <label for="expenseTypeDescription" class="form-label">Template</label>
                            <div class="ti-btn-list space-x-1 space-y-1 rtl:space-x-reverse flex-wrap mb-2">
                                <button type="button"
                                    class="ti-btn-outline-secondary border border-secondary py-0.5 px-1.5 !rounded-full btn-wave text-xs md:text-sm"
                                    value="{official_name}"
                                    onclick="insertAtCursor('{official_name}', 'expiry-sms-template')">Official
                                    Name</button>
                                <button type="button"
                                    class="ti-btn-outline-secondary border border-secondary py-0.5 px-1.5 !rounded-full btn-wave text-xs md:text-sm"
                                    value="{reference_number}"
                                    onclick="insertAtCursor('{reference_number}', 'expiry-sms-template')">Reference
                                    Number</button>
                                <button type="button"
                                    class="ti-btn-outline-secondary border border-secondary py-0.5 px-1.5 !rounded-full btn-wave text-xs md:text-sm"
                                    value="{phone}" onclick="insertAtCursor('{phone}', 'expiry-sms-template')">Mobile
                                    Number</button>
                                <button type="button"
                                    class="ti-btn-outline-secondary border border-secondary py-0.5 px-1.5 !rounded-full btn-wave text-xs md:text-sm"
                                    value="{bill}" onclick="insertAtCursor('{bill}', 'expiry-sms-template')">Bill
                                    Amount</button>
                                <button type="button"
                                    class="ti-btn-outline-secondary border border-secondary py-0.5 px-1.5 !rounded-full btn-wave text-xs md:text-sm"
                                    value="{expiry_date}"
                                    onclick="insertAtCursor('{expiry_date}', 'expiry-sms-template')">Expiry
                                    Date</button>
                                <button type="button"
                                    class="ti-btn-outline-secondary border border-secondary py-0.5 px-1.5 !rounded-full btn-wave text-xs md:text-sm"
                                    value="{user_url}"
                                    onclick="insertAtCursor('{user_url}', 'expiry-sms-template')">User
                                    Account
                                    URL</button>
                            </div>

                            <textarea wire:model="template" id="expiry-sms-template" class="ti-form-input" rows="8"
                                placeholder="Type your message here"></textarea>
                            @error('template')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="">
                        <button wire:loading.attr="disabled" wire:target="addTemplate"
                            wire:loading.class="opacity-50 cursor-not-allowed" type="submit"
                            class="ti-btn btn-wave ti-btn-primary-full w-full">
                            <span wire:loading.remove wire:target="addTemplate">Save</span>
                            <span wire:loading wire:target="addTemplate">Saving Expiry Template</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
