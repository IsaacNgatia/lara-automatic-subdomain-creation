@extends('clients.layouts.master')

@section('styles')
    <!-- Apexcharts CSS -->
    <link rel="stylesheet" href="{{ asset('build/assets/libs/apexcharts/apexcharts.css') }}">
@endsection

@section('content')
    <!-- Page Header -->
    <div class="block justify-between page-header md:flex">
        <div>
            <h3
                class="!text-defaulttextcolor dark:!text-defaulttextcolor/70 dark:text-white dark:hover:text-white text-[1.125rem] font-semibold">
                Dashboard</h3>
        </div>
        <ol class="flex items-center whitespace-nowrap min-w-0">
            <li class="text-[0.813rem] ps-[0.5rem]">
                <a class="flex items-center text-primary hover:text-primary dark:text-primary truncate"
                    href="javascript:void(0);">
                    Dashboard
                    <i
                        class="ti ti-chevrons-right flex-shrink-0 text-[#8c9097] dark:text-white/50 px-[0.5rem] overflow-visible rtl:rotate-180"></i>
                </a>
            </li>
            <li class="text-[0.813rem] text-defaulttextcolor font-semibold hover:text-primary dark:text-[#8c9097] dark:text-white/50 "
                aria-current="page">
                Home
            </li>
        </ol>
    </div>
    <!-- Page Header Close -->

    <livewire:client.dashboard.client-dashboard />
@endsection

@section('scripts')
    <!-- Apex Charts JS -->
    <script src="{{ asset('build/assets/libs/apexcharts/apexcharts.min.js') }}"></script>

    <!-- HRM Dashboard JS -->
    @vite('resources/assets/js/personal-dashboard.js')
    <!-- Apex Charts JS -->
    <script src="{{ asset('build/assets/libs/apexcharts/apexcharts.min.js') }}"></script>

    <!---Used In Basic Area Chart-->
    <script src="{{ asset('build/assets/apexcharts-stock-prices.js') }}"></script>


    <!-- Used For Secection-Github Style Chart -->
    <script src="{{ asset('build/assets/apex-github-data.js') }}"></script>
    <!-- Internal Apex-Column-Charts JS -->
    @vite('resources/assets/js/apexcharts-column.js')

    <!-- Used For Irregular Time Series Chart -->
    <script src="{{ asset('build/assets/apexcharts-irregulardata.js') }}"></script>


    <script src="{{ asset('build/assets/libs/moment/moment.js') }}"></script>

    <!-- Internal Apex Area Charts JS -->
    @vite('resources/assets/js/apexcharts-area.js')
@endsection
