<div class="box">
    <div class="box-header justify-between">
        <div class="box-title">
            Related Accounts
        </div>

    </div>
    <div class="box-body overflow-hidden">
        <div class="flex flex-col-reverse md:flex-row gap-2 md:gap-0 justify-between">
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
                    <input type="text" id="hs-search-box-with-loading-1" name="hs-search-box-with-loading-1"
                        class="ti-form-input rounded-sm ps-11 focus:z-10" placeholder="Input search">
                    <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-4">
                        <div wire:loading
                            class="animate-spin inline-block w-4 h-4 border-[3px] border-current border-t-transparent text-primary rounded-full"
                            role="status" aria-label="loading">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table whitespace-nowrap ti-striped-table min-w-full">
                <thead>
                    <tr class="border-b border-defaultborder">
                        <th scope="col" class="text-start">Id</th>
                        <th scope="col" class="text-start">Official Name</th>
                        <th scope="col" class="text-start">Username</th>
                        <th scope="col" class="text-start">Reference Number</th>
                        <th scope="col" class="text-start">User Type</th>
                        <th scope="col" class="text-start">Mikrotik Name</th>
                        <th scope="col" class="text-start">Phone</th>
                        <th scope="col" class="text-start">Bill</th>
                        <th scope="col" class="text-start">Billing Cycle</th>
                        <th scope="col" class="text-start">Status</th>
                        <th scope="col" class="text-start">Expiry Date</th>
                        <th scope="col" class="text-start">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($childAccounts as $customer)
                        <tr wire:key="{{ $customer->id }}" class="border-b border-defaultborder">
                            <td>{{ $loop->iteration }}</td>
                            <th scope="row">
                                <a href="{{ route('customer.view.one', $customer->id) }}"
                                    class="inline-flex items-center text-secondary hover:text-secondary/15 dark:text-secondary/90 dark:hover:text-secondary/50 hover:underline transition-colors duration-200">
                                    {{ $customer->official_name }}
                                </a>
                            </th>
                            <td>{{ $customer->mikrotik_name }}</td>
                            <td>{{ $customer->reference_number }}</td>
                            <td>{{ $customer->connection_type }}</td>
                            <td>{{ $customer->mikrotik_identity }}</td>
                            <td>{{ $customer->phone_number }}</td>
                            <td>{{ $customer->billing_amount }}</td>
                            <td>{{ $customer->billing_cycle }}</td>
                            <td>
                                @if ($customer->status == 'active')
                                    <span class="badge bg-success/10 text-success">Active</span>
                                @elseif ($customer->status == 'suspended')
                                    <span class="badge bg-light text-dark">Suspended</span>
                                @elseif ($customer->status == 'inactive')
                                    <span class="badge bg-danger text-dark">Inactive</span>
                                @endif
                            </td>
                            <td>{{ $customer->expiry_date }}</td>
                            <td>
                                <div class="hstack gap-2 flex-wrap">
                                    {{-- <div wire:click="editCustomer({{ $customer->id }}, '{{ $customer->connection_type }}')"
                                    class="hs-tooltip ti-main-tooltip [--placement:top]">
                                    <button type="button"
                                        class="hs-tooltip-toggle me-4 text-info text-[.875rem] leading-none">
                                        <i class="ri-edit-line"></i>
                                        <span
                                            class="hs-tooltip-content ti-main-tooltip-content !py-1 !px-2 !bg-info !text-xs !font-medium !text-white shadow-sm dark:bg-slate-700"
                                            role="tooltip">
                                            Edit PPPoE User
                                        </span>
                                    </button>
                                </div> --}}
                                    {{-- <div wire:click="warn({{ $customer->id }}, '{{ $customer->connection_type }}')"
                                    class="hs-tooltip ti-main-tooltip [--placement:top]">
                                    <button type="button" aria-label="anchor"
                                        class="hs-tooltip-toggle me-4 text-danger text-[.875rem] leading-none">
                                        <i class="ri-delete-bin-5-line"></i>
                                        <span
                                            class="hs-tooltip-content ti-main-tooltip-content !py-1 !px-2 !bg-danger !text-xs !font-medium !text-white shadow-sm dark:bg-slate-700"
                                            role="tooltip">
                                            Delete PPPoE User
                                        </span>
                                    </button>
                                </div> --}}
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td>
                                No associated accounts were found.
                            </td>
                        </tr>
                    @endforelse
                    {{-- <tr class="border-b border-defaultborder ">
                        <th scope="row" class="text-start">2022R-01</th>
                        <td>27-010-2022</td>
                        <td>Moracco</td>
                        <td>
                            <button type="button"
                                class="ti-btn btn-wave !py-1 !px-2 !text-[0.75rem] ti-btn-success-full btn-wave">
                                <i class="ri-download-2-line align-middle me-2 inline-block"></i>Download
                            </button>
                        </td>
                    </tr>
                    <tr class="border-b border-defaultborder">
                        <th scope="row" class="text-start">2022R-02</th>
                        <td>28-10-2022</td>
                        <td>Thornton</td>
                        <td>
                            <button type="button"
                                class="ti-btn btn-wave !py-1 !px-2 !text-[0.75rem] ti-btn-success-full btn-wave">
                                <i class="ri-download-2-line align-middle me-2 inline-block"></i>Download
                            </button>
                        </td>
                    </tr>
                    <tr class="border-b border-defaultborder ">
                        <th scope="row" class="text-start">2022R-03</th>
                        <td>22-10-2022</td>
                        <td>Larry Bird</td>
                        <td>
                            <button type="button"
                                class="ti-btn btn-wave !py-1 !px-2 !text-[0.75rem] ti-btn-success-full btn-wave">
                                <i class="ri-download-2-line align-middle me-2 inline-block"></i>Download
                            </button>
                        </td>
                    </tr>
                    <tr class="border-b border-defaultborder">
                        <th scope="row" class="text-start">2022R-04</th>
                        <td>29-09-2022</td>
                        <td>Erica Sean</td>
                        <td>
                            <button aria-label="button" type="button"
                                class="ti-btn btn-wave !py-1 !px-2 !text-[0.75rem] ti-btn-success-full btn-wave">
                                <i class="ri-download-2-line align-middle me-2 inline-block"></i>Download
                            </button>
                        </td>
                    </tr>
                    <tr class="border-b border-defaultborder ">
                        <th scope="row" class="text-start">2022R-01</th>
                        <td>27-010-2022</td>
                        <td>Moracco</td>
                        <td>
                            <button type="button"
                                class="ti-btn btn-wave !py-1 !px-2 !text-[0.75rem] ti-btn-success-full btn-wave">
                                <i class="ri-download-2-line align-middle me-2 inline-block"></i>Download
                            </button>
                        </td>
                    </tr> --}}
                </tbody>
            </table>
        </div>
    </div>
</div>
