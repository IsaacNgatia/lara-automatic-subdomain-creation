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
                Hotspot Transactions
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
                Hotspot Transactions
            </li>
        </ol>
    </div>
    <!-- Page Header Close -->
    <!-- Start::Sent All Transactions Table -->
    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12">
            <div class="box">
                <div class="box-header">
                    <h5 class="box-title">All Transactions Table</h5>
                </div>
                <div class="box-body space-y-3">
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
                    <div class="overflow-hidden table-bordered">
                        <div id="transactions-table" class="ti-custom-table ti-striped-table ti-custom-table-hover"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End::Sent All Transactions Table -->
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
    <script src="{{ asset('assets/js/custom/hotspot-transactions.js') }}"></script>
@endsection
