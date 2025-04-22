@extends('admins.layouts.master')

@section('styles')
@endsection

@section('content')
    <!-- Page Header -->
    <div class="block justify-between page-header md:flex">
        <div>
            <h3
                class="!text-defaulttextcolor dark:!text-defaulttextcolor/70 dark:text-white dark:hover:text-white text-[1.125rem] font-semibold">
                Wallet Transactions
            </h3>
        </div>
        <ol class="flex items-center whitespace-nowrap min-w-0">
            <li class="text-[0.813rem] ps-[0.5rem]">
                <a class="flex items-center text-primary hover:text-primary dark:text-primary truncate"
                    href="javascript:void(0);">
                    Payments
                    <i
                        class="ti ti-chevrons-right flex-shrink-0 text-[#8c9097] dark:text-white/50 px-[0.5rem] overflow-visible rtl:rotate-180"></i>
                </a>
            </li>
            <li class="text-[0.813rem] text-defaulttextcolor font-semibold hover:text-primary dark:text-[#8c9097] dark:text-white/50 "
                aria-current="page">
                Wallet Transactions
            </li>
        </ol>
    </div>
    <!-- Page Header Close -->
    <!-- Start:: Manual And Recurring VOuchers -->
    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12">
            <div class="box custom-box">
                <div class="box-header justify-between">
                    <div class="box-title">
                        Wallet Transactions Table
                    </div>

                </div>
                <div class="box-body space-y-3">
                    <div class="flex justify-between">
                        <div class="download-data">
                            <button type="button" class="ti-btn btn-wave ti-btn-primary" id="download-csv">Download
                                CSV</button>
                            <button type="button" class="ti-btn btn-wave ti-btn-primary" id="download-json">Download
                                JSON</button>
                            <button type="button" class="ti-btn btn-wave ti-btn-primary" id="download-xlsx">Download
                                XLSX</button>
                            <button type="button" class="ti-btn btn-wave ti-btn-primary" id="download-pdf">Download
                                PDF</button>
                            <button type="button" class="ti-btn btn-wave ti-btn-primary" id="download-html">Download
                                HTML</button>
                        </div>
                        <div>
                            <div class="relative">
                                <input type="text" id="hs-search-box-with-loading-1" name="hs-search-box-with-loading-1"
                                    class="ti-form-input rounded-sm ps-11 focus:z-10" placeholder="Input search">
                                <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-4">
                                    <div class="animate-spin inline-block w-4 h-4 border-[3px] border-current border-t-transparent text-primary rounded-full"
                                        role="status" aria-label="loading">
                                        <span class="sr-only">Loading...</span>
                                    </div>
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
                                    <th scope="col" class="text-start">Reference Number</th>
                                    <th scope="col" class="text-start">MSISDN</th>
                                    <th scope="col" class="text-start">Time</th>
                                    <th scope="col" class="text-start">Status</th>
                                    <th scope="col" class="text-start">Balance</th>
                                    <th scope="col" class="text-start">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b border-defaultborder">
                                    <td>1</td>

                                    <td>Isaac Ngatia</td>
                                    <td>12.12.12.12</td>
                                    <td>kimosukuro@gmail.com</td>
                                    <td>Router 1</td>
                                    <td>5GB</td>
                                    <td>6Hrs</td>
                                    <td><span class="badge bg-success/10 text-success">cleared</span></td>
                                    <td>3000</td>

                                    <td>
                                        <div class="hstack flex gap-2 flex-wrap">
                                            <div class="hs-tooltip ti-main-tooltip [--placement:top]">
                                                <button type="button" aria-label="anchor"
                                                    class="hs-tooltip-toggle me-4 text-danger text-[.875rem] leading-none">
                                                    <i class="ri-delete-bin-5-line"></i>
                                                    <span
                                                        class="hs-tooltip-content ti-main-tooltip-content !py-1 !px-2 !bg-danger !text-xs !font-medium !text-white shadow-sm dark:bg-slate-700"
                                                        role="tooltip">
                                                        Delete Transaction
                                                    </span>
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="border-b border-defaultborder">
                                    <td>1</td>
                                    <td>Isaac Ngatia</td>
                                    <td>12.12.12.12</td>
                                    <td>hasimna2132@gmail.com</td>
                                    <td>Router 1</td>
                                    <td>5GB</td>
                                    <td>6Hrs</td>
                                    <td><span class="badge bg-warning text-dark">pending</span></td>
                                    <td>3000</td>

                                    <td>
                                        <div class="hstack flex gap-2 flex-wrap">
                                            <div class="hs-tooltip ti-main-tooltip [--placement:top]">
                                                <button type="button" aria-label="anchor"
                                                    class="hs-tooltip-toggle me-4 text-danger text-[.875rem] leading-none">
                                                    <i class="ri-delete-bin-5-line"></i>
                                                    <span
                                                        class="hs-tooltip-content ti-main-tooltip-content !py-1 !px-2 !bg-danger !text-xs !font-medium !text-white shadow-sm dark:bg-slate-700"
                                                        role="tooltip">
                                                        Delete Transaction
                                                    </span>
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="border-b border-defaultborder">
                                    <td>1</td>
                                    <td>Isaac Ngatia</td>
                                    <td>12.12.12.12</td>
                                    <td>azimokhan421@gmail.com</td>
                                    <td>Router 1</td>
                                    <td>10GB</td>
                                    <td>6Hrs</td>
                                    <td><span class="badge bg-success/10 text-success">cleared</span></td>
                                    <td>3000</td>
                                    <td>
                                        <div class="hstack flex gap-2 flex-wrap">
                                            <div class="hs-tooltip ti-main-tooltip [--placement:top]">
                                                <button type="button" aria-label="anchor"
                                                    class="hs-tooltip-toggle me-4 text-danger text-[.875rem] leading-none">
                                                    <i class="ri-delete-bin-5-line"></i>
                                                    <span
                                                        class="hs-tooltip-content ti-main-tooltip-content !py-1 !px-2 !bg-danger !text-xs !font-medium !text-white shadow-sm dark:bg-slate-700"
                                                        role="tooltip">
                                                        Delete Transaction
                                                    </span>
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="py-4 px-3">
                        <div class="flex ">
                            <div class="flex space-x-4 items-center mb-3">
                                <label class="w-32 text-sm font-medium ">Per Page</label>
                                <select
                                    class="bg-gray-50 border border-gray-300  text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
                                    <option value="5">5</option>
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection
