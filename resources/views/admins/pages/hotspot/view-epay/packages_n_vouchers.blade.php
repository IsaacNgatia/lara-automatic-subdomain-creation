@extends('admins.layouts.master')

@section('styles')
@endsection

@section('content')
    <!-- Page Header -->
    <div class="block justify-between page-header md:flex">
        <div>
            <h3
                class="!text-defaulttextcolor dark:!text-defaulttextcolor/70 dark:text-white dark:hover:text-white text-[1.125rem] font-semibold">
                View Epay Vouchers</h3>
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
                View Epay Vouchers
            </li>
        </ol>
    </div>
    <!-- Page Header Close -->
    <!-- Start:: Epay Packages -->
    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12">
            <div class="box custom-box">
                <div class="box-header justify-between">
                    <div class="box-title">
                        Epay Vouchers Table
                    </div>
                </div>
                <livewire:admins.hotspot.epay.hotspot-packages lazy />

            </div>
        </div>
    </div>
    {{-- End: :Epay Packages --}}

    {{-- Start: :Epay Vouchers --}}
    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12">
            <div class="box custom-box">
                <div class="box-header justify-between">
                    <div class="box-title">
                        Genarated Epay Vouchers Table
                    </div>

                </div>
                <livewire:admins.hotspot.epay.hotspot-vouchers lazy />

            </div>
        </div>
    </div>
    <!-- End:: Epay Vouchers -->
@endsection

@section('scripts')
@endsection
