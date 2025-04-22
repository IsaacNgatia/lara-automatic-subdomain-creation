<div class="box-body space-y-3">
    <div class="flex justify-between">
        <div class="download-data">
            <button type="button" class="ti-btn btn-wave ti-btn-primary" id="download-csv">Download
                CSV</button>
            <button type="button" class="ti-btn btn-wave ti-btn-primary" id="download-json">Download
                JSON</button>
            <button type="button" class="ti-btn btn-wave ti-btn-primary" id="download-xlsx">Download
                XLSX</button>
            <button type="button" class="ti-btn btn-wave ti-btn-primary" id="download-pdf">Download
                PDF</button>
            <button type="button" class="ti-btn btn-wave ti-btn-primary" id="download-html">Download
                HTML</button>
        </div>
        <div>
            <div class="relative">
                <input wire:model.live.debounce.300ms="search" type="text" id="hs-search-box-with-loading-1"
                    name="hs-search-box-with-loading-1" class="ti-form-input rounded-sm ps-11 focus:z-10"
                    placeholder="Input search">
                <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-4">
                    <div wire:loading
                        class="animate-spin inline-block w-4 h-4 border-[3px] border-current border-t-transparent text-primary rounded-full"
                        role="status" aria-label="loading">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <svg wire:loading.remove class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" width="16"
                        height="16" fill="currentColor" viewBox="0 0 16 16">
                        <path
                            d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table whitespace-nowrap table-bordered min-w-full">
            <thead>
                <tr class="border-b border-defaultborder">
                    <th scope="col" class="text-start">Id</th>
                    <th scope="col" class="text-start">Official Name</th>
                    <th scope="col" class="text-start">Username</th>
                    <th scope="col" class="text-start">Reference Number</th>
                    <th scope="col" class="text-start">Mikrotik Name</th>
                    <th scope="col" class="text-start">Rate Limit</th>
                    <th scope="col" class="text-start">Ip</th>
                    <th scope="col" class="text-start">Phone</th>
                    <th scope="col" class="text-start">Bill</th>
                    <th scope="col" class="text-start">Billing Cycle</th>
                    <th scope="col" class="text-start">Status</th>
                    <th scope="col" class="text-start">Expiry Date</th>
                    <th scope="col" class="text-start">Action</th>
                </tr>
            </thead>
            <tbody>
                @if ($staticUsers->isEmpty())
                    <tr class="border-b border-defaultborder">
                        <td colspan="13" class="text-center py-4">
                            <p>No Static users found.</p>
                        </td>
                    </tr>
                @else
                    @foreach ($staticUsers as $staticUser)
                        <tr wire:key="{{ $staticUser->id }}" class="border-b border-defaultborder">
                            <td>{{ $loop->iteration + ($staticUsers->currentPage() - 1) * $staticUsers->perPage() }}
                            </td>
                            <th scope="row">
                                <a href="{{ route('customer.view.one', $staticUser->id) }}"
                                    class="inline-flex items-center text-secondary hover:text-secondary/15 dark:text-secondary/90 dark:hover:text-secondary/50 hover:underline transition-colors duration-200">
                                    <div class="flex items-center">
                                        <span class="avatar avatar-xs me-2 online avatar-rounded">
                                            <img src="{{ asset('build/assets/images/faces/13.jpg') }}" alt="img">
                                        </span>
                                        <span>{{ $staticUser->official_name }}</span>
                                    </div>
                                </a>
                            </th>
                            <td>{{ $staticUser->mikrotik_name }}</td>
                            <td>{{ $staticUser->reference_number }}</td>
                            <td>{{ $staticUser->mikrotik_identity }}</td>
                            <td>{{ $staticUser->max_download_speed }}</td>
                            <td>{{ $staticUser->target_address }}</td>
                            <td>{{ $staticUser->phone_number }}</td>
                            <td>{{ $staticUser->billing_amount }}</td>
                            <td>{{ $staticUser->billing_cycle }}</td>
                            <td>
                                @if ($staticUser->status == 'active')
                                    <span class="badge bg-success/10 text-success">Active</span>
                                @elseif ($staticUser->status == 'suspended')
                                    <span class="badge bg-light text-dark">Suspended</span>
                                @elseif ($staticUser->status == 'inactive')
                                    <span class="badge bg-danger text-dark">Inactive</span>
                                @endif
                            </td>
                            <td>{{ $staticUser->expiry_date }}</td>
                            <td>
                                <div class="hstack gap-2 flex-wrap">
                                    <div wire:click="editStaticUser({{ $staticUser->id }})"
                                        class="hs-tooltip ti-main-tooltip [--placement:top]">
                                        <button type="button"
                                            class="hs-tooltip-toggle me-4 text-info text-[.875rem] leading-none">
                                            <i class="ri-edit-line"></i>
                                            <span
                                                class="hs-tooltip-content ti-main-tooltip-content !py-1 !px-2 !bg-info !text-xs !font-medium !text-white shadow-sm dark:bg-slate-700"
                                                role="tooltip">
                                                Edit Static User
                                            </span>
                                        </button>
                                    </div>
                                    <div wire:click="warn({{ $staticUser->id }})"
                                        class="hs-tooltip ti-main-tooltip [--placement:top]">
                                        <button type="button" aria-label="anchor"
                                            class="hs-tooltip-toggle me-4 text-danger text-[.875rem] leading-none">
                                            <i class="ri-delete-bin-5-line"></i>
                                            <span
                                                class="hs-tooltip-content ti-main-tooltip-content !py-1 !px-2 !bg-danger !text-xs !font-medium !text-white shadow-sm dark:bg-slate-700"
                                                role="tooltip">
                                                Delete Static User
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
    <div class="py-4 px-3">
        <div class="flex ">
            <div class="flex space-x-4 items-center mb-3">
                <label class="w-32 text-sm font-medium ">Per Page</label>
                <select wire:model.live.debounce.200ms="perPage"
                    class="bg-gray-50 border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    @if ($totalStaticUsers > 10)
                        <option value="10">10</option>
                    @endif

                    @if ($totalStaticUsers > 20)
                        <option value="20">20</option>
                    @endif

                    @if ($totalStaticUsers > 50)
                        <option value="50">50</option>
                    @endif

                    @if ($totalStaticUsers > 100)
                        <option value="100">100</option>
                    @endif

                    <option value="{{ $totalStaticUsers }}">
                        {{ $totalStaticUsers <= 100 ? 'Show All' : '100+' }}
                    </option>
                </select>
            </div>
        </div>
        {{ $staticUsers->links() }}
    </div>
    <x-modal maxWidth="4xl" preventModalClose=true>
        @slot('slot')
            @if ($updatingId)
                <livewire:admins.isp.modals.edit-static-user :id="$updatingId" lazy />
            @elseif ($deletingId)
                <livewire:admins.components.modals.delete-item :title="'Delete Static User'" :message="'Are you sure you want to delete Static User id ' . $deletingId" :eventToBeDispatched="'delete-static-user'"
                    :cancelEvent="'cancel-delete-static-user'" :list="['Wallet Transactions', 'Service Plans', 'Tickets']" lazy />
            @endif
        @endslot
    </x-modal>
</div>
