<div>
    <div class="grid grid-cols-12 gap-6">
        <div class="xl:col-span-4 col-span-4">
            <div class="box">
                <div class="box-header justify-between">
                    <div class="box-title">
                        Pay Now
                    </div>
                </div>
                <form wire:submit="makePayment">
                    <div class="box-body">
                        <div class="mb-4">
                            <label for="form-text" class="form-label !text-[.875rem] text-black">Enter number to pay
                                with</label>
                            <input type="number" class="form-control" id="form-text" placeholder=""
                                wire:model="phone_number">
                        </div>
                        <div class="mb-4">
                            <label for="your-bill" class="form-label text-[.875rem] text-black">Your Bill</label>
                            <input type="number" class="form-control" id="your-bill" placeholder=""
                                wire:model="amount">
                        </div>
                        <div class="mb-4">
                            <label for="reference-number" class="form-label text-[.875rem] text-black">Reference
                                Number</label>
                            <input type="number" class="form-control" id="reference-number" placeholder=""
                                wire:model="reference_number">
                        </div>
                        <button wire:loading.attr="disabled" wire:loading.class="opacity-50 cursor-not-allowed"
                            type="submit" class="ti-btn btn-wave ti-btn-primary-full w-full">
                            <span wire:loading.remove>Pay</span>
                            <span wire:loading>Initializing Payment ...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="xl:col-span-8 col-span-8">
            <div class="box">
                <div class="box-header justify-between">
                    <div class="box-title">
                        Transactions
                    </div>
                </div>
                <div class="box-body">
                    <div class="col-span-12 md:col-span-6 xxl:!col-span-4">
                        <div class="box">
                            <div class="box-body">
                                <select id="tab-select"
                                    class="mb-5 sm:hidden py-2 px-3 pe-9 block w-full border-gray-200 rounded-sm text-sm focus:border-primary focus:ring-primary dark:bg-bgdark dark:border-white/10 dark:text-[#8c9097] dark:text-white/50"
                                    aria-label="Tabs">
                                    <option value="#hs-tab-to-select-1">All Transactions</option>
                                    <option value="#hs-tab-to-select-2">Wallet Transactions</option>
                                </select>

                                <div class="hidden sm:block border-b-0 border-gray-200 dark:border-white/10">
                                    <nav class="flex space-x-2 rtl:space-x-reverse" aria-label="Tabs" role="tablist">
                                        <button type="button"
                                            class="hs-tab-active:bg-white hs-tab-active:border-b-transparent hs-tab-active:text-primary dark:hs-tab-active:bg-bodybg dark:hs-tab-active:border-b-transparent dark:hs-tab-active:text-primary -mb-px py-2 px-3 inline-flex items-center gap-2 bg-gray-50 text-sm font-medium text-center border text-defaulttextcolor rounded-t-sm hover:text-primary dark:bg-black/20 dark:border-white/10 dark:text-[#8c9097] dark:text-white/50 dark:hover:text-gray-300 active"
                                            id="hs-tab-to-select-item-1" data-hs-tab="#hs-tab-to-select-1"
                                            aria-controls="hs-tab-to-select-1">
                                            All Transactions
                                        </button>
                                        <button type="button"
                                            class="hs-tab-active:bg-white hs-tab-active:border-b-transparent hs-tab-active:text-primary dark:hs-tab-active:bg-bodybg dark:hs-tab-active:border-b-transparent dark:hs-tab-active:text-primary -mb-px py-2 px-3 inline-flex items-center gap-2 bg-gray-50 text-sm font-medium text-center border text-defaulttextcolor rounded-t-sm hover:text-primary dark:bg-black/20 dark:border-white/10 dark:text-[#8c9097] dark:text-white/50 dark:hover:text-gray-300"
                                            id="hs-tab-to-select-item-2" data-hs-tab="#hs-tab-to-select-2"
                                            aria-controls="hs-tab-to-select-2">
                                            Wallet Transactions
                                        </button>
                                    </nav>
                                </div>

                                <div class="">
                                    <div id="hs-tab-to-select-1" role="tabpanel"
                                        aria-labelledby="hs-tab-to-select-item-1">
                                        <div class="table-responsive">
                                            <table class="table whitespace-nowrap table-bordered min-w-full">
                                                <thead>
                                                    <tr class="border-b border-defaultborder">
                                                        <th scope="col" class="text-start">#</th>
                                                        <th scope="col" class="text-start">Name</th>
                                                        <th scope="col" class="text-start">Amount</th>
                                                        <th scope="col" class="text-start">Mpesa Code</th>
                                                        <th scope="col" class="text-start">Time</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse ($transactions as $transaction)
                                                        <tr class="border-b border-defaultborder">
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $transaction->first_name }}
                                                                {{ $transaction->middle_name }}
                                                                {{ $transaction->last_name }}</td>
                                                            <td>{{ $transaction->trans_amount }}</td>
                                                            <td>{{ $transaction->trans_id }}</td>
                                                            <td>{{ $transaction->trans_time }}</td>
                                                        </tr>
                                                    @empty
                                                        <tr colspan="5">
                                                            <td>
                                                                No transactions were found</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                            {{ $transactions->links() }}
                                        </div>

                                    </div>
                                    <div id="hs-tab-to-select-2" class="hidden" role="tabpanel"
                                        aria-labelledby="hs-tab-to-select-item-2">
                                        <div class="table-responsive">
                                            <table class="table whitespace-nowrap table-bordered min-w-full">
                                                <thead>
                                                    <tr class="border-b border-defaultborder">
                                                        <th scope="col" class="text-start">#</th>
                                                        <th scope="col" class="text-start">Name</th>
                                                        <th scope="col" class="text-start">Amount</th>
                                                        <th scope="col" class="text-start">Mpesa Code</th>
                                                        <th scope="col" class="text-start">Time</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse ($transactions as $transaction)
                                                        <tr class="border-b border-defaultborder">
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $transaction->first_name }}
                                                                {{ $transaction->middle_name }}
                                                                {{ $transaction->last_name }}</td>
                                                            <td>{{ $transaction->trans_amount }}</td>
                                                            <td>{{ $transaction->trans_id }}</td>
                                                            <td>{{ $transaction->trans_time }}</td>
                                                        </tr>
                                                    @empty
                                                        <tr colspan="5">
                                                            <td>
                                                                No transactions were found</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                            {{ $transactions->links() }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-modal maxWidth="sm" id="paymentModal">
        @slot('slot')
            <div class="grid grid-cols-12 gap-6">
                <div class="xl:col-span-12 col-span-12">
                    <div class="box">
                        <div class="box-header justify-between">
                            <div class="box-title">
                                Mpesa Payment Initialized
                            </div>
                        </div>
                        <div class="box-body">
                            <h4>Check Your Phone</h4>

                            <br>

                            <p>
                                Payment has been initiated on your phone. Please input your M-Pesa pin to complete payment.
                            </p>
                        </div>
                        <div class="box-footer">
                            <button class="ti-btn btn-wave ti-btn-primary-full w-full" type="button"
                                wire:click="closeModal">
                                Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endslot
    </x-modal>

</div>


<script>
    Livewire.on('open-modal', () => $('#paymentModal').modal('show'));
    Livewire.on('close-modal', () => $('#paymentModal').modal('hide'));
</script>