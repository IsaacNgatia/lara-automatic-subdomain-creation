@extends('admins.layouts.master')

@section('styles')
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="{{ asset('build/assets/libs/swiper/swiper-bundle.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
@endsection

@section('content')
    <!-- Page Header -->
    <div class="block justify-between page-header md:flex">
        <div>
            <h3
                class="!text-defaulttextcolor dark:!text-defaulttextcolor/70 dark:text-white dark:hover:text-white text-[1.125rem] font-semibold">
                Account Settings</h3>
        </div>
        <ol class="flex items-center whitespace-nowrap min-w-0">
            <li class="text-[0.813rem] ps-[0.5rem]">
                <a class="flex items-center text-primary hover:text-primary dark:text-primary truncate"
                    href="javascript:void(0);">
                    Settings
                    <i
                        class="ti ti-chevrons-right flex-shrink-0 text-[#8c9097] dark:text-white/50 px-[0.5rem] overflow-visible rtl:rotate-180"></i>
                </a>
            </li>
            <li class="text-[0.813rem] text-defaulttextcolor font-semibold hover:text-primary dark:text-[#8c9097] dark:text-white/50 "
                aria-current="page">
                Account Settings
            </li>
        </ol>
    </div>
    <!-- Page Header Close -->
    <!-- Start::row-2 -->
    <livewire:admins.settings.account.account-settings />
    <div class="grid grid-cols-12 sm:gap-x-6 space-y-2 sm:space-y-0">
        <div class="col-span-12">
            <div class="box">
                <div class="box-header justify-between">
                    <div class="box-title">
                        Payment Setup
                    </div>
                </div>
                @if ($payment_configs->where('is_working', true)->count() == 0)
                    <livewire:admins.settings.setup-payment-config />
                @endif
                @if ($payment_configs->count() > 0)
                    <livewire:admins.settings.setup-payment-table />
                @endif

            </div>
        </div>
        <div class="col-span-12">
            <div class="box">
                <div class="box-header justify-between">
                    <div class="box-title">
                        SMS Setup
                    </div>
                </div>
                @if ($sms_configs->where('is_working', true)->count() == 0)
                    <livewire:admins.settings.setup-sms-config />
                @endif
                @if ($sms_configs->count() > 0)
                    <livewire:admins.settings.setup-sms-table />
                @endif
            </div>
        </div>
    </div>
    <!-- End::row-2 -->
@endsection

@section('scripts')
    <!-- Jquery Cdn -->
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>

    <!-- Select2 Cdn -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- Internal Stepper JS -->
    {{-- @vite('resources/assets/js/stepper.js') --}}


    <!-- Internal Select-2.js -->
    @vite('resources/assets/js/select2.js')
@endsection
