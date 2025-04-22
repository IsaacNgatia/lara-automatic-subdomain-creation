<div class="grid grid-cols-12 gap-x-6">
    <div class="xxl:col-span-4 xl:col-span-12 col-span-12">
        @if (session()->has('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <div class="box">
            <div class="box-body !p-0">
                <form wire:submit="updateLogo" class="grid grid-cols-1 gap-4 m-4">
                    <div>
                        <div class="text-sm md:text-base font-semibold box-header bg-primary text-center text-white">
                            Logo Settings
                        </div>

                        <div class="mb-4 m-4 flex justify-center">
                            <img src="{{ $logo ? asset('/storage/' . $logo) : asset('logo/temp_logo.png') }}"
                                id="logo-preview" class="w-full max-w-xs h-auto object-contain" alt="Company Logo">
                        </div>

                        <p>Supported formats(JPG, PNG, GIF, < 2MB )</p>
                                <!-- Hidden File Input -->
                                <input type="file" wire:model="logo" wire:change="updateLogo" accept="image/*"
                                    class="hidden" id="logoInput" />

                                <!-- Button to Trigger File Input -->
                                <button type="button" onclick="document.getElementById('logoInput').click()"
                                    class="ti-btn ti-btn-primary bg-primary text-white">
                                    Update Logo
                                </button>

                                <!-- Upload Status -->
                                <span wire:loading wire:target="logo">Uploading...</span>


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
                <form wire:submit="updateFavicon" class="grid grid-cols-1 gap-4 m-4">
                    <div>
                        <div class="text-sm md:text-base font-semibold box-header bg-primary text-center text-white">
                            Favicon Settings
                        </div>

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
                        <form wire:submit="updateAccountInformation" class="grid grid-cols-1 gap-4 m-4">
                            <div>
                                <div
                                    class="text-sm md:text-base font-semibold box-header bg-primary text-center text-white">
                                    General Settings
                                </div>
                                <div class="grid grid-cols-12 gap-4 mt-4">
                                    <div class="col-span-12">
                                        <label for="companyName" class="form-label">Company Name</label>
                                        <input wire:model.live="name" type="text" class="form-control"
                                            placeholder="Enter company name" aria-label="Company Name" id="companyName">
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
                                        <label for="companyUrl" class="form-label">Company URL</label>
                                        <input wire:model="url" type="url" class="form-control"
                                            placeholder="Enter company website URL" aria-label="Company URL"
                                            id="companyUrl">
                                        @error('url')
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
                                        <label for="companyAddress" class="form-label">Company Address</label>
                                        <input wire:model="address" type="text" class="form-control"
                                            placeholder="Enter company address" aria-label="Company Address"
                                            id="companyAddress">
                                        @error('address')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-span-12">
                                        <label for="userPanelUrl" class="form-label">User Panel URL</label>
                                        <input wire:model="user_url" type="url" class="form-control"
                                            placeholder="Enter user panel URL" aria-label="User Panel URL"
                                            id="userPanelUrl">
                                        @error('user_url')
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
