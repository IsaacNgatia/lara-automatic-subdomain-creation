<div>
    <div class="grid grid-cols-12 gap-6">
        <div class="xl:col-span-12 col-span-12">
            <div class="box">
                <div class="box-header justify-between">
                    <div class="box-title">
                        Mikrotiks Report
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
                    @endif
                    <form wire:submit="generateReport" class="sm:grid grid-cols-12 gap-4 items-center">
                        <div class="xl:col-span-4 col-span-12">
                            <label for="select-1" class="ti-form-select rounded-sm !py-2 !px-0 label">Starting
                                Date</label>
                            <div class="input-group">
                                <div class="input-group-text text-[#8c9097] dark:text-white/50 !border-e-0">
                                    <i class="ri-time-line"></i>
                                </div>
                                <input wire:model="startingDate" type="text" class="form-control" id="datetime">
                            </div>
                            @error('startingDate')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="xl:col-span-4 col-span-12">
                            <label for="select-1" class="ti-form-select rounded-sm !py-2 !px-0 label">Ending Date
                            </label>
                            <div class="input-group">
                                <div class="input-group-text text-[#8c9097] dark:text-white/50 !border-e-0">
                                    <i class="ri-time-line"></i>
                                </div>
                                <input wire:model="endingDate" type="text" class="form-control" id="datetime">
                            </div>
                            @error('endingDate')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="xl:col-span-4 col-span-12">
                            <label for="select-1" class="ti-form-select rounded-sm !py-2 !px-0 label">Group By</label>
                            <select wire:model.live="groupInto" class="ti-form-select rounded-sm !py-2 !px-3">
                                <option value="none" {{ $groupInto === 'none' ? 'selected' : '' }}>None</option>
                                <option value="daily" {{ $groupInto === 'daily' ? 'selected' : '' }}>Days</option>
                                <option value="monthly" {{ $groupInto === 'monthly' ? 'selected' : '' }}>Months</option>
                                <option value="yearly" {{ $groupInto === 'yearly' ? 'selected' : '' }}>Years</option>
                            </select>
                            @error('groupInto')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="xl:col-span-9 col-span-12">
                            <div class="flex justify-between items-center">
                                <label class="ti-form-label">Select Mikrotiks</label>
                                <p class="flex gap-1"><span>Mikrotiks: </span><span>
                                        {{ sizeof($selectedMikrotiks) }}</span>
                                </p>
                            </div>
                            <!-- Select -->
                            <div class="relative">
                                <!-- Select -->
                                <x-multi-select model="selectedMikrotiks" class="select-custom"
                                    placeholderValue="Type to search mikrotiks" :options="$mikrotiks" valueKey="id"
                                    displayName="name" />
                                <!-- End Select -->
                                @error('selectedMikrotiks')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <!-- End Select -->
                        </div>

                        <button wire:loading.attr="disabled" wire:loading.class="opacity-50 cursor-not-allowed"
                            wire:target="generateReport" type="submit"
                            class="ti-btn btn-wave ti-btn-primary-full col-span-3">
                            <span wire:loading wire:target="generateReport" class="me-2">Generating Report...</span>
                            <span wire:loading wire:target="generateReport" class="loading"><i
                                    class="ri-loader-2-fill text-[1rem] animate-spin"></i></span>

                            <span class="me-2">Generate Report</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @if ($createReport)
        <!-- selected mikrotiks report -->
        <livewire:admins.reports.mikrotiks.components.mikrotiks-report :startingDate="$startingDate" :endingDate="$endingDate"
            :mikrotikIds="$selectedMikrotiks" :groupBy="$groupInto" lazy />
    @endif
</div>
