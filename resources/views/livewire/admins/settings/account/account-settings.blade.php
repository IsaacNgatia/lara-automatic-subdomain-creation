<div class="grid grid-cols-12 gap-x-6">
    <div class="xxl:col-span-4 xl:col-span-12 col-span-12">
        @if (session()->has('logoError'))
            <div x-data="{ show: true }" x-show="show" x-on:open-pppoe-error-message.window="show = true"
                x-init="setTimeout(() => show = false, 50000)" x-transition:leave="transition ease-in duration-300"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                class="alert alert-outline-danger alert-dismissible fade show flex" role="alert" id="pppoe-error">
                <div class="sm:flex-shrink-0">
                    {{ session('logoError') }}
                </div>
                <div class="ms-auto">
                    <div class="mx-1 my-1">
                        <button type="button" x-on:click="show = false"
                            class="inline-flex  rounded-sm  focus:outline-none focus:ring-0 focus:ring-offset-0 "
                            data-hs-remove-element="#pppoe-error">
                            <span class="sr-only">Dismiss</span>
                            <svg class="h-3 w-3" width="16" height="16" viewBox="0 0 16 16" fill="none"
                                xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path
                                    d="M0.92524 0.687069C1.126 0.486219 1.39823 0.373377 1.68209 0.373377C1.96597 0.373377 2.2382 0.486219 2.43894 0.687069L8.10514 6.35813L13.7714 0.687069C13.8701 0.584748 13.9882 0.503105 14.1188 0.446962C14.2494 0.39082 14.3899 0.361248 14.5321 0.360026C14.6742 0.358783 14.8151 0.38589 14.9468 0.439762C15.0782 0.493633 15.1977 0.573197 15.2983 0.673783C15.3987 0.774389 15.4784 0.894026 15.5321 1.02568C15.5859 1.15736 15.6131 1.29845 15.6118 1.44071C15.6105 1.58297 15.5809 1.72357 15.5248 1.85428C15.4688 1.98499 15.3872 2.10324 15.2851 2.20206L9.61883 7.87312L15.2851 13.5441C15.4801 13.7462 15.588 14.0168 15.5854 14.2977C15.5831 14.5787 15.4705 14.8474 15.272 15.046C15.0735 15.2449 14.805 15.3574 14.5244 15.3599C14.2437 15.3623 13.9733 15.2543 13.7714 15.0591L8.10514 9.38812L2.43894 15.0591C2.23704 15.2543 1.96663 15.3623 1.68594 15.3599C1.40526 15.3574 1.13677 15.2449 0.938279 15.046C0.739807 14.8474 0.627232 14.5787 0.624791 14.2977C0.62235 14.0168 0.730236 13.7462 0.92524 13.5441L6.59144 7.87312L0.92524 2.20206C0.724562 2.00115 0.611816 1.72867 0.611816 1.44457C0.611816 1.16047 0.724562 0.887983 0.92524 0.687069Z"
                                    fill="currentColor" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        @elseif (session()->has('logoSuccess'))
            <div x-data="{ show: true }" x-show="show" x-on:open-pppoe-success-message.window="show = true"
                x-init="setTimeout(() => show = false, 5000)" class="alert alert-success" x-transition:leave="transition ease-in duration-300"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                {{ session('logoSuccess') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="box">
            <div class="box-body !p-0">
                <div class="text-sm md:text-base font-semibold box-header bg-primary text-center text-white">
                    Logo Settings
                </div>
                <form wire:submit="saveLogo" class="grid grid-cols-1 gap-4 m-4">
                    <div>
                        <div class="mb-4 m-4 flex justify-center">
                            @if ($logo)
                                @if (is_string($logo))
                                    <img src="{{ asset('storage/' . $logo) }}" id="logo-preview"
                                        class="w-full max-w-xs h-auto object-contain max-h-[10rem]" alt="Company Logo">
                                @else
                                    {{-- <img src="{{ $logo->temporaryUrl() }}" id="logo-preview"
                                            class="w-full max-w-xs h-auto object-contain" alt="Logo Preview"> --}}
                                    <div class="relative w-full max-w-xs max-h-[12rem]">
                                        <img src="{{ $logo->temporaryUrl() }}" id="logo-preview"
                                            class="w-full h-auto object-contain" alt="Logo Preview">

                                        <div
                                            class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center text-white text-sm font-semibold">
                                            This is a preview
                                        </div>
                                    </div>
                                @endif
                            @else
                                <img src="{{ asset('logo/temp_logo.png') }}" id="logo-preview"
                                    class="w-full max-w-xs h-auto object-contain max-h-[12rem]" alt="Default Logo">
                            @endif

                        </div>

                        <p>Supported formats(JPG, PNG, GIF, < 2MB )</p>
                                <!-- Hidden File Input -->
                                <input type="file" wire:model="logo" accept="image/*" class="hidden" id="logoInput"
                                    x-on:livewire-upload-cancel="logo = prevLogo" />

                                @if ($logo && !is_string($logo) && $logo->temporaryUrl())
                                    <div class="flex gap-4">
                                        <!-- Button to Trigger File Input -->
                                        <button type="submit" class="ti-btn ti-btn-primary bg-primary text-white">
                                            <span wire:loading wire:target="logo">Saving...</span>
                                            <span wire:loading.remove wire:target="logo">Save</span>
                                        </button>
                                        <button type="button" class="ti-btn ti-btn-danger bg-primary text-white"
                                            wire:click="$cancelUpload('logo')">
                                            Cancel
                                        </button>
                                        <div>
                                        @else
                                            <!-- Button to Trigger File Input -->
                                            <button type="button"
                                                onclick="document.getElementById('logoInput').click()"
                                                class="ti-btn ti-btn-primary bg-primary text-white">
                                                <span wire:loading wire:target="logo">Uploading...</span>
                                                <span wire:loading.remove wire:target="logo">Change Logo</span>
                                            </button>
                                @endif




                                {{-- <div class="grid grid-cols-12 gap-4 mt-4">
                                    <div class="xl:col-span-12 col-span-12 grid mt-2">
                                        <button type="submit"
                                            class="ti-btn ti-btn-primary !bg-primary btn-wave !text-white !font-medium"
                                            wire:loading.attr="disabled">
                                            <span wire:loading.remove>Update</span>
                                            <span wire:loading>Updating...</span>
                                        </button>
                                    </div>
                                </div> --}}
                    </div>
                </form>
            </div>
        </div>
        <div class="box">
            <div class="box-body !p-0">
                <div class="text-sm md:text-base font-semibold box-header bg-primary text-center text-white">
                    Favicon Settings
                </div>
                <form wire:submit="updateFavicon" class="grid grid-cols-1 gap-4 m-4">
                    <div>

                        <div class="mb-4 m-4 flex justify-center">
                            <img src="{{ $favicon ? asset('storage/' . $favicon) : asset('logo/temp_logo.png') }}"
                                id="favicon-preview" class="w-full max-w-xs h-auto object-contain"
                                alt="Company favicon">
                        </div>

                        <p>Supported formats(JPG, PNG, GIF, 200x200, < 1MB )</p>
                                <!-- Hidden File Input -->
                                <input type="file" wire:model="favicon" wire:change="updateFavicon" accept="image/*"
                                    class="hidden" id="faviconInput" />

                                <!-- Button to Trigger File Input -->
                                <button type="button" onclick="document.getElementById('faviconInput').click()"
                                    class="ti-btn ti-btn-primary bg-primary text-white">
                                    Update favicon
                                </button>

                                <!-- Upload Status -->
                                <span wire:loading wire:target="favicon">Uploading...</span>


                                {{-- <div class="grid grid-cols-12 gap-4 mt-4">
                                    <div class="xl:col-span-12 col-span-12 grid mt-2">
                                        <button type="submit"
                                            class="ti-btn ti-btn-primary !bg-primary btn-wave !text-white !font-medium"
                                            wire:loading.attr="disabled">
                                            <span wire:loading.remove>Update</span>
                                            <span wire:loading>Updating...</span>
                                        </button>
                                    </div>
                                </div> --}}
                    </div>
                </form>
            </div>
        </div>





    </div>
    <div class="xxl:col-span-8 xl:col-span-12 col-span-12">
        <div class="grid grid-cols-12 gap-x-6">
            <div class="xl:col-span-12 col-span-12">
                <div class="box">
                    <div class="box-body !p-0">
                        <div class="text-sm md:text-base font-semibold box-header bg-primary text-center text-white">
                            General Settings
                        </div>
                        <form wire:submit="updateAccountInformation" class="grid grid-cols-1 gap-4 m-4">
                            @if (session()->has('settingError'))
                                <div x-data="{ show: true }" x-show="show"
                                    x-on:open-pppoe-error-message.window="show = true" x-init="setTimeout(() => show = false, 50000)"
                                    x-transition:leave="transition ease-in duration-300"
                                    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                                    class="alert alert-outline-danger alert-dismissible fade show flex" role="alert"
                                    id="pppoe-error">
                                    <div class="sm:flex-shrink-0">
                                        {{ session('settingError') }}
                                    </div>
                                    <div class="ms-auto">
                                        <div class="mx-1 my-1">
                                            <button type="button" x-on:click="show = false"
                                                class="inline-flex  rounded-sm  focus:outline-none focus:ring-0 focus:ring-offset-0 "
                                                data-hs-remove-element="#pppoe-error">
                                                <span class="sr-only">Dismiss</span>
                                                <svg class="h-3 w-3" width="16" height="16"
                                                    viewBox="0 0 16 16" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                    <path
                                                        d="M0.92524 0.687069C1.126 0.486219 1.39823 0.373377 1.68209 0.373377C1.96597 0.373377 2.2382 0.486219 2.43894 0.687069L8.10514 6.35813L13.7714 0.687069C13.8701 0.584748 13.9882 0.503105 14.1188 0.446962C14.2494 0.39082 14.3899 0.361248 14.5321 0.360026C14.6742 0.358783 14.8151 0.38589 14.9468 0.439762C15.0782 0.493633 15.1977 0.573197 15.2983 0.673783C15.3987 0.774389 15.4784 0.894026 15.5321 1.02568C15.5859 1.15736 15.6131 1.29845 15.6118 1.44071C15.6105 1.58297 15.5809 1.72357 15.5248 1.85428C15.4688 1.98499 15.3872 2.10324 15.2851 2.20206L9.61883 7.87312L15.2851 13.5441C15.4801 13.7462 15.588 14.0168 15.5854 14.2977C15.5831 14.5787 15.4705 14.8474 15.272 15.046C15.0735 15.2449 14.805 15.3574 14.5244 15.3599C14.2437 15.3623 13.9733 15.2543 13.7714 15.0591L8.10514 9.38812L2.43894 15.0591C2.23704 15.2543 1.96663 15.3623 1.68594 15.3599C1.40526 15.3574 1.13677 15.2449 0.938279 15.046C0.739807 14.8474 0.627232 14.5787 0.624791 14.2977C0.62235 14.0168 0.730236 13.7462 0.92524 13.5441L6.59144 7.87312L0.92524 2.20206C0.724562 2.00115 0.611816 1.72867 0.611816 1.44457C0.611816 1.16047 0.724562 0.887983 0.92524 0.687069Z"
                                                        fill="currentColor" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @elseif (session()->has('settingSuccess'))
                                <div x-data="{ show: true }" x-show="show"
                                    x-on:open-pppoe-success-message.window="show = true" x-init="setTimeout(() => show = false, 5000)"
                                    class="alert alert-success" x-transition:leave="transition ease-in duration-300"
                                    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                                    {{ session('settingSuccess') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif
                            <div>

                                <div class="grid grid-cols-12 gap-4">
                                    <div class="col-span-12">
                                        <label for="companyName" class="form-label">Company Name</label>
                                        <input wire:model.live="name" type="text" class="form-control"
                                            placeholder="Enter company name" aria-label="Company Name"
                                            id="companyName">
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-span-12">
                                        <label for="companyEmail" class="form-label">Company Email</label>
                                        <input wire:model="email" type="email" class="form-control"
                                            placeholder="Enter company email" aria-label="Company Email"
                                            id="companyEmail">
                                        @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-span-12">
                                        <label for="companyPhone" class="form-label">Company Phone</label>
                                        <input wire:model="phone" type="tel" class="form-control"
                                            placeholder="Enter company phone number" aria-label="Company Phone"
                                            id="companyPhone">
                                        @error('phone')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-span-12">
                                        <label for="companyUrl" class="form-label">Company URL</label>
                                        <input wire:model="adminUrl" type="url" class="form-control"
                                            placeholder="Enter company website URL" aria-label="Company URL"
                                            id="companyUrl" disabled>
                                    </div>
                                    <div class="col-span-12">
                                        <label for="companyUrl" class="form-label">User URL</label>
                                        <input wire:model="userUrl" type="url" class="form-control"
                                            placeholder="Enter company website URL" aria-label="Company URL"
                                            id="companyUrl" disabled>
                                    </div>
                                    <div class="col-span-12">
                                        <label for="companyUrl" class="form-label">Hotspot Title</label>
                                        <input wire:model="hotspotTitle" type="text" class="form-control"
                                            placeholder="Enter company website URL" aria-label="Company URL"
                                            id="companyUrl">
                                        @error('hotspotTitle')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="xl:col-span-12 col-span-12 grid mt-2">
                                        <button type="submit"
                                            class="ti-btn ti-btn-primary !bg-primary btn-wave !text-white !font-medium"
                                            wire:loading.attr="disabled">
                                            <span wire:loading.remove>Update</span>
                                            <span wire:loading>Updating...</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
