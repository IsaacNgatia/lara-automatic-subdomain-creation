<div class="grid grid-cols-12 gap-6">
    <div class="xl:col-span-12 col-span-12">
        <div class="box">
            <div class="box-header justify-between">
                <div class="box-title">
                    Update Mikrotik
                </div>
                <button type="button"
                    class="!text-[1.5rem] !font-medium text-[#8c9097] dark:text-white/50 hover:text-defaulttextcolor"
                    data-hs-overlay="#closemodal">
                    <span class="sr-only">Close</span>
                    <i class="ri-close-line"></i>
                </button>
            </div>
            <div class="box-body">
                @if (session()->has('success'))
                    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="alert alert-success"
                        x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <form wire:submit="update" class="space-y-4 mt-0">
                    <div class="grid grid-cols-12 gap-4">
                        <div class="md:col-span-6 col-span-12">
                            <label class="form-label">Ip Address</label>
                            <input wire:model="ip" type="text" class="form-control" placeholder="Ip address"
                                aria-label="Ip Address">
                            @error('ip')
                                <div class="text-red-500 text-xs">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="md:col-span-6 col-span-12">
                            <label class="form-label">Username</label>
                            <input wire:model="user" type="text" class="form-control" placeholder="ISPKenya"
                                aria-label="Login Username">
                            @error('user')
                                <div class="text-red-500 text-xs">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="md:col-span-6 col-span-12">
                            <label class="form-label">Password</label>
                            <input wire:model="password" type="text" class="form-control"
                                placeholder="xxxxxxxxxxxxxxx" aria-label="User's Password">
                            @error('password')
                                <div class="text-red-500 text-xs">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="text-sm md:text-base font-semibold box-header">Site Information</div>
                    <div class="grid grid-cols-12 gap-4">
                        <div class="md:col-span-6 col-span-12">
                            <label class="form-label">Mikrotik Name</label>
                            <input wire:model="name" type="text" class="form-control" placeholder="Mikrotik 1"
                                aria-label="Mikrotik name">
                            @error('name')
                                <div class="text-red-500 text-xs">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="md:col-span-6 col-span-12">
                            <label class="form-label">Location</label>
                            <input wire:model="location" type="text" class="form-control" placeholder="1163"
                                aria-label="Nairobi">
                            @error('location')
                                <div class="text-red-500 text-xs">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="">
                        <button wire:loading.attr="disabled" wire:loading.class="opacity-50 cursor-not-allowed"
                            type="submit" class="ti-btn btn-wave ti-btn-primary-full w-full">
                            <span wire:loading.remove>Update Mikrotik</span>
                            <span wire:loading>Updating Mikrotik...</span>

                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
