@extends('clients.layouts.master')

@section('styles')
    <!-- Glightbox CSS -->
    <link rel="stylesheet" href="{{ asset('build/assets/libs/glightbox/css/glightbox.min.css') }}">
@endsection

@section('content')
    <!-- Page Header -->
    <div class="block justify-between page-header md:flex">
        <div>
            <h3
                class="!text-defaulttextcolor dark:!text-defaulttextcolor/70 dark:text-white dark:hover:text-white text-[1.125rem] font-semibold">
                Profile</h3>
        </div>
        <ol class="flex items-center whitespace-nowrap min-w-0">
            <li class="text-[0.813rem] ps-[0.5rem]">
                <a class="flex items-center text-primary hover:text-primary dark:text-primary truncate"
                    href="javascript:void(0);">
                    Pages
                    <i
                        class="ti ti-chevrons-right flex-shrink-0 text-[#8c9097] dark:text-white/50 px-[0.5rem] overflow-visible rtl:rotate-180"></i>
                </a>
            </li>
            <li class="text-[0.813rem] text-defaulttextcolor font-semibold hover:text-primary dark:text-[#8c9097] dark:text-white/50 "
                aria-current="page">
                Profile
            </li>
        </ol>
    </div>
    <!-- Page Header Close -->

    <!-- Start::row-1 -->
    <livewire:client.account.profile />
    
    <!--End::row-1 -->
    @endsection

    @section('scripts')
        <!-- Gallery JS -->
        <script src="{{ asset('build/assets/libs/glightbox/js/glightbox.min.js') }}"></script>

        <!-- Internal Profile JS -->
        @vite('resources/assets/js/profile.js')
    @endsection
