@extends('admins.layouts.master')

@section('styles')
@endsection

@section('content')
    <!-- Page Header -->
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
                </a>
            </li>
        </ol>
    </div>
    <!-- Page Header Close -->

    <!-- Start::Main Grid -->
    <div class="grid grid-cols-12 gap-x-6 gap-y-6">
        <!-- Row 1 -->
        <div class="lg:col-span-6 col-span-12">
            {{-- Collections Section --}}
            <livewire:admins.dashboard.view-collections />
        </div>
        <div class="lg:col-span-6 col-span-12">
            {{-- Subscriptions + Users Summary --}}
            <livewire:admins.dashboard.users-summary />
        </div>

        <!-- Row 2 -->
        <div class="lg:col-span-6 col-span-12">
            {{-- Earnings Report Graph --}}
            <livewire:admins.dashboard.earnings-report />
        </div>
        <div class="lg:col-span-6 col-span-12">
            {{-- Subscription Chart --}}
            <livewire:admins.dashboard.subscription-chart />
        </div>
    </div>
    <!-- End::Main Grid -->

    <!-- Start::row-2 -->
    <div class="grid grid-cols-12 gap-x-6">
        <!-- Most Recent Transactions -->
        <livewire:admins.dashboard.recent-transactions />
        <!-- Admin Logs -->
        <livewire:admins.dashboard.admin-logs />
        <!-- Monthly Debit And Credit -->
        <livewire:admins.dashboard.debit-credit />
    </div>
    <!-- End::row-2 -->

    <!-- Start::row-3 -->
    <div class="grid grid-cols-12 gap-x-6">
        <div class="xl:col-span-12 col-span-12">
            {{-- Tickets Table --}}
            <livewire:admins.dashboard.tickets-table />
        </div>
    </div>

    <!-- End::row-3 -->
@endsection

@section('scripts')
    <!-- Apex Charts JS -->
    <script src="{{ asset('build/assets/libs/apexcharts/apexcharts.min.js') }}"></script>

    <!-- HRM Dashboard JS -->
    <script src="{{ asset('assets/js/courses-dashboard.js') }}"></script>
    @vite('resources/assets/js/custom/dashboard/earnings-report.js')
    @vite('resources/assets/js/custom/dashboard/subscription-chart.js')
    @vite('resources/assets/js/custom/dashboard/yearly-debit-credit.js')
@endsection
