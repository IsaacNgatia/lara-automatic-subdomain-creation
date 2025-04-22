<div class="grid grid-cols-12 gap-6">
    <div class="col-span-12">
        <div class="box">
            <div class="box-header justify-between">
                <div class="box-title">
                    All Transactions Table
                </div>
                <div class="prism-toggle">
                    <button wire:click="openStkModal" type="button"
                        class="ti-btn btn-wave !py-1 !px-2 ti-btn-primary !font-medium !text-[0.75rem]">STK
                        Requests</button>
                </div>
            </div>
            <div class="box-body space-y-3">
                <div class="flex justify-between">
                    <div class="download-data">
                        <button type="button" class="ti-btn btn-wave ti-btn-primary" id="download-csv">CSV</button>
                        <button type="button" class="ti-btn btn-wave ti-btn-primary" id="download-json">JSON</button>
                        <button type="button" class="ti-btn btn-wave ti-btn-primary" id="download-xlsx">XLSX</button>
                        <button type="button" class="ti-btn btn-wave ti-btn-primary" id="download-pdf">PDF</button>
                        <button type="button" class="ti-btn btn-wave ti-btn-primary" id="download-html">HTML</button>
                    </div>
                    <div>
                        <div class="relative">
                            <input wire:model.live.debounce.300ms="search" type="text"
                                id="hs-search-box-with-loading-1" name="hs-search-box-with-loading-1"
                                class="ti-form-input rounded-sm ps-11 focus:z-10" placeholder="Input search">
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
                                <th scope="col" class="text-start">Name</th>
                                <th scope="col" class="text-start">Trans Id</th>
                                <th scope="col" class="text-start">Amount</th>
                                <th scope="col" class="text-start">Reference</th>
                                <th scope="col" class="text-start">Customer Type</th>
                                <th scope="col" class="text-start">MSISDN</th>
                                <th scope="col" class="text-start">Time</th>
                                <th scope="col" class="text-start">Balance</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($transactions->isEmpty())
                                <tr class="border-b border-defaultborder">
                                    <td colspan="13" class="text-center py-4">
                                        <p>No Transactions found.</p>
                                    </td>
                                </tr>
                            @else
                                @foreach ($transactions as $transaction)
                                    <tr wire:key="{{ $transaction->id }}" class="border-b border-defaultborder">
                                        <td>{{ $loop->iteration + ($transactions->currentPage() - 1) * $transactions->perPage() }}
                                        </td>
                                        <th scope="row">
                                            <div class="flex items-center gap-2">
                                                <span class="avatar avatar-rounded max-w-5 max-h-5">
                                                    @switch($transaction->payment_gateway)
                                                        @case('mpesa')
                                                            <img src="{{ asset('assets/images/brand-logos/mpesa-logo.png') }}"
                                                            @break @case('cash') <img
                                                            src="{{ asset('assets/images/brand-logos/cash.png') }}" @break
                                                            @case('zenopay') <img
                                                                src="{{ asset('assets/images/brand-logos/zenopay-logo.png') }}"
                                                        @break @endswitch alt="transactions">
                                                </span>
                                                <span>{{ $transaction->first_name . ' ' . $transaction->last_name }}</span>
                                            </div>
                                        </th>
                                        <td>{{ $transaction->trans_id }}</td>
                                        <td>{{ $transaction->trans_amount }}</td>
                                        <td>{{ $transaction->reference_number }}</td>
                                        <td>{{ $transaction->customer_type }}</td>
                                        <td>{{ $transaction->msisdn }}</td>
                                        <td>{{ $transaction->trans_time }}</td>
                                        <td>{{ $transaction->org_balance }}</td>
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
                                @if ($totalTransactions > 10)
                                    <option value="10">10</option>
                                @endif

                                @if ($totalTransactions > 20)
                                    <option value="20">20</option>
                                @endif

                                @if ($totalTransactions > 50)
                                    <option value="50">50</option>
                                @endif

                                @if ($totalTransactions > 100)
                                    <option value="100">100</option>
                                @endif

                                <option value="{{ $totalTransactions }}">
                                    {{ $totalTransactions <= 100 ? 'Show All' : '100+' }}
                                </option>
                            </select>
                        </div>
                    </div>
                    {{ $transactions->links() }}
                </div>
            </div>
            <x-modal maxWidth="5xl" preventModalClose=false>
                @slot('slot')
                    @if ($stkModalIsOpen === true)
                        <livewire:admins.payments.modals.stk-requests />
                    @endif
                @endslot
            </x-modal>
        </div>
    </div>
</div>
