<div>
    <div class="grid grid-cols-12 gap-6">
        <div class="xl:col-span-9 col-span-12">
            <div class="box">
                <div class="box-header md:flex block">
                    <div class="h5 mb-0 sm:flex bllock items-center">
                        <div class="avatar avatar-sm">
                            <img src="{{ asset('build/assets/images/brand-logos/toggle-logo.png') }}" alt="">
                        </div>
                        <div class="sm:ms-2 ms-0 sm:mt-0 mt-2">
                            <div class="h6 font-semibold mb-0 ">INVOICE : <span
                                    class="text-primary">{{ $invoice->reference_number }}</span></div>
                        </div>
                    </div>
                    <div class="ms-auto md:mt-0 mt-2">
                        {{-- <button type="button"
                            class="ti-btn btn-wave !py-1 !px-2  text-white !text-[0.75rem] bg-secondary me-1"
                            wire:click="printInvoice({{ $invoice->id }})">Print<i
                                class="ri-printer-line ms-1 align-middle inline-block"></i></button> --}}

                        <button wire:loading.attr="disabled" wire:loading.class="opacity-50 cursor-not-allowed"
                            wire:click="printInvoice({{ $invoice->id }})" type="submit"
                            class="ti-btn btn-wave ti-btn-primary-full w-full">
                            <span wire:loading.remove>Print</span><i
                                class="ri-printer-line ms-1 align-middle inline-block"></i>
                            <span wire:loading>Printing Invoice</span>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="grid grid-cols-12 gap-4">
                        <div class="xl:col-span-12 col-span-12">
                            <div class="grid grid-cols-12 sm:gap-x-6 gap-y-6">
                                <div class="xl:col-span-4 lg:col-span-6 md:col-span-6 sm:col-span-6 col-span-12">
                                    <p class="text-[#8c9097] dark:text-white/50 mb-2">
                                        Billing From :
                                    </p>
                                    <p class="font-bold mb-1">
                                        SPRUKO TECHNOLOGIES
                                    </p>
                                    <p class="mb-1 text-[#8c9097] dark:text-white/50">
                                        Mig-1-11,Manroe street
                                    </p>
                                    <p class="mb-1 text-[#8c9097] dark:text-white/50">
                                        Georgetown,Washington D.C,USA,200071
                                    </p>
                                    <p class="mb-1 text-[#8c9097] dark:text-white/50">
                                        sprukotrust.ynex@gmail.com
                                    </p>
                                    <p class="mb-1 text-[#8c9097] dark:text-white/50">
                                        (555) 555-1234
                                    </p>
                                    <p class="text-[#8c9097] dark:text-white/50">For more information check for <a
                                            href="javascript:void(0);"
                                            class="text-primary font-semibold"><u>GSTIN</u></a> Details.</p>
                                </div>
                                <div class="xl:col-span-4 xl:flex hidden"></div>
                                <div
                                    class="xl:col-span-4 lg:col-span-6 md:col-span-6 sm:col-span-6 col-span-12 sm:ms-auto sm:mt-0 mt-4">
                                    <p class="text-[#8c9097] dark:text-white/50 mb-2">
                                        Billing To :
                                    </p>
                                    <p class="font-bold mb-1">
                                        {{ $invoice->customer->official_name }}
                                    </p>
                                    <p class="text-[#8c9097] dark:text-white/50 mb-1">
                                        {{ $invoice->customer->location }}
                                    </p>
                                    <p class="text-[#8c9097] dark:text-white/50 mb-1">
                                        {{ $invoice->customer->email }}
                                    </p>
                                    <p class="text-[#8c9097] dark:text-white/50">
                                        {{ $invoice->customer->phone_number }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="xl:col-span-3 col-span-12">
                            <p class="font-semibold text-[#8c9097] dark:text-white/50 mb-1">Invoice ID :</p>
                            <p class="text-[.9375rem] mb-1">{{ $invoice->reference_number }}</p>
                        </div>
                        <div class="xl:col-span-3 col-span-12">
                            <p class="font-semibold text-[#8c9097] dark:text-white/50 mb-1">Date Issued :</p>
                            <p class="text-[.9375rem] mb-1">{{ $invoice->invoice_date }}</p>
                        </div>
                        <div class="xl:col-span-3 col-span-12">
                            <p class="font-semibold text-[#8c9097] dark:text-white/50 mb-1">Due Date :</p>
                            <p class="text-[.9375rem] mb-1">{{ $invoice->due_date }}</p>
                        </div>
                        <div class="xl:col-span-3 col-span-12">
                            <p class="font-semibold text-[#8c9097] dark:text-white/50 mb-1">Due Amount :</p>
                            <p class="text-[1rem] mb-1 font-semibold">KSH {{ $invoice->total }}</p>
                        </div>
                        <div class="xl:col-span-12 col-span-12">
                            <div class="table-responsive">
                                <table
                                    class="table nowrap whitespace-nowrap border dark:border-defaultborder/10 mt-4 min-w-full">
                                    <thead>
                                        <tr>
                                            <th scope="row" class="text-start">Package</th>
                                            <th scope="row" class="text-start">Quantity</th>
                                            <th scope="row" class="text-start">Rate</th>
                                            <th scope="row" class="text-start">Sub Total</th>
                                            <th scope="row" class="text-start">From</th>
                                            <th scope="row" class="text-start">To</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($invoice->items as $item)
                                            <tr class="border border-defaultborder dark:border-defaultborder/10">
                                                <td>
                                                    <div class="font-semibold">
                                                        {{ $item->servicePlan->name }}
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="text-[#8c9097] dark:text-white/50">
                                                        {{ $item->quantity }}
                                                    </div>
                                                </td>
                                                <td class="product-quantity-container">
                                                    {{ $item->rate }}
                                                </td>
                                                <td>
                                                    {{ $item->sub_total }}
                                                </td>
                                                <td>
                                                    {{ $item->from }}
                                                </td>
                                                <td>
                                                    {{ $item->to }}
                                                </td>
                                            </tr>
                                        @endforeach
                                        {{-- <tr class="border border-defaultborder dark:border-defaultborder/10">
                                            <td>
                                                <div class="font-semibold">
                                                    Denim Winjo (Jacket)
                                                </div>
                                            </td>
                                            <td>
                                                <div class="text-[#8c9097] dark:text-white/50">
                                                    Vintage pure leather Jacket
                                                </div>
                                            </td>
                                            <td class="product-quantity-container">
                                                1
                                            </td>
                                            <td>
                                                $249
                                            </td>
                                            <td>
                                                $249
                                            </td>
                                        </tr>
                                        <tr class="border border-defaultborder dark:border-defaultborder/10">
                                            <td>
                                                <div class="font-semibold">
                                                    Jimmy Lolfiger (Winter Coat)
                                                </div>
                                            </td>
                                            <td>
                                                <div class="text-[#8c9097] dark:text-white/50">
                                                    Unisex jacket for men &amp; women
                                                </div>
                                            </td>
                                            <td class="product-quantity-container">
                                                1
                                            </td>
                                            <td>
                                                $499
                                            </td>
                                            <td>
                                                $499
                                            </td>
                                        </tr>
                                        <tr class="border border-defaultborder dark:border-defaultborder/10">
                                            <td>
                                                <div class="font-semibold">
                                                    Blueberry &amp; Co
                                                </div>
                                            </td>
                                            <td>
                                                <div class="text-[#8c9097] dark:text-white/50">
                                                    Light colored sweater form blueberry
                                                </div>
                                            </td>
                                            <td class="product-quantity-container">
                                                3
                                            </td>
                                            <td>
                                                $299
                                            </td>
                                            <td>
                                                $897
                                            </td>
                                        </tr>
                                        <tr class="border border-defaultborder dark:border-defaultborder/10">
                                            <td>
                                                <div class="font-semibold">
                                                    Denim Corporation
                                                </div>
                                            </td>
                                            <td>
                                                <div class="text-[#8c9097] dark:text-white/50">
                                                    Flap pockets denim jackets for men
                                                </div>
                                            </td>
                                            <td class="product-quantity-container">
                                                1
                                            </td>
                                            <td>
                                                $599
                                            </td>
                                            <td>
                                                $599
                                            </td>
                                        </tr>
                                        <tr class="border border-defaultborder dark:border-defaultborder/10">
                                            <td colspan="3"></td>
                                            <td colspan="2">
                                                <table
                                                    class="table table-sm whitespace-nowrap mb-0 table-borderless w-full">
                                                    <tbody>
                                                        <tr>
                                                            <th scope="row">
                                                                <p class="mb-0">Sub Total :</p>
                                                            </th>
                                                            <td>
                                                                <p class="mb-0 font-semibold text-[.9375rem]">$2,364</p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">
                                                                <p class="mb-0">Avail Discount :</p>
                                                            </th>
                                                            <td>
                                                                <p class="mb-0 font-semibold text-[.9375rem]">$29.98</p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">
                                                                <p class="mb-0">Coupon Discount <span
                                                                        class="text-success">(10%)</span> :</p>
                                                            </th>
                                                            <td>
                                                                <p class="mb-0 font-semibold text-[.9375rem]">$236.40
                                                                </p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">
                                                                <p class="mb-0">Vat <span
                                                                        class="text-danger">(20%)</span> :</p>
                                                            </th>
                                                            <td>
                                                                <p class="mb-0 font-semibold text-[.9375rem]">$472.80
                                                                </p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">
                                                                <p class="mb-0">Due Till Date :</p>
                                                            </th>
                                                            <td>
                                                                <p class="mb-0 font-semibold text-[.9375rem]">$0</p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">
                                                                <p class="mb-0 text-[.875rem]">Total :</p>
                                                            </th>
                                                            <td>
                                                                <p class="mb-0 font-semibold text-[1rem] text-success">
                                                                    $2,570.42</p>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr> --}}
                                    </tbody>In
                                </table>
                            </div>
                        </div>
                        <div class="xl:col-span-12 col-span-12">
                            <div>
                                <label for="invoice-note" class="form-label">Note:</label>
                                <textarea class="form-control w-full !rounded-md !bg-light" id="invoice-note" rows="3">{{ $invoice->notes }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="xl:col-span-3 col-span-12">
            <div class="box">
                <div class="box-header">
                    <div class="box-title">
                        Status
                    </div>
                </div>
                <div class="box-body">
                    <div class="grid grid-cols-12 gap-4">
                        <div class="xl:col-span-12 col-span-12">

                            <p class="mb-4">
                                <span class="font-semibold text-[#8c9097] dark:text-white/50 text-[0.75rem]">Total
                                    Amount :</span> <span
                                    class="text-success font-semibold text-[.875rem]">{{ $invoice->total }}</span>
                            </p>
                            <p class="mb-4">
                                <span class="font-semibold text-[#8c9097] dark:text-white/50 text-[0.75rem]">Due Date
                                    :</span> {{ $invoice->due_date }} - <span
                                    class="text-danger text-[0.75rem] font-semibold">{{ $difference ?? '' }}</span>
                            </p>
                            <p class="mb-4">
                                <span class="font-semibold text-[#8c9097] dark:text-white/50 text-[0.75rem]">Invoice
                                    Status : @if ($invoice->status == 'unpaid')
                                        <span class="badge bg-danger/10 text-warning">Unpaid</span>
                                    @else
                                        <span class="badge bg-success/10 text-warning">Paid</span>
                                    @endif
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
