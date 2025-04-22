<div class="grid grid-cols-12 gap-6">
    <div class="xl:col-span-12 col-span-12">
        <div class="box">
            <div class="box-header justify-between">
                <div class="box-title">
                    Add Mikrotik
                </div>
                <button wire:click="openSetupPublicIpModal()" class="ti-btn btn-wave ti-btn-primary-full w-auto">Don't
                    have a public IP?</button>
            </div>
            <div class="box-body">
                <form wire:submit="submitForm" class="space-y-4 mt-0">
                    <div class="grid grid-cols-12 gap-4">
                        <div class="md:col-span-6 col-span-12">
                            <label class="form-label">Ip Address</label>
                            <input wire:model="form.ip" type="text" class="form-control" placeholder="Ip address"
                                aria-label="Ip Address">
                            @error('form.ip')
                                <div class="text-red-500 text-xs">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="md:col-span-6 col-span-12">
                            <label class="form-label">Username</label>
                            <input wire:model="form.user" type="text" class="form-control" placeholder="ISPKenya"
                                aria-label="First name">
                            @error('form.user')
                                <div class="text-red-500 text-xs">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="md:col-span-6 col-span-12">
                            <label class="form-label">Password</label>
                            <input wire:model="form.password" type="text" class="form-control"
                                placeholder="xxxxxxxxxxxxxxx" aria-label="First name">
                            @error('form.password')
                                <div class="text-red-500 text-xs">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="md:col-span-6 col-span-12">
                            <label class="form-label">Api Port</label>
                            <input wire:model="form.port" type="text" class="form-control" placeholder="1163"
                                aria-label="Api port">
                            @error('form.port')
                                <div class="text-red-500 text-xs">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="text-sm md:text-base font-semibold box-header">Site Information</div>
                    <div class="grid grid-cols-12 gap-4">
                        <div class="md:col-span-6 col-span-12">
                            <label class="form-label">Mikrotik Name</label>
                            <input wire:model="form.name" type="text" class="form-control"
                                placeholder="xxxxxxxxxxxxxxx" aria-label="First name">
                            @error('form.name')
                                <div class="text-red-500 text-xs">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="md:col-span-6 col-span-12">
                            <label class="form-label">Location</label>
                            <input wire:model="form.location" type="text" class="form-control" placeholder="1163"
                                aria-label="Api port">
                            @error('form.location')
                                <div class="text-red-500 text-xs">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="">
                        <button wire:loading.attr="disabled" wire:loading.class="opacity-50 cursor-not-allowed"
                            wire:target="submitForm" type="submit" class="ti-btn btn-wave ti-btn-primary-full w-full">
                            <span wire:loading.remove wire:target="submitForm">Add Mikrotik</span>
                            <span wire:loading wire:target="submitForm">Adding Mikrotik...</span>

                        </button>
                    </div>
                </form>
                <x-modal maxWidth="xl">
                    @slot('slot')
                        <livewire:admins.mikrotiks.modals.setup-public-ip lazy />
                    @endslot
                </x-modal>
            </div>
        </div>
    </div>
</div>
