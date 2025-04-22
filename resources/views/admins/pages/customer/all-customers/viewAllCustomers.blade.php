@extends('admins.layouts.master')

@section('styles')
    <!-- Tabulator Css -->
    <link rel="stylesheet" href="{{ asset('build/assets/libs/tabulator-tables/css/tabulator.min.css') }}">

    <!-- Choices Css -->
    <link rel="stylesheet" href="{{ asset('build/assets/libs/choices.js/public/assets/styles/choices.min.css') }}">
@endsection

@section('content')
    <!-- Page Header -->
    <div class="block justify-between page-header md:flex">
        <div>
            <h3
                class="!text-defaulttextcolor dark:!text-defaulttextcolor/70 dark:text-white dark:hover:text-white text-[1.125rem] font-semibold">
                All Customers</h3>
        </div>
        <ol class="flex items-center whitespace-nowrap min-w-0">
            <li class="text-[0.813rem] ps-[0.5rem]">
                <a class="flex items-center text-primary hover:text-primary dark:text-primary truncate"
                    href="javascript:void(0);">
                    ISP
                    <i
                        class="ti ti-chevrons-right flex-shrink-0 text-[#8c9097] dark:text-white/50 px-[0.5rem] overflow-visible rtl:rotate-180"></i>
                </a>
            </li>
            <li class="text-[0.813rem] text-defaulttextcolor font-semibold hover:text-primary dark:text-[#8c9097] dark:text-white/50 "
                aria-current="page">
                All Customers
            </li>
        </ol>
    </div>
    <!-- Page Header Close -->
    <!-- Start:: row-2 -->
    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12">
            <div class="box custom-box">
                <div class="box-header justify-between">
                    <div class="box-title">
                        Customers Table
                    </div>

                </div>
                <div class="box-body">
                    <div class="sm:border-b border-gray-200 dark:border-white/10">
                        <nav class="sm:flex sm:space-x-2 sm:rtl:space-x-reverse" aria-label="Tabs" role="tablist">
                            <button type="button"
                                class="w-full sm:w-auto hs-tab-active:font-semibold hs-tab-active:border-primary hs-tab-active:text-primary py-4 px-1 inline-flex items-center gap-2 border-b-[3px] border-transparent text-sm whitespace-nowrap text-defaulttextcolor hover:text-primary dark:text-[#8c9097] dark:text-white/50 active"
                                id="tab-with-all-customers" data-hs-tab="#all-customers-tab"
                                aria-controls="all-customers-tab">
                                All Customers<span
                                    class="hs-tab-active:bg-primary hs-tab-active:text-white dark:hs-tab-active:bg-primary dark:hs-tab-active:text-white ms-1 py-0.5 px-1.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-black/20 dark:text-gray-300">{{ $customers }}</span>
                            </button>
                            <button type="button"
                                class="w-full sm:w-auto hs-tab-active:font-semibold hs-tab-active:border-primary hs-tab-active:text-primary py-4 px-1 inline-flex items-center gap-2 border-b-[3px] border-transparent text-sm whitespace-nowrap text-defaulttextcolor hover:text-primary dark:text-[#8c9097] dark:text-white/50"
                                id="tab-with-static-users" data-hs-tab="#static-users-tab" aria-controls="static-users-tab">
                                Static <span
                                    class="hs-tab-active:bg-primary hs-tab-active:text-white dark:hs-tab-active:bg-primary dark:hs-tab-active:text-white ms-1 py-0.5 px-1.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-black/20 dark:text-gray-300">{{ $staticUsersCount }}</span>
                            </button>
                            <button type="button"
                                class="w-full sm:w-auto hs-tab-active:font-semibold hs-tab-active:border-primary hs-tab-active:text-primary py-4 px-1 inline-flex items-center gap-2 border-b-[3px] border-transparent text-sm whitespace-nowrap text-defaulttextcolor hover:text-primary dark:text-[#8c9097] dark:text-white/50"
                                id="tab-with-pppoe-users" data-hs-tab="#pppoe-users-tab" aria-controls="pppoe-users-tab">
                                PPPoE <span
                                    class="hs-tab-active:bg-primary hs-tab-active:text-white dark:hs-tab-active:bg-primary dark:hs-tab-active:text-white ms-1 py-0.5 px-1.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-black/20 dark:text-gray-300">{{ $pppoeUsersCount }}</span>
                            </button>
                        </nav>
                    </div>

                    <div class="mt-3">
                        <div id="all-customers-tab" role="tabpanel" aria-labelledby="tab-with-all-customers">
                            <livewire:admins.customers.view-all-customers lazy />
                        </div>
                        <div id="static-users-tab" class="hidden" role="tabpanel" aria-labelledby="tab-with-static-users">
                            <livewire:admins.isp.view-all-static-users lazy />
                        </div>
                        <div id="pppoe-users-tab" class="hidden" role="tabpanel" aria-labelledby="tab-with-pppoe-users">
                            <livewire:admins.isp.view-all-pppoe-users lazy />
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
    <!-- End:: row-2 -->
@endsection

@section('scripts')
    <!-- Tabulator JS -->
    <script src="{{ asset('build/assets/libs/tabulator-tables/js/tabulator.min.js') }}"></script>

    <!-- Choices JS -->
    <script src="{{ asset('build/assets/libs/choices.js/public/assets/scripts/choices.min.js') }}"></script>

    <!-- XLXS JS -->
    <script src="{{ asset('build/assets/libs/xlsx/xlsx.full.min.js') }}"></script>

    <!-- JSPDF JS -->
    <script src="{{ asset('build/assets/libs/jspdf/jspdf.umd.min.js') }}"></script>
    <script src="{{ asset('build/assets/libs/jspdf-autotable/jspdf.plugin.autotable.min.js') }}"></script>

    <!-- Tabulator Custom JS -->
    <script src="{{ asset('assets/js/custom/all-static.js') }}"></script>
@endsection
