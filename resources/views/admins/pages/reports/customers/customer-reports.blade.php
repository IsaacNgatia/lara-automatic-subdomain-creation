@extends('admins.layouts.master')

@section('styles')
    <!-- Choices Css -->
    <link rel="stylesheet" href="{{ asset('build/assets/libs/choices.js/public/assets/styles/choices.min.css') }}">
    <!-- Tom Select Css -->
    <link rel="stylesheet" href="{{ asset('build/assets/libs/tom-select/css/tom-select.default.min.css') }}">
    <!-- FlatPickr CSS -->
    <link rel="stylesheet" href="{{ asset('build/assets/libs/flatpickr/flatpickr.min.css') }}">
@endsection

@section('content')
    <!-- Page Header -->
    <div class="block justify-between page-header md:flex">
        <div>
            <h3
                class="!text-defaulttextcolor dark:!text-defaulttextcolor/70 dark:text-white dark:hover:text-white text-[1.125rem] font-semibold">
                Customer Reports
            </h3>
        </div>
        <ol class="flex items-center whitespace-nowrap min-w-0">
            <li class="text-[0.813rem] ps-[0.5rem]">
                <a class="flex items-center text-primary hover:text-primary dark:text-primary truncate"
                    href="javascript:void(0);">
                    Reports
                    <i
                        class="ti ti-chevrons-right flex-shrink-0 text-[#8c9097] dark:text-white/50 px-[0.5rem] overflow-visible rtl:rotate-180"></i>
                </a>
            </li>
            <li class="text-[0.813rem] text-defaulttextcolor font-semibold hover:text-primary dark:text-[#8c9097] dark:text-white/50 "
                aria-current="page">
                Customer Reports
            </li>
        </ol>
    </div>
    <!-- Page Header Close -->
    <!-- Start:: Select Customer(s) -->
    <livewire:admins.reports.customers.select-customers />
@endsection

@section('scripts')
    <!-- Choices JS -->
    <script src="{{ asset('build/assets/libs/choices.js/public/assets/scripts/choices.min.js') }}"></script>
    @vite('resources/assets/js/choices.js')


    <!-- Tom Select JS -->
    {{-- <script src="{{ asset('build/assets/libs/tom-select/js/tom-select.complete.min.js') }}"></script> --}}
    {{-- @vite('resources/assets/js/tom-select.js') --}}

    <!-- Date & Time Picker JS -->
    <script src="{{ asset('build/assets/libs/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ asset('assets/js/custom/reports/select-customers.js') }}"></script>
@endsection
