@extends('admins.layouts.master')

@section('styles')
@endsection

@section('content')
    <!-- Page Header -->
    <div class="block justify-between page-header md:flex">
        <div>
            <h3
                class="!text-defaulttextcolor dark:!text-defaulttextcolor/70 dark:text-white dark:hover:text-white text-[1.125rem] font-semibold">
                Hotspot Overview</h3>
        </div>
        <ol class="flex items-center whitespace-nowrap min-w-0">
            <li class="text-[0.813rem] ps-[0.5rem]">
                <a class="flex items-center text-primary hover:text-primary dark:text-primary truncate"
                    href="javascript:void(0);">
                    Hotspot
                    <i
                        class="ti ti-chevrons-right flex-shrink-0 text-[#8c9097] dark:text-white/50 px-[0.5rem] overflow-visible rtl:rotate-180"></i>
                </a>
            </li>
            <li class="text-[0.813rem] text-defaulttextcolor font-semibold hover:text-primary dark:text-[#8c9097] dark:text-white/50 "
                aria-current="page">
                Hotspot Dashboard
            </li>
        </ol>
    </div>
    <!-- Page Header Close -->

    <div class="grid grid-cols-12 gap-x-6">
        <div class="xxl:col-span-5 xl:col-span-12 col-span-12">
            <div class="grid grid-cols-12 gap-x-6">
                <div class="xxl:col-span-6 xl:col-span-6 lg:col-span-6 md:col-span-6 sm:col-span-12 col-span-12">
                    <div class="box hrm-main-card primary">
                        <div class="box-body">
                            <div class="flex items-start">
                                <div class="me-4">
                                    <span class="avatar bg-primary !text-white">
                                        <i class="ri-time-line text-[1.125rem]"></i>
                                    </span>
                                </div>
                                <div class="flex-grow">
                                    <span class="font-semibold text-[#8c9097] dark:text-white/50 block mb-1">Today's HSP
                                        Collections
                                    </span>
                                    <h5 class="font-semibold mb-1 text-[1.25rem]">1,124</h5>
                                    <p class="mb-0">
                                        <span class="badge bg-primary/10 text-primary">Monday</span>
                                    </p>
                                </div>
                                <div>
                                    <span class="text-[0.875rem] font-semibold text-success">+1.03%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="xxl:col-span-6 xl:col-span-6 lg:col-span-6 md:col-span-6 sm:col-span-12 col-span-12">
                    <div class="box hrm-main-card secondary">
                        <div class="box-body">
                            <div class="flex items-start">
                                <div class="me-4">
                                    <span class="avatar bg-secondary !text-white">
                                        <i class="bi bi-calendar-month text-[1.125rem]"></i>

                                    </span>
                                </div>
                                <div class="flex-grow">
                                    <span class="font-semibold text-[#8c9097] dark:text-white/50 block mb-1">Month's HSP
                                        Collections
                                    </span>
                                    <h5 class="font-semibold mb-1 text-[1.25rem]">5,280</h5>
                                    <p class="mb-0">
                                        <span class="badge bg-secondary/10 text-secondary">August</span>
                                    </p>
                                </div>
                                <div>
                                    <span class="text-[0.875rem] font-semibold text-success">+0.36%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="xxl:col-span-6 xl:col-span-6 lg:col-span-6 md:col-span-6 sm:col-span-12 col-span-12">
                    <div class="box  hrm-main-card warning">
                        <div class="box-body">
                            <div class="flex items-start">
                                <div class="me-4">
                                    <span class="avatar bg-warning !text-white">
                                        <i class="ri-calendar-event-fill text-[1.125rem]"></i>
                                    </span>
                                </div>
                                <div class="flex-grow">
                                    <span class="font-semibold text-[#8c9097] dark:text-white/50 block mb-1">Year's HSP
                                        Collections
                                    </span>
                                    <h5 class="font-semibold mb-1 text-[1.25rem]">118,289</h5>
                                    <p class="mb-0">
                                        <span class="badge bg-warning/10 text-warning">2024</span>
                                    </p>
                                </div>
                                <div>
                                    <span class="text-[0.875rem] font-semibold text-danger">-1.28%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="xxl:col-span-6 xl:col-span-6 lg:col-span-6 md:col-span-6 sm:col-span-12 col-span-12">
                    <div class="box hrm-main-card danger">
                        <div class="box-body">
                            <div class="flex items-start">
                                <div class="me-4">
                                    <span class="avatar bg-danger !text-white">
                                        <i class="ri-ai-generate text-[1.125rem]"></i>
                                    </span>
                                </div>
                                <div class="flex-grow">
                                    <span class="font-semibold text-[#8c9097] dark:text-white/50 block mb-1"> Generated
                                        Vouchers
                                    </span>
                                    <h5 class="font-semibold mb-1 text-[1.25rem]">13</h5>
                                    <p class="mb-0">
                                        <span class="badge bg-danger/10 text-danger">Monday</span>
                                    </p>
                                </div>
                                <div>
                                    <span class="text-[0.875rem] font-semibold text-success">+4.25%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="xl:col-span-12 col-span-12">
                    <div class="box">
                        <div class="box-header">
                            <div class="box-title">Hotspot Summary</div>
                        </div>
                        <div class="box-body">
                            <div class="sm:grid grid-cols-12 md:gap-y-0 gap-y-3">
                                <div class="xxl:col-span-4 xl:col-span-4 lg:col-span-4 md:col-span-4 sm:col-span-12">
                                    <div class="flex items-start">
                                        <div class="me-3">
                                            <span class="avatar avatar-rounded bg-light !text-primary">
                                                <i class="bi bi-calendar4-week text-[1.125rem]"></i>
                                            </span>
                                        </div>
                                        <div>
                                            <span class="block mb-1 text-[#8c9097] dark:text-white/50">Best of 7</span>
                                            <h6 class="font-semibold mb-0 text-[1rem]">Wednesday</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="xxl:col-span-4 xl:col-span-4 lg:col-span-4 md:col-span-4 sm:col-span-12">
                                    <div class="flex items-start">
                                        <div class="me-3">
                                            <span class="avatar avatar-rounded bg-light !text-secondary">
                                                <i class="ti ti-tallymarks text-[1.125rem]"></i>
                                            </span>
                                        </div>
                                        <div>
                                            <span class="block mb-1 text-[#8c9097] dark:text-white/50">Total Manual
                                            </span>
                                            <h6 class="font-semibold mb-0 text-[1rem]">201</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="xxl:col-span-4 xl:col-span-4 lg:col-span-4 md:col-span-4 sm:col-span-12">
                                    <div class="flex items-start">
                                        <div class="me-3">
                                            <span class="avatar avatar-rounded bg-light !text-warning">
                                                <i class="ti ti-world-minus text-[1.125rem]"></i>
                                            </span>
                                        </div>
                                        <div>
                                            <span class="block mb-1 text-[#8c9097] dark:text-white/50">Sold Manual
                                            </span>
                                            <h6 class="font-semibold mb-0 text-[1rem]">21</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="xxl:col-span-7 xl:col-span-12 col-span-12">
            <div class="box">
                <div class="box-header justify-between items-center sm:flex block">
                    <div class="box-title sm:mb-0 mb-2">
                        Revenue of Generated and Manual Vouchers
                    </div>
                    <div class="inline-flex rounded-md shadow-sm" role="group" aria-label="Basic example">
                        <button type="button"
                            class="ti-btn-group !border-0 !text-xs !py-2 !px-3 ti-btn-primary">1W</button>
                        <button type="button"
                            class="ti-btn-group !border-0 !text-xs !py-2 !px-3 ti-btn-primary">1M</button>
                        <button type="button"
                            class="ti-btn-group !border-0 !text-xs !py-2 !px-3 ti-btn-primary">6M</button>
                        <button type="button"
                            class="ti-btn-group !border-0 !text-xs !py-2 !px-3 ti-btn-primary-full !rounded-s-none !text-white">1Y</button>
                    </div>
                </div>
                <div class="box-body">
                    <div id="column-stacked"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="grid grid-cols-12 gap-x-6 col-span-12">
        <div class="xxl:col-span-3 xl:col-span-6 lg:col-span-6 md:col-span-12 col-span-12">
            <div class="box">
                <div class="box-header">
                    <div class="box-title">
                        Hotspot Vouchers
                    </div>
                </div>
                <div class="box-body py-4 px-0">
                    <div id="jobs-summary"></div>
                </div>
                <div class="box-footer !py-6 !px-4 !mt-2">
                    <div class="grid xxxl:grid-cols-4 grid-cols-4">
                        <div class="col p-0">
                            <div class="text-center">
                                <span
                                    class="text-[#8c9097] dark:text-white/50 text-[0.75rem] mb-1 hrm-jobs-legend published inline-block ms-2">Unsold
                                    Manual
                                </span>
                                <div><span class="text-[1rem] font-semibold">1,624</span>
                                </div>
                            </div>
                        </div>
                        <div class="col p-0">
                            <div class="text-center">
                                <span
                                    class="text-[#8c9097] dark:text-white/50 text-[0.75rem] mb-1 hrm-jobs-legend private inline-block ms-2">Sold
                                    Manual
                                </span>
                                <div><span class="text-[1rem] font-semibold">1,267</span></div>
                            </div>
                        </div>
                        <div class="col p-0">
                            <div class="text-center">
                                <span
                                    class="text-[#8c9097] dark:text-white/50 text-[0.75rem] mb-1 hrm-jobs-legend closed inline-block ms-2">Generated
                                </span>
                                <div><span class="text-[1rem] font-semibold">1,153</span>
                                </div>
                            </div>
                        </div>
                        <div class="col p-0">
                            <div class="text-center">
                                <span
                                    class="text-[#8c9097] dark:text-white/50 text-[0.75rem] mb-1 hrm-jobs-legend onhold inline-block ms-2">Recurring
                                </span>
                                <div><span class="text-[1rem] font-semibold">1,153</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="xxl:col-span-4 xl:col-span-6 lg:col-span-6 md:col-span-12 col-span-12">
            <div class="box">
                <div class="box-header">
                    <div class="box-title">Most Recent Hotspot Transactions</div>
                </div>
                <div class="box-body">
                    <ul class="list-none courses-instructors mb-0">
                        <li>
                            <div class="flex">
                                <div class="flex flex-grow items-center">
                                    <div class="me-2">
                                        <span class="avatar avatar-rounded">
                                            <img src="{{ asset('build/assets/images/company-logos/mpesa.png') }}"
                                                alt="" class="object-cover">
                                        </span>
                                    </div>
                                    <div>
                                        <span class="block font-semibold">John Henry</span>
                                        <span class="text-[#8c9097] dark:text-white/50">M-PESA</span>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <span class="block text-primary font-semibold">KES 300.00</span>
                                    <span class="text-[#8c9097] dark:text-white/50">2024-08-04 23:56:00</span>
                                </div>

                            </div>
                        </li>
                        <li>
                            <div class="flex">
                                <div class="flex flex-grow items-center">
                                    <div class="me-2">
                                        <span class="avatar avatar-rounded">
                                            <img src="{{ asset('build/assets/images/company-logos/mpesa.png') }}"
                                                alt="" class="object-cover">
                                        </span>
                                    </div>
                                    <div>
                                        <span class="block font-semibold">Mortal Yun</span>
                                        <span class="text-[#8c9097] dark:text-white/50">M-PESA</span>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <span class="block text-primary font-semibold">KES 130.00</span>
                                    <span class="text-[#8c9097] dark:text-white/50">2024-08-04 23:56:00</span>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="flex">
                                <div class="flex flex-grow items-center">
                                    <div class="me-2">
                                        <span class="avatar avatar-rounded">
                                            <img src="{{ asset('build/assets/images/company-logos/cash-payment.png') }}"
                                                alt="">
                                        </span>
                                    </div>
                                    <div>
                                        <span class="block font-semibold">Trex Con</span>
                                        <span class="text-[#8c9097] dark:text-white/50">Cash</span>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <span class="block text-primary font-semibold">KES 20.00</span>
                                    <span class="text-[#8c9097] dark:text-white/50">2024-08-04 23:56:00</span>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="flex">
                                <div class="flex flex-grow items-center">
                                    <div class="me-2">
                                        <span class="avatar avatar-rounded">
                                            <img src="{{ asset('build/assets/images/company-logos/cash-payment.png') }}"
                                                alt="" class="object-cover">
                                        </span>
                                    </div>
                                    <div>
                                        <span class="block font-semibold">Trex Con</span>
                                        <span class="text-[#8c9097] dark:text-white/50">Cash</span>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <span class="block text-primary font-semibold">KES 20.00</span>
                                    <span class="text-[#8c9097] dark:text-white/50">2024-08-04 23:56:00</span>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="flex">
                                <div class="flex flex-grow items-center">
                                    <div class="me-2">
                                        <span class="avatar avatar-rounded">
                                            <img src="{{ asset('build/assets/images/company-logos/mpesa.png') }}"
                                                alt="" class="object-cover">
                                        </span>
                                    </div>
                                    <div>
                                        <span class="block font-semibold">Saiu Sarah</span>
                                        <span class="text-[#8c9097] dark:text-white/50">M-PESA</span>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <span class="block text-primary font-semibold">KES 50.00</span>
                                    <span class="text-[#8c9097] dark:text-white/50">2024-08-04 23:56:00</span>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="flex">
                                <div class="flex flex-grow items-center">
                                    <div class="me-2">
                                        <span class="avatar avatar-rounded">
                                            <img src="{{ asset('build/assets/images/company-logos/mpesa.png') }}"
                                                alt="" class="object-cover">
                                        </span>
                                    </div>
                                    <div>
                                        <span class="block font-semibold">Ion Hau</span>
                                        <span class="text-[#8c9097] dark:text-white/50">M-PESA</span>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <span class="block text-primary font-semibold">KES 250.00</span>
                                    <span class="text-[#8c9097] dark:text-white/50">2024-08-04 23:56:00</span>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="xxl:col-span-5 xl:col-span-12 col-span-12">
            <div class="box">
                <div class="box-header">
                    <div class="box-title">Generated Vouchers</div>
                </div>
                <div class="box-body !p-0">
                    <div class="table-responsive">
                        <table class="table whitespace-nowrap min-w-full">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-start">Client</th>
                                    <th scope="col" class="text-start">Voucher</th>
                                    <th scope="col" class="text-start">Purchased At</th>
                                    <th scope="col" class="text-start">Status</th>
                                    <th scope="col" class="text-start">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-t border-defaultborder dark:border-defaultborder/10">
                                    <th scope="col" class="min-w-40">
                                        <div>
                                            <span class="block font-semibold mb-1">Diana Aise</span>
                                            <span
                                                class="block text-[#8c9097] dark:text-white/50 text-[0.75rem] text-start">0712345678</span>
                                        </div>
                                    </th>
                                    <td>tvybsc2</td>
                                    <td>2024-08-09 23:00:03</td>
                                    <td>
                                        Active
                                    </td>
                                    <td>
                                        <div class="flex flex-row items-center !gap-2 text-[0.9375rem]">
                                            <a aria-label="anchor" href="javascript:void(0);"
                                                class="ti-btn btn-wave !gap-0 !m-0 !h-[1.75rem] !w-[1.75rem] text-[0.8rem] bg-secondary/10 text-secondary hover:bg-secondary hover:text-white hover:border-secondary"><i
                                                    class="ri-eye-line"></i></a>
                                            <a aria-label="anchor" href="javascript:void(0);"
                                                class="ti-btn btn-wave !gap-0 !m-0 !h-[1.75rem] !w-[1.75rem] text-[0.8rem] bg-success/10 text-success hover:bg-success hover:text-white hover:border-success"><i
                                                    class="ri-delete-bin-line"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="border-t border-defaultborder dark:border-defaultborder/10">
                                    <th scope="row" class="min-w-40">
                                        <div>
                                            <span class="block font-semibold mb-1">Rose Mary</span>
                                            <span
                                                class="block text-[#8c9097] dark:text-white/50 text-[0.75rem] text-start">0712345678</span>
                                        </div>
                                    </th>
                                    <td>78675yegfdv</td>
                                    <td>2024-08-09 23:00:03</td>
                                    <td>
                                        Inactive
                                    </td>
                                    <td>
                                        <div class="flex flex-row items-center !gap-2 text-[0.9375rem]">
                                            <a aria-label="anchor" href="javascript:void(0);"
                                                class="ti-btn btn-wave !gap-0 !m-0 !h-[1.75rem] !w-[1.75rem] text-[0.8rem] bg-secondary/10 text-secondary hover:bg-secondary hover:text-white hover:border-secondary"><i
                                                    class="ri-eye-line"></i></a>
                                            <a aria-label="anchor" href="javascript:void(0);"
                                                class="ti-btn btn-wave !gap-0 !m-0 !h-[1.75rem] !w-[1.75rem] text-[0.8rem] bg-success/10 text-success hover:bg-success hover:text-white hover:border-success"><i
                                                    class="ri-delete-bin-line"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="border-t border-defaultborder dark:border-defaultborder/10">
                                    <th scope="row" class="min-w-40">
                                        <div>
                                            <span class="block font-semibold mb-1">Gretchen Iox</span>
                                            <span
                                                class="block text-[#8c9097] dark:text-white/50 text-[0.75rem] text-start">0712345678</span>
                                        </div>
                                    </th>
                                    <td>8kiyg</td>
                                    <td>2024-08-09 23:00:03</td>
                                    <td>
                                        Active
                                    </td>
                                    <td>
                                        <div class="flex flex-row items-center !gap-2 text-[0.9375rem]">
                                            <a aria-label="anchor" href="javascript:void(0);"
                                                class="ti-btn btn-wave !gap-0 !m-0 !h-[1.75rem] !w-[1.75rem] text-[0.8rem] bg-secondary/10 text-secondary hover:bg-secondary hover:text-white hover:border-secondary"><i
                                                    class="ri-eye-line"></i></a>
                                            <a aria-label="anchor" href="javascript:void(0);"
                                                class="ti-btn btn-wave !gap-0 !m-0 !h-[1.75rem] !w-[1.75rem] text-[0.8rem] bg-success/10 text-success hover:bg-success hover:text-white hover:border-success"><i
                                                    class="ri-delete-bin-line"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="border-t border-defaultborder dark:border-defaultborder/10">
                                    <th scope="row" class="min-w-40">
                                        <div>
                                            <span class="block font-semibold mb-1">Gray Noal</span>
                                            <span
                                                class="block text-[#8c9097] dark:text-white/50 text-[0.75rem] text-start">0712345678</span>
                                        </div>

                                    </th>
                                    <td>uy45ter</td>
                                    <td>2024-08-09 23:00:03</td>
                                    <td>
                                        Inactive
                                    </td>
                                    <td>
                                        <div class="flex flex-row items-center !gap-2 text-[0.9375rem]">
                                            <a aria-label="anchor" href="javascript:void(0);"
                                                class="ti-btn btn-wave !gap-0 !m-0 !h-[1.75rem] !w-[1.75rem] text-[0.8rem] bg-secondary/10 text-secondary hover:bg-secondary hover:text-white hover:border-secondary"><i
                                                    class="ri-eye-line"></i></a>
                                            <a aria-label="anchor" href="javascript:void(0);"
                                                class="ti-btn btn-wave !gap-0 !m-0 !h-[1.75rem] !w-[1.75rem] text-[0.8rem] bg-success/10 text-success hover:bg-success hover:text-white hover:border-success"><i
                                                    class="ri-delete-bin-line"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="border-t border-defaultborder dark:border-defaultborder/10">
                                    <th scope="row" class="border-bottom-0 min-w-40">
                                        <div>
                                            <span class="block font-semibold mb-1">Isa Bella</span>
                                            <span
                                                class="block text-[#8c9097] dark:text-white/50 text-[0.75rem] text-start">0712345678</span>
                                        </div>
                                    </th>
                                    <td class="border-bottom-0">jytbfg</td>
                                    <td class="border-bottom-0">2024-08-09 23:00:03</td>
                                    <td class="border-bottom-0">
                                        Active
                                    </td>
                                    <td>
                                        <div class="flex flex-row items-center !gap-2 text-[0.9375rem]">
                                            <a aria-label="anchor" href="javascript:void(0);"
                                                class="ti-btn btn-wave !gap-0 !m-0 !h-[1.75rem] !w-[1.75rem] text-[0.8rem] bg-secondary/10 text-secondary hover:bg-secondary hover:text-white hover:border-secondary"><i
                                                    class="ri-eye-line"></i></a>
                                            <a aria-label="anchor" href="javascript:void(0);"
                                                class="ti-btn btn-wave !gap-0 !m-0 !h-[1.75rem] !w-[1.75rem] text-[0.8rem] bg-success/10 text-success hover:bg-success hover:text-white hover:border-success"><i
                                                    class="ri-delete-bin-line"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="grid grid-cols-12 gap-x-6">
        <div class="xl:col-span-12 col-span-12">
            <div class="box">
                <div class="box-header justify-between flex-wrap">
                    <div class="box-title">
                        Manual Vouchers
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <div class="me-3">
                            <input class="ti-form-control form-control-sm" type="text" placeholder="Search Here"
                                aria-label=".form-control-sm example">
                        </div>
                        <div class="hs-dropdown ti-dropdown">
                            <a href="javascript:void(0);"
                                class="ti-btn ti-btn-primary !bg-primary !text-white !py-1 !px-2 !text-[0.75rem] !m-0 !gap-0 !font-medium"
                                aria-expanded="false">
                                Sort By<i class="ri-arrow-down-s-line align-middle ms-1 inline-block"></i>
                            </a>
                            <ul class="hs-dropdown-menu ti-dropdown-menu hidden" role="menu">
                                <li><a class="ti-dropdown-item !py-2 !px-[0.9375rem] !text-[0.8125rem] !font-medium block"
                                        href="javascript:void(0);">New</a></li>
                                <li><a class="ti-dropdown-item !py-2 !px-[0.9375rem] !text-[0.8125rem] !font-medium block"
                                        href="javascript:void(0);">Popular</a></li>
                                <li><a class="ti-dropdown-item !py-2 !px-[0.9375rem] !text-[0.8125rem] !font-medium block"
                                        href="javascript:void(0);">Relevant</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-hover whitespace-nowrap table-bordered min-w-full">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-start">S.No</th>
                                    <th scope="col" class="text-start">Data Limit</th>
                                    <th scope="col" class="text-start">Time Limit</th>
                                    <th scope="col" class="text-start">Router Name</th>
                                    <th scope="col" class="text-start">Voucher Username</th>
                                    <th scope="col" class="text-start">Profile</th>
                                    <th scope="col" class="text-start">Amount</th>
                                    <th scope="col" class="text-start">Status</th>
                                    <th scope="col" class="text-start">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    class="border border-inherit border-solid hover:bg-gray-100 dark:border-defaultborder/10 dark:hover:bg-light">
                                    <td>1</td>
                                    <td>1GB</td>
                                    <td>1w</td>
                                    <td>
                                        Router 1
                                    </td>
                                    <td>
                                        1234
                                    </td>
                                    <td>users</td>
                                    <td>
                                        $9,523
                                    </td>
                                    <td>
                                        <span class="badge bg-success text-white">Unsold</span>
                                    </td>
                                    <td>
                                        <div class="flex flex-row items-center !gap-2 text-[0.9375rem]">
                                            <a aria-label="anchor" href="javascript:void(0);"
                                                class="ti-btn ti-btn-icon ti-btn-wave !gap-0 !m-0 !h-[1.75rem] !w-[1.75rem] text-[0.8rem] bg-info/10 text-info hover:bg-info hover:text-white hover:border-info"><i
                                                    class="ri-eye-line"></i></a>
                                            <a aria-label="anchor" href="javascript:void(0);"
                                                class=" !gap-0 !m-0 !h-auto !w-auto text-[0.8rem] bg-success/10 text-success hover:bg-success hover:text-white hover:border-success p-1 rounded-md">Mark
                                                as Sold</a>
                                            <a aria-label="anchor" href="javascript:void(0);"
                                                class="ti-btn ti-btn-icon ti-btn-wave !gap-0 !m-0 !h-[1.75rem] !w-[1.75rem] text-[0.8rem] bg-danger/10 text-danger hover:bg-danger hover:text-white hover:border-danger"><i
                                                    class="ri-delete-bin-line"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                <tr
                                    class="border border-inherit border-solid hover:bg-gray-100 dark:border-defaultborder/10 dark:hover:bg-light">
                                    <td>2</td>
                                    <td>4GB</td>
                                    <td>2h</td>
                                    <td>
                                        Router 2
                                    </td>
                                    <td>
                                        78654
                                    </td>
                                    <td>
                                        users
                                    </td>
                                    <td>
                                        $8,243
                                    </td>
                                    <td>
                                        <span class="badge bg-warning text-white">Sold</span>
                                    </td>
                                    <td>
                                        <div class="flex flex-row items-center !gap-2 text-[0.9375rem]">
                                            <a aria-label="anchor" href="javascript:void(0);"
                                                class="ti-btn ti-btn-icon ti-btn-wave !gap-0 !m-0 !h-[1.75rem] !w-[1.75rem] text-[0.8rem] bg-info/10 text-info hover:bg-info hover:text-white hover:border-info"><i
                                                    class="ri-eye-line"></i></a>
                                            <a aria-label="anchor" href="javascript:void(0);"
                                                class=" !gap-0 !m-0 !h-auto !w-auto text-[0.8rem] bg-success/10 text-success hover:bg-success hover:text-white hover:border-success p-1 rounded-md">Mark
                                                as Sold</a>
                                            <a aria-label="anchor" href="javascript:void(0);"
                                                class="ti-btn ti-btn-icon ti-btn-wave !gap-0 !m-0 !h-[1.75rem] !w-[1.75rem] text-[0.8rem] bg-danger/10 text-danger hover:bg-danger hover:text-white hover:border-danger"><i
                                                    class="ri-delete-bin-line"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                <tr
                                    class="border border-inherit border-solid hover:bg-gray-100 dark:border-defaultborder/10 dark:hover:bg-light">
                                    <td>3</td>
                                    <td>5GB</td>
                                    <td>3d</td>
                                    <td>
                                        Router 3
                                    </td>
                                    <td>
                                        67543
                                    </td>
                                    <td>users
                                    </td>
                                    <td>
                                        $5,234
                                    </td>
                                    <td>
                                        <span class="badge bg-danger text-white">Expired</span>
                                    </td>
                                    <td>
                                        <div class="flex flex-row items-center !gap-2 text-[0.9375rem]">
                                            <a aria-label="anchor" href="javascript:void(0);"
                                                class="ti-btn ti-btn-icon ti-btn-wave !gap-0 !m-0 !h-[1.75rem] !w-[1.75rem] text-[0.8rem] bg-info/10 text-info hover:bg-info hover:text-white hover:border-info"><i
                                                    class="ri-eye-line"></i></a>
                                            <a aria-label="anchor" href="javascript:void(0);"
                                                class=" !gap-0 !m-0 !h-auto !w-auto text-[0.8rem] bg-success/10 text-success hover:bg-success hover:text-white hover:border-success p-1 rounded-md">Mark
                                                as Sold</a>
                                            <a aria-label="anchor" href="javascript:void(0);"
                                                class="ti-btn ti-btn-icon ti-btn-wave !gap-0 !m-0 !h-[1.75rem] !w-[1.75rem] text-[0.8rem] bg-danger/10 text-danger hover:bg-danger hover:text-white hover:border-danger"><i
                                                    class="ri-delete-bin-line"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="box-footer">
                    <div class="sm:flex items-center">
                        <div class="text-defaulttextcolor/70">
                            Showing 5 Entries <i class="bi bi-arrow-right ms-2 font-semibold"></i>
                        </div>
                        <div class="ms-auto">
                            <nav aria-label="Page navigation" class="pagination-style-4">
                                <ul class="ti-pagination mb-0">
                                    <li class="page-item disabled">
                                        <a class="page-link" href="javascript:void(0);">
                                            Prev
                                        </a>
                                    </li>
                                    <li class="page-item"><a class="page-link active" href="javascript:void(0);">1</a>
                                    </li>
                                    <li class="page-item"><a class="page-link" href="javascript:void(0);">2</a></li>
                                    <li class="page-item">
                                        <a class="page-link !text-primary" href="javascript:void(0);">
                                            next
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- Apex Charts JS -->
    <script src="{{ asset('build/assets/libs/apexcharts/apexcharts.min.js') }}"></script>

    <!-- Internal Apex-Column-Charts JS -->
    <script src="{{ asset('assets/js/custom/hotspot-overview.js') }}"></script>

    <!-- HRM Dashboard JS -->
    <script src="{{ asset('assets/js/hrm-dashboard.js') }}"></script>
@endsection
