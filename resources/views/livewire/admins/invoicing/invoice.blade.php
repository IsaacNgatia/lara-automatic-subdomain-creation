<div>
    <!-- Page Header Close -->
    <!-- Start:: Invoices -->
    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12">
            <div class="box custom-box">
                <div class="box-header justify-between">
                    <div class="box-title">
                        Invoices
                    </div>

                    <div>
                        <a class="btn" href="{{ route('invoice.edit') }}">New Invoice</a>
                    </div>

                </div>
                <div class="box-body space-y-3">
                    <div class="table-responsive">
                        <table class="table whitespace-nowrap table-bordered min-w-full">
                            <thead>
                                <tr class="border-b border-defaultborder">
                                    <th scope="col" class="text-start">#</th>
                                    <th scope="col" class="text-start">Ref No</th>
                                    <th scope="col" class="text-start">Customer</th>
                                    <th scope="col" class="text-start">Generated On</th>
                                    <th scope="col" class="text-start">Amount</th>
                                    <th scope="col" class="text-start">Status</th>
                                    <th scope="col" class="text-start">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($invoices as $invoice)
                                    <tr class="border-b border-defaultborder">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $invoice->reference_number }}</td>
                                        <td>{{ $invoice->customer->official_name }}</td>
                                        <td>{{ $invoice->invoice_date }}</td>
                                        <td>{{ $invoice->total }}</td>
                                        <td>
                                            @if ($invoice->status == 'unpaid')
                                                <span class="badge bg-danger/10 text-danger">unpaid</span>
                                            @elseif($invoice->status == 'paid')
                                                <span class="badge bg-success/10 text-success">paid</span>
                                            @endif
                                        </td>

                                        <td>
                                            <div class="hstack gap-2 flex-wrap">
                                                <div class="hs-tooltip ti-main-tooltip [--placement:top]">
                                                    <a  href="{{ route('invoice.view', $invoice->id) }}"
                                                        class="hs-tooltip-toggle me-4 text-info text-[.875rem] leading-none">
                                                        <i class="ri-eye-line"></i>
                                                        <span
                                                            class="hs-tooltip-content ti-main-tooltip-content !py-1 !px-2 !bg-info !text-xs !font-medium !text-white shadow-sm dark:bg-slate-700"
                                                            role="tooltip">
                                                            View Invoice
                                                        </span>
                                                    </a>
                                                </div>
                                                {{-- <div class="hs-tooltip ti-main-tooltip [--placement:top]">
                                                    <a href="{{ route('invoice.edit', $invoice->id) }}"
                                                        class="hs-tooltip-toggle me-4 text-info text-[.875rem] leading-none">
                                                        <i class="ri-edit-line"></i>
                                                        <span
                                                            class="hs-tooltip-content ti-main-tooltip-content !py-1 !px-2 !bg-info !text-xs !font-medium !text-white shadow-sm dark:bg-slate-700"
                                                            role="tooltip">
                                                            Edit Invoice
                                                        </span>
                                                    </a>
                                                </div> --}}
                                                <div class="hs-tooltip ti-main-tooltip [--placement:top]">
                                                    <button type="button" aria-label="anchor"
                                                        class="hs-tooltip-toggle me-4 text-danger text-[.875rem] leading-none">
                                                        <i class="ri-delete-bin-5-line"></i>
                                                        <span
                                                            class="hs-tooltip-content ti-main-tooltip-content !py-1 !px-2 !bg-danger !text-xs !font-medium !text-white shadow-sm dark:bg-slate-700"
                                                            role="tooltip">
                                                            Delete Invoice
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
                    {{ $invoices->links() }}

                </div>
            </div>
        </div>
    </div>
</div>
