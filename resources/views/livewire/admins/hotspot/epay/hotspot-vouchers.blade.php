<div class="box-body space-y-3">
    <div class="flex justify-between">
        <div class="download-data">
            <button type="button" class="ti-btn btn-wave ti-btn-primary" id="download-csv">
                CSV</button>
            <button type="button" class="ti-btn btn-wave ti-btn-primary" id="download-json">
                JSON</button>
            <button type="button" class="ti-btn btn-wave ti-btn-primary" id="download-xlsx">
                XLSX</button>
            <button type="button" class="ti-btn btn-wave ti-btn-primary" id="download-pdf">
                PDF</button>
            <button type="button" class="ti-btn btn-wave ti-btn-primary" id="download-html">
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
                    <th scope="col" class="text-start">Username</th>
                    <th scope="col" class="text-start">Password</th>
                    <th scope="col" class="text-start">Mikrotik Name</th>
                    <th scope="col" class="text-start">Data Limit</th>
                    <th scope="col" class="text-start">Time Limit</th>
                    <th scope="col" class="text-start">Expiry</th>
                    <th scope="col" class="text-start">Price</th>
                    <th scope="col" class="text-start">Status</th>
                    <th scope="col" class="text-start">Action</th>
                </tr>
            </thead>
            <tbody>
                @if ($epayPackages->isEmpty())
                    <tr class="border-b border-defaultborder">
                        <td colspan="13" class="text-center py-4">
                            <p>No Epay Packages found.</p>
                        </td>
                    </tr>
                @else
                    @foreach ($epayPackages as $epayVoucher)
                        <tr wire:key="{{ $epayVoucher->id }}" class="border-b border-defaultborder">
                            <td>{{ $loop->iteration + ($epayPackages->currentPage() - 1) * $epayPackages->perPage() }}
                            </td>
                            <td>{{ $epayVoucher->name }}</td>
                            <td>{{ $epayVoucher->password }}</td>
                            <td>{{ $epayVoucher->mikrotik_identity }}</td>
                            <td>{{ $epayVoucher->data_limit == null ? 'Unlimited' : $this->formatDataLimit($epayVoucher->data_limit) }}
                            </td>
                            <td>{{ $this->formatTimeLimit($epayVoucher->time_limit) }}</td>
                            <td>{{ $epayVoucher->expiry_date }}</td>
                            <td>{{ $epayVoucher->price }}</td>
                            <td>
                                @php
                                    // Get the current time in the APP_TIMEZONE
                                    $currentTime = now(config('app.timezone'));
                                    // Convert expiry_date to a Carbon instance
                                    $expiryDate = \Carbon\Carbon::parse(
                                        $epayVoucher->expiry_date,
                                        config('app.timezone'),
                                    );
                                    // Compare the dates
                                    $status = $currentTime->lt($expiryDate) ? 'Active' : 'Expired';
                                    // Define badge class based on status
                                    $badgeClass = $status === 'Active' ? 'badge bg-success' : 'badge bg-danger';
                                @endphp
                                <span class="{{ $badgeClass }}">{{ $status }}</span>
                            </td>
                            <td>
                                <div class="hstack gap-2 flex-wrap">

                                    <div wire:click="warnDeletionOfHspVoucher({{ $epayVoucher->id }})"
                                        class="hs-tooltip ti-main-tooltip [--placement:top]">
                                        <button type="button" aria-label="anchor"
                                            class="hs-tooltip-toggle me-4 text-danger text-[.875rem] leading-none">
                                            <i class="ri-delete-bin-5-line"></i>
                                            <span
                                                class="hs-tooltip-content ti-main-tooltip-content !py-1 !px-2 !bg-danger !text-xs !font-medium !text-white shadow-sm dark:bg-slate-700"
                                                role="tooltip">
                                                Delete Epay Package
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
                    @if ($totalEpayPackages > 10)
                        <option value="10">10</option>
                    @endif

                    @if ($totalEpayPackages > 20)
                        <option value="20">20</option>
                    @endif

                    @if ($totalEpayPackages > 50)
                        <option value="50">50</option>
                    @endif

                    @if ($totalEpayPackages > 100)
                        <option value="100">100</option>
                    @endif

                    <option value="{{ $totalEpayPackages }}">
                        {{ $totalEpayPackages <= 100 ? 'Show All' : '100+' }}
                    </option>
                </select>
            </div>
        </div>
        {{ $epayPackages->links() }}
    </div>
</div>
