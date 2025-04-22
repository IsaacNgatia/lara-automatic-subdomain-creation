<div class="xl:col-span-6 col-span-12">
    <div class="box">
        <div class="box-header sm:flex justify-between">
            <div class="box-title">
                Report for <span class="text-primary">{{ sizeof($selectedCustomers) }}</span> Customers
            </div>
            <div>
                <span class="badge bg-primary/10 text-primary">
                    {{ $startingDate }} - {{ $endingDate }}
                </span>
            </div>
        </div>
        <div class="card-body !p-0">
            <div class="table-responsive">
                <table class="table whitespace-nowrap min-w-full">
                    <thead>
                        <tr>
                            <th scope="col" class="text-start min-w-[22rem]">Customer</th>
                            <th scope="col" class="text-start">Username</th>
                            <th scope="col" class="text-start">Router</th>
                            <th scope="col" class="text-start">Billing Amount</th>
                            <th scope="col" class="text-start">Transactions</th>
                            <th scope="col" class="text-start">Total Amount</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($customers as $customer)
                            <tr wire:key="{{ $customer->id }}"
                                class="border border-inherit border-solid dark:border-defaultborder/10">
                                <td>
                                    <div class="flex items-center">
                                        <div class="me-4">
                                            <span class="avatar avatar-xxl bg-light">
                                                {{ $this->getInitials($customer->official_name) }}
                                            </span>
                                        </div>
                                        <div>
                                            <div class="mb-1 text-[0.875rem] font-semibold">
                                                <a href="javascript:void(0);">{{ $customer->official_name }}</a>
                                            </div>
                                            <div class="mb-1">
                                                <span class="me-1">Reference:</span><span
                                                    class="text-[#8c9097] dark:text-white/50">{{ $customer->reference_number }}</span>
                                            </div>
                                            <div class="mb-1">
                                                <span class="me-1">Mobile:</span><span
                                                    class="text-[#8c9097] dark:text-white/50">{{ $customer->phone_number }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td><a href="javascript:void(0);" class="text-primary">{{ $customer->username }}</a>
                                </td>
                                <td>
                                    <span class="text-[0.9375rem] font-semibold">{{ $customer->mikrotik_name }}</span>
                                </td>
                                <td>{{ $customer->billing_amount }}</td>
                                <td>{{ $customer->total_transactions_count }}</td>
                                <td>{{ $customer->total_transactions_amount }}</td>
                            </tr>
                        @endforeach
                        <tr class="border border-inherit border-solid dark:border-defaultborder/10">
                            <td colspan="3"></td>
                            <td colspan="2">
                                <div class="font-semibold">Total Transactions :</div>
                            </td>
                            <td>
                                {{ $totalTransactionsCount }}
                            </td>
                        </tr>
                        <tr class="border border-inherit border-solid dark:border-defaultborder/10">
                            <td colspan="3"></td>
                            <td colspan="2">
                                <div class="font-semibold">Customers:</div>
                            </td>
                            <td>
                                {{ sizeof($selectedCustomers) }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3"></td>
                            <td colspan="2">
                                <div class="font-semibold">Total Amount :</div>
                            </td>
                            <td>
                                <span class="text-[1rem] font-semibold">{{ $totalTransactionsAmount }}</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="py-4 px-3">
                <div class="flex ">
                    <div class="flex space-x-4 items-center mb-3">
                        <label class="w-32 text-sm font-medium ">Per Page</label>
                        <select wire:model.live.debounce.200ms="perPage"
                            class="bg-gray-50 border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            @if (sizeof($selectedCustomers) > 10)
                                <option value="10">10</option>
                            @endif

                            @if (sizeof($selectedCustomers) > 20)
                                <option value="20">20</option>
                            @endif

                            @if (sizeof($selectedCustomers) > 50)
                                <option value="50">50</option>
                            @endif

                            @if (sizeof($selectedCustomers) > 100)
                                <option value="100">100</option>
                            @endif

                            <option value="{{ sizeof($selectedCustomers) }}">
                                {{ sizeof($selectedCustomers) <= 100 ? 'Show All' : '100+' }}
                            </option>
                        </select>
                    </div>
                </div>
                {{ $customers->links() }}
            </div>
        </div>
        <div class="box-footer border-t-0">
            <div class="btn-list ltr:float-right rtl:float-left">
                <button aria-label="button" type="button"
                    class="ti-btn btn-wave bg-primary text-white !py-1 !px-2 !font-medium"
                    onclick="javascript:window.print();"><i
                        class="ri-printer-line me-1 align-middle inline-block"></i>Print</button>
                <button aria-label="button" type="button"
                    class="ti-btn btn-wave bg-secondary text-white !py-1 !px-2 !font-medium"><i
                        class="ri-share-forward-line me-1 align-middle inline-block"></i>Share Details</button>
            </div>
        </div>
    </div>
</div>
