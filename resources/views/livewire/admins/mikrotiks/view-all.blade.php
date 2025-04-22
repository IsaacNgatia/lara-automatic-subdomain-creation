<div class="grid grid-cols-12 gap-6">
    <div class="col-span-12">
        <div class="box custom-box">
            <div class="box-header justify-between">
                <div class="box-title">
                    Mikrotiks Table
                </div>

            </div>
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
                            <input wire:model.live.debounce.300ms="query" type="text" id="hs-search-box-with-loading-1"
                                name="hs-search-box-with-loading-1" class="ti-form-input rounded-sm ps-11 focus:z-10"
                                placeholder="Input search">
                            <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-4">
                                <div wire:loading
                                    class="animate-spin inline-block w-4 h-4 border-[3px] border-current border-t-transparent text-primary rounded-full"
                                    role="status" aria-label="loading">
                                    <span class="sr-only">Loading...</span>
                                </div>
                                <svg wire:loading.remove class="h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
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
                                <th scope="col" class="text-start">Mikrotik Name</th>
                                <th scope="col" class="text-start">Mikrotik Ip</th>
                                <th scope="col" class="text-start">Location</th>
                                <th scope="col" class="text-start">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($mikrotiks as $mikrotik)
                                <tr wire:key="{{ $mikrotik->id }}" class="border-b border-defaultborder">
                                    <td>{{ $id++ }}</td>
                                    <td>{{ $mikrotik->name }}</td>
                                    <td>{{ $mikrotik->ip }}</td>
                                    <td>{{ $mikrotik->location }}</td>
                                    <td>
                                        <div class="hstack flex-wrap">
                                            <div class="hs-tooltip ti-main-tooltip [--placement:top] w-auto">
                                                <button type="button"
                                                    class="hs-tooltip-toggle me-4 text-primary text-[.875rem] leading-none">
                                                    <i class="ri-user-add-line"></i>
                                                    <span
                                                        class="hs-tooltip-content ti-main-tooltip-content !py-1 !px-2 !bg-primary !text-xs !font-medium !text-white shadow-sm dark:bg-slate-700"
                                                        role="tooltip">
                                                        Add Users
                                                    </span>
                                                </button>
                                            </div>
                                            <div wire:click="editMikrotik({{ $mikrotik->id }})"
                                                class="hs-tooltip ti-main-tooltip [--placement:top]">
                                                <button type="button"
                                                    class="hs-tooltip-toggle me-4 text-info text-[.875rem] leading-none">
                                                    <i class="ri-edit-line"></i>
                                                    <span
                                                        class="hs-tooltip-content ti-main-tooltip-content !py-1 !px-2 !bg-info !text-xs !font-medium !text-white shadow-sm dark:bg-slate-700"
                                                        role="tooltip">
                                                        Edit Mikrotik
                                                    </span>
                                                </button>
                                            </div>
                                            <div class="hs-tooltip ti-main-tooltip [--placement:top]">
                                                <button type="button"
                                                    class="hs-tooltip-toggle me-4 text-success text-[.875rem] leading-none">
                                                    <i class="ri-send-plane-fill"></i>
                                                    <span
                                                        class="hs-tooltip-content ti-main-tooltip-content !py-1 !px-2 !bg-success !text-xs !font-medium !text-white shadow-sm dark:bg-slate-700"
                                                        role="tooltip">
                                                        Ping Mikrotik
                                                    </span>
                                                </button>
                                            </div>
                                            <div class="hs-tooltip ti-main-tooltip [--placement:top]">
                                                <button type="button" aria-label="anchor"
                                                    class="hs-tooltip-toggle me-4 text-secondary text-[.875rem] leading-none">
                                                    <i class="ri-download-line"></i>
                                                    <span
                                                        class="hs-tooltip-content ti-main-tooltip-content !py-1 !px-2 !bg-secondary !text-xs !font-medium !text-white shadow-sm dark:bg-slate-700"
                                                        role="tooltip">
                                                        Download Mikrotik Backup
                                                    </span>
                                                </button>
                                            </div>
                                            <div class="hs-tooltip ti-main-tooltip [--placement:top]">
                                                <button type="button" aria-label="anchor"
                                                    class="hs-tooltip-toggle me-4 text-danger text-[.875rem] leading-none">
                                                    <i class="ri-delete-bin-5-line"></i>
                                                    <span
                                                        class="hs-tooltip-content ti-main-tooltip-content !py-1 !px-2 !bg-danger !text-xs !font-medium !text-white shadow-sm dark:bg-slate-700"
                                                        role="tooltip">
                                                        Delete Mikrotik
                                                    </span>
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="py-4 px-3">
                    <div class="flex ">
                        <div class="flex space-x-4 items-center mb-3">
                            <label class="w-32 text-sm font-medium ">Per Page</label>
                            <select wire:model.live.debounce.200ms="perPage"
                                class="bg-gray-50 border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                @if ($totalMikrotiks > 10)
                                    <option value="10">10</option>
                                @endif

                                @if ($totalMikrotiks > 20)
                                    <option value="20">20</option>
                                @endif

                                @if ($totalMikrotiks > 50)
                                    <option value="50">50</option>
                                @endif

                                @if ($totalMikrotiks > 100)
                                    <option value="100">100</option>
                                @endif

                                <option value="{{ $totalMikrotiks }}">
                                    {{ $totalMikrotiks <= 100 ? 'Show All' : '100+' }}
                                </option>
                            </select>

                        </div>
                    </div>
                    {{ $mikrotiks->links() }}
                </div>

            </div>

            <x-modal maxWidth="xl">
                @slot('slot')
                    @if ($selectedId)
                        <livewire:admins.mikrotiks.modals.update-mikrotik :id="$selectedId" lazy />
                    @endif
                @endslot
            </x-modal>

        </div>
    </div>
</div>
