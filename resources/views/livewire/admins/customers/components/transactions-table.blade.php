<div>
    {{-- Success is as dangerous as failure. --}}
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
                <input wire:model.live.debouncing.250ms="search" type="text" id="hs-search-box-with-loading-1"
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
        <table class="table whitespace-nowrap ti-striped-table min-w-full">
            <thead>
                <tr class="border-b border-defaultborder">
                    <th scope="col" class="text-start">ID</th>
                    <th scope="col" class="text-start">Trans Id</th>
                    <th scope="col" class="text-start">Reference
                    </th>
                    <th scope="col" class="text-start">First Name
                    </th>
                    <th scope="col" class="text-start">Amount
                    </th>
                    <th scope="col" class="text-start">Date
                    </th>
                    <th scope="col" class="text-start">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($transactions as $transaction)
                    <tr wire:key="transaction-{{ $transaction->id }}" class="border-b border-defaultborder">
                        <th scope="row" class="text-start">
                            {{ $loop->iteration + ($transactions->currentPage() - 1) * $transactions->perPage() }}
                        </th>
                        <td>{{ $transaction->trans_id }}</td>
                        <td>{{ $transaction->reference_number }}</td>
                        <td>{{ $transaction->first_name }}</td>
                        <td>{{ $transaction->trans_amount }}</td>
                        <td>{{ $transaction->trans_time }}</td>
                        <td>
                            <button type="button"
                                class="ti-btn btn-wave !py-1 !px-2 !text-[0.75rem] ti-btn-success-full btn-wave">
                                <i class="ri-download-2-line align-middle me-2 inline-block"></i>Download
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-gray-500 py-4">
                            <i class="ri-information-line text-xl"></i> No transactions found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        {{ $transactions->links() }}
    </div>
</div>
