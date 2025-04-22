<div class="box">
    <div class="box-header">
        <h5 class="box-title">All SMS Table</h5>
    </div>
    <div class="box-body space-y-3">
        <div class="md:flex justify-between">
            <div class="download-data">
                <button type="button" class="ti-btn btn-wave ti-btn-primary" id="download-csv">CSV</button>
                <button type="button" class="ti-btn btn-wave ti-btn-primary" id="download-json">JSON</button>
                <button type="button" class="ti-btn btn-wave ti-btn-primary" id="download-xlsx">XLSX</button>
                <button type="button" class="ti-btn btn-wave ti-btn-primary" id="download-pdf">PDF</button>
                <button type="button" class="ti-btn btn-wave ti-btn-primary" id="download-html">HTML</button>
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
                        <th scope="col" class="text-start">ID</th>
                        <th scope="col" class="text-start">Mobile No</th>
                        <th scope="col" class="text-start">Message</th>
                        <th scope="col" class="text-start">Subject</th>
                        <th scope="col" class="text-start">Status</th>
                        <th scope="col" class="text-start">Message Id</th>
                        <th scope="col" class="text-start">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($allSms->isEmpty())
                        <tr class="border-b border-defaultborder">
                            <td colspan="13" class="text-center py-4">
                                <p>No Sent SMS found.</p>
                            </td>
                        </tr>
                    @else
                        @foreach ($allSms as $sentSms)
                            <tr wire:key="{{ $sentSms->id }}" class="border-b border-defaultborder">
                                <td>{{ $loop->iteration + ($allSms->currentPage() - 1) * $allSms->perPage() }}</td>
                                <td>{{ $sentSms->recipient }}</td>
                                <td class="max-w-xs md:max-w-sm lg:max-w-md truncate" title="{{ $sentSms->message }}">
                                    {{ $sentSms->message }}
                                </td>
                                <td>{{ $sentSms->subject }}</td>
                                <td scope="row">
                                    @if ($sentSms->is_sent)
                                        <span class="badge bg-success/10 text-success">Success</span>
                                    @else
                                        <span class="badge bg-danger/10 text-danger">Failed</span>
                                    @endif
                                </td>
                                <td>{{ $sentSms->message_id }}</td>
                                <td>{{ $sentSms->created_at }}</td>
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
                        @if ($totalSmsCount > 10)
                            <option value="10">10</option>
                        @endif

                        @if ($totalSmsCount > 20)
                            <option value="20">20</option>
                        @endif

                        @if ($totalSmsCount > 50)
                            <option value="50">50</option>
                        @endif

                        @if ($totalSmsCount > 100)
                            <option value="100">100</option>
                        @endif

                        <option value="{{ $totalSmsCount }}">
                            {{ $totalSmsCount <= 100 ? 'Show All' : '100+' }}
                        </option>
                    </select>
                </div>
            </div>
            {{ $allSms->links() }}
        </div>
    </div>
</div>
