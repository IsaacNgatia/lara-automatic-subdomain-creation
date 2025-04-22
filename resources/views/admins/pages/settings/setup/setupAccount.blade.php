@extends('admins.layouts.master')

@section('styles')
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="{{ asset('build/assets/libs/swiper/swiper-bundle.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
@endsection

@section('content')
    <!-- Start::row-2 -->
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
