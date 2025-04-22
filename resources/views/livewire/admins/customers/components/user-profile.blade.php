<div class="box-body !p-0">
    <div class="sm:flex items-start p-6 main-profile-cover">
        <div>
            <span
                class="avatar avatar-xxl avatar-rounded bg-light {{ ($customer->connection_type === 'pppoe' && (isset($mikrotikInfo['mac-address']) || isset($mikrotikInfo['ip-address']) || isset($mikrotikInfo['uptime']))) || ($customer->connection_type === 'static' && (isset($mikrotikInfo['max-limit']) && $mikrotikInfo['max-limit'] != '1k/1k')) ? 'online' : 'offline' }} me-4">
                @if ($customer->profile_photo_path)
                    <img src="{{ asset('build/assets/images/faces/9.jpg') }}" alt="">
                @else
                    {{ $this->getInitials($customer->official_name) }}
                @endif
            </span>
        </div>
        <div class="flex-grow main-profile-info">
            <div class="flex items-center !justify-between">
                <h6 class="font-semibold mb-1 text-white text-[1rem]">{{ $customer->official_name }}</h6>

                <span
                    class="bg-light text-dark py-1.5 px-3 rounded-sm text-lg font-medium uppercase">{{ $customer->connection_type }}</span>
            </div>
            <p class="mb-1 !text-white"><span class="opacity-[0.7]">Mikrotik Name: </span><span
                    class="font-semibold mb-1 text-white text-[1rem]">{{ $user->mikrotik_name }}</span></p>
            <p class="mb-1 !text-white"><span class="opacity-[0.7]">Balance: </span><span
                    class="font-semibold mb-1 text-white text-[1rem]">{{ current_currency() }}
                    {{ $customer->balance }}</span></p>
            <div class="flex justify-between items-center">
                <div class="flex mb-0">
                    <div class="me-6">
                        <p class="font-bold text-[1.25rem] text-white text-shadow mb-0">
                            {{ $this->formatToK($transactionsCount) }}</p>
                        <p class="mb-0 text-[.6875rem] opacity-[0.5] text-white">Payment</p>
                    </div>
                    <div class="me-6">
                        <p class="font-bold text-[1.25rem] text-white text-shadow mb-0">{{ $smsCount }}</p>
                        <p class="mb-0 text-[.6875rem] opacity-[0.5] text-white">SMS</p>
                    </div>
                    <div class="me-6">
                        <p class="font-bold text-[1.25rem] text-white text-shadow mb-0">0</p>
                        <p class="mb-0 text-[.6875rem] opacity-[0.5] text-white">Tickets</p>
                    </div>
                </div>
                @if ($customer->status == 'active')
                    <button type="button" wire:click="downCustomer({{ $customer->id }})"
                        wire:confirm="Are you sure you want to disconnect this user?"
                        class="ti-btn ti-btn-danger-full btn-wave"><span wire:loading wire:target="downCustomer"
                            class="me-2">Disconnecting
                        </span>
                        <span wire:loading wire:target="downCustomer" class="loading"><i
                                class="ri-loader-2-fill text-[1rem] animate-spin"></i></span>
                        <span wire:loading.class="hidden" wire:target="downCustomer" class="me-2">Disconnect
                        </span></button>
                @else
                    <button type="button" wire:click="raiseCustomer({{ $customer->id }})"
                        wire:confirm="Are you sure you want to enable this user?"
                        class="ti-btn ti-btn-success-full btn-wave"><span wire:loading wire:target="raiseCustomer"
                            class="me-2">Connecting
                        </span>
                        <span wire:loading wire:target="raiseCustomer" class="loading"><i
                                class="ri-loader-2-fill text-[1rem] animate-spin"></i></span>
                        <span wire:loading.class="hidden" wire:target="raiseCustomer" class="me-2">Connect
                        </span></button>
                @endif

            </div>
        </div>
    </div>
    <div class="p-6 border-b border-dashed dark:border-defaultborder/10">
        <p class="text-[.9375rem] mb-2 me-6 font-semibold">Account Information :</p>
        <div class="text-[#8c9097] dark:text-white/50">
            <p class="mb-2">
                <span class="font-bold">Status:</span>
                <span
                    class="py-0.5 px-2 rounded-md {{ $customer->status == 'active' ? 'bg-success' : 'bg-danger' }} text-white ml-2">{{ $customer->status }}</span>
            </p>
            <div class="mb-0 flex flex-col md:flex-row justify-between">
                <p class="">
                    <span class="font-bold">Login Username:</span>
                    {{ $customer->username }}
                </p>
                <button type="button" class="ti-btn btn-wave !py-1 !px-2 !text-[0.75rem] ti-btn-danger">Reset
                    Password</button>
            </div>
        </div>
    </div>
    <div class="p-6 border-b border-dashed dark:border-defaultborder/10">
        <div class="flex justify-between items-center">
            <p class="text-[.9375rem] mb-2 me-6 font-semibold">Mikrotik Information :</p>

        </div>
        <div>
            <p class="mb-2 text-[#8c9097] dark:text-white/50">
                <span class="font-bold">Mikrotik Name:</span>
                <span class=""> {{ $user->mikrotik_name }}</span>
            </p>
            @if ($customer->connection_type == 'pppoe')
                <p class="mb-2 text-[#8c9097] dark:text-white/50">
                    <span class="font-bold">Password:</span><span class="">
                        {{ $user->password ?? 'N/A' }}</span>
                </p>
                <p class="mb-2 text-[#8c9097] dark:text-white/50">
                    <span class="font-bold">Remote Address:</span>
                    <span class="">{{ $user->remote_address ?? 'N/A' }}</span>
                </p>
                <p class="mb-2 text-[#8c9097] dark:text-white/50">
                    <span class="font-bold">Profile:</span><span class="">
                        {{ $user->profile ?? 'N/A' }}</span>
                </p>
            @elseif ($customer->connection_type == 'static')
                <p class="mb-2 text-[#8c9097] dark:text-white/50">
                    <span class="font-bold">Target Address:</span><span class="">
                        {{ $user->target_address ?? 'N/A' }}</span>
                </p>
                <p class="mb-2 text-[#8c9097] dark:text-white/50">
                    <span class="font-bold">Speed Limit:</span><span class="">
                        {{ $user->max_download_speed }}</span>
                </p>
            @endif
            <p class="mb-0 text-[#8c9097] dark:text-white/50">
                <span class="font-bold">Mikrotik:</span><span class="">
                    {{ $mikrotikName }}</span>
            </p>
        </div>
    </div>
    <div class="p-6 border-b border-dashed dark:border-defaultborder/10">
        <p class="text-[.9375rem] mb-2 me-6 font-semibold">Billing Information :</p>
        <div>
            <p class="mb-2 text-[#8c9097] dark:text-white/50">
                <span class="font-bold">Billing Amount:</span>
                <span class="text-[.9375rem] font-semibold"> {{ $customer->billing_amount }}</span>
            </p>
            <p class="mb-2 text-[#8c9097] dark:text-white/50">
                <span class="font-bold">Billing Cycle:</span><span class="">
                    {{ $customer->billing_cycle }}</span>
            </p>
            <p class="mb-0 text-[#8c9097] dark:text-white/50">
                <span class="font-bold">Account Name:</span>
                <span class="text-[.9375rem] font-semibold">{{ $customer->reference_number }}</span>
            </p>
        </div>
    </div>
    <div class="p-6 border-b border-dashed dark:border-defaultborder/10">
        <p class="text-[.9375rem] mb-2 me-6 font-semibold">Contact Information :</p>
        <div class="text-[#8c9097] dark:text-white/50">
            <p class="mb-2">
                <span class="avatar avatar-sm avatar-rounded me-2 bg-light text-[#8c9097] dark:text-white/50">
                    <i class="ri-mail-line align-middle text-[.875rem] text-[#8c9097] dark:text-white/50"></i>
                </span>
                {{ $customer->email ?? 'N/A' }}
            </p>
            <p class="mb-2">
                <span class="avatar avatar-sm avatar-rounded me-2 bg-light text-[#8c9097] dark:text-white/50">
                    <i class="ri-phone-line align-middle text-[.875rem] text-[#8c9097] dark:text-white/50"></i>
                </span>
                {{-- +(254) 712-345-678 --}}
                {{ $this->formatPhoneNumber($customer->phone_number) }}
            </p>
            <p class="mb-0">
                <span class="avatar avatar-sm avatar-rounded me-2 bg-light text-[#8c9097] dark:text-white/50">
                    <i class="ri-map-pin-line align-middle text-[.875rem] text-[#8c9097] dark:text-white/50"></i>
                </span>
                {{ $customer->location ?? 'N/A' }}
            </p>
        </div>
    </div>
    <div class="flex justify-between items-center pr-4 border-b border-dashed">
        <div class="p-6 sm:flex items-center gap-2">
            <p class="text-[.9375rem] font-semibold">Expiry Date :</p>
            <p>{{ $customer->expiry_date }}</p>
        </div>
        <button type="button" class="ti-btn btn-wave !py-1 !px-2 !text-[0.75rem] ti-btn-secondary">Edit</button>
    </div>
    <div x-data="{ routerIsOnline: @js($routerIsOnline) }" x-init="$nextTick(() => { $dispatch('check-router-is-online'); if (!routerIsOnline) { setTimeout(() => { $dispatch('check-router-is-online') }, 5000) } })"
        class="p-6 border-b border-dashed dark:border-defaultborder/10 {{ $routerIsOnline ? (($customer->connection_type === 'pppoe' && (isset($mikrotikInfo['mac-address']) || isset($mikrotikInfo['ip-address']) || isset($mikrotikInfo['uptime']))) || ($customer->connection_type === 'static' && (isset($mikrotikInfo['max-limit']) && $mikrotikInfo['max-limit'] != '1k/1k')) ? 'bg-success text-white' : 'bg-danger') : '' }}">
        <p class="text-[1.2rem] mb-2 me-6 font-semibold text-center">Live Information
        </p>

        <div class="grid grid-cols-2 gap-5">
            @if ($customer->connection_type === 'pppoe')
                <div class="mb-2 text-[#8c9097] dark:text-white text-center">
                    <p class="font-bold">Ip:</p>
                    <p class=""> {{ $routerIsOnline == true ? $mikrotikInfo['ip-address'] ?? 'N/A' : 'N/A' }}
                    </p>
                </div>
                <div class="mb-2 text-[#8c9097] dark:text-white text-center">
                    <p class="font-bold">MAC Address:</p>
                    <p class="">
                        {{ $routerIsOnline == true ? $mikrotikInfo['mac-address'] ?? 'N/A' : 'N/A' }}</p>
                </div>
                <div class="mb-2 text-[#8c9097] dark:text-white text-center">
                    <p class="font-bold">Uptime:</p>
                    <p class=""> {{ $routerIsOnline == true ? $mikrotikInfo['uptime'] ?? 'N/A' : 'N/A' }}</p>
                </div>
                <div class="mb-2 text-[#8c9097] dark:text-white text-center">
                    <p class="font-bold">Last Logged out:</p>
                    <p class="">
                        {{ $routerIsOnline == true ? $mikrotikInfo['last-logged-out'] ?? 'N/A' : 'N/A' }}</p>
                </div>
            @elseif($customer->connection_type === 'static')
                <div class="mb-2 text-[#8c9097] dark:text-white text-center">
                    <p class="font-bold">Target:</p>
                    <p class=""> {{ $routerIsOnline == true ? $mikrotikInfo['target'] ?? 'N/A' : 'N/A' }}
                    </p>
                </div>
                <div class="mb-2 text-[#8c9097] dark:text-white text-center">
                    <p class="font-bold">Max Limit:</p>
                    <p class="">
                        {{ $routerIsOnline == true ? $mikrotikInfo['max-limit'] ?? 'N/A' : 'N/A' }}</p>
                </div>
                <div class="mb-2 text-[#8c9097] dark:text-white text-center">
                    <p class="font-bold">Burst Limit:</p>
                    <p class=""> {{ $routerIsOnline == true ? $mikrotikInfo['burst-limit'] ?? 'N/A' : 'N/A' }}
                    </p>
                </div>
                <div class="mb-2 text-[#8c9097] dark:text-white text-center">
                    <p class="font-bold">Burst Time:</p>
                    <p class="">
                        {{ $routerIsOnline == true ? $mikrotikInfo['burst-time'] ?? 'N/A' : 'N/A' }}</p>
                </div>
            @endif
        </div>
    </div>
</div>
