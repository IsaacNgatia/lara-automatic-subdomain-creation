@extends('admins.layouts.master')


@section('styles')
    <!-- Choices Css -->
    <link rel="stylesheet" href="{{ asset('build/assets/libs/choices.js/public/assets/styles/choices.min.css') }}">
    <!-- Tom Select Css -->
    <link rel="stylesheet" href="{{ asset('build/assets/libs/tom-select/css/tom-select.default.min.css') }}">
@endsection

@section('content')
    <!-- Page Header -->
    <div class="block justify-between page-header md:flex">
        <div>
            <h3
                class="!text-defaulttextcolor dark:!text-defaulttextcolor/70 dark:text-white dark:hover:text-white text-[1.125rem] font-semibold">
                Compose New SMS</h3>
        </div>
        <ol class="flex items-center whitespace-nowrap min-w-0">
            <li class="text-[0.813rem] ps-[0.5rem]">
                <a class="flex items-center text-primary hover:text-primary dark:text-primary truncate"
                    href="javascript:void(0);">
                    SMS
                    <i
                        class="ti ti-chevrons-right flex-shrink-0 text-[#8c9097] dark:text-white/50 px-[0.5rem] overflow-visible rtl:rotate-180"></i>
                </a>
            </li>
            <li class="text-[0.813rem] text-defaulttextcolor font-semibold hover:text-primary dark:text-[#8c9097] dark:text-white/50 "
                aria-current="page">
                Compose Sms
            </li>
        </ol>
    </div>
    <!-- Page Header Close -->

    <div class="col-span-12 xxl:!col-span-4">
        <div class="box">
            <div class="box-header">
                <h5 class="box-title">Compose New SMS</h5>
            </div>
            <div class="box-body">
                <div class="sm:border-b-2 border-gray-200 dark:border-white/10">
                    <nav class="-mb-0.5 sm:flex sm:space-x-6 rtl:space-x-reverse" role="tablist">
                        <a class="w-full sm:w-auto hs-tab-active:font-semibold hs-tab-active:border-primary hs-tab-active:text-primary py-4 px-1 inline-flex items-center gap-2 border-b-[3px] border-transparent text-sm whitespace-nowrap text-defaulttextcolor dark:text-[#8c9097] dark:text-white/50 hover:text-primary active"
                            href="javascript:void(0);" id="tab-with-users" data-hs-tab="#users-tab"
                            aria-controls="users-tab">
                            <i class="bi bi-people-fill"></i>
                            Send to Customers
                        </a>
                        <a class="w-full sm:w-auto hs-tab-active:font-semibold hs-tab-active:border-primary hs-tab-active:text-primary py-4 px-1 inline-flex items-center gap-2 border-b-[3px] border-transparent text-sm whitespace-nowrap text-defaulttextcolor dark:text-[#8c9097] dark:text-white/50 hover:text-primary"
                            href="javascript:void(0);" id="tab-with-mikrotiks" data-hs-tab="#mikrotiks-tab"
                            aria-controls="mikrotiks-tab">
                            <i class="bi bi-router-fill"></i>
                            Send to Mikrotik
                        </a>
                        <a class="w-full sm:w-auto hs-tab-active:font-semibold hs-tab-active:border-primary hs-tab-active:text-primary py-4 px-1 inline-flex items-center gap-2 border-b-[3px] border-transparent text-sm whitespace-nowrap text-defaulttextcolor dark:text-[#8c9097] dark:text-white/50 hover:text-primary"
                            href="javascript:void(0);" id="tab-with-locations" data-hs-tab="#location-tab"
                            aria-controls="location-tab">
                            <i class="bi bi-geo-fill"></i>
                            Send to Location
                        </a>
                        <a class="w-full sm:w-auto hs-tab-active:font-semibold hs-tab-active:border-primary hs-tab-active:text-primary py-4 px-1 inline-flex items-center gap-2 border-b-[3px] border-transparent text-sm whitespace-nowrap text-defaulttextcolor dark:text-[#8c9097] dark:text-white/50 hover:text-primary"
                            href="javascript:void(0);" id="tab-with-unregistered" data-hs-tab="#unregistered-tab"
                            aria-controls="unregistered-tab">
                            <i class="bi bi-person-fill-slash"></i>
                            Send to Unregistered
                        </a>
                    </nav>
                </div>
                <div class="mt-3">
                    <div id="users-tab" role="tabpanel" aria-labelledby="tab-with-users">
                        <!-- Start::Sms information -->
                        <livewire:admins.sms.compose-new.sms-info />
                        <!-- End::Sms information -->
                        <livewire:admins.sms.compose-new.send-to-user />
                    </div>
                    <div id="mikrotiks-tab" class="hidden" role="tabpanel" aria-labelledby="tab-with-mikrotiks">
                        <!-- Start::Sms information -->
                        <livewire:admins.sms.compose-new.sms-info />
                        <!-- End::Sms information -->
                        <livewire:admins.sms.compose-new.send-to-mikrotik />
                    </div>
                    <div id="location-tab" class="hidden" role="tabpanel" aria-labelledby="tab-with-locations">
                        <!-- Start::Sms information -->
                        <livewire:admins.sms.compose-new.sms-info />
                        <!-- End::Sms information -->
                        <livewire:admins.sms.compose-new.send-to-location />
                    </div>
                    <div id="unregistered-tab" class="hidden" role="tabpanel" aria-labelledby="tab-with-unregistered">
                        <!-- Start::Sms information -->
                        <livewire:admins.sms.compose-new.sms-info />
                        <!-- End::Sms information -->
                        <livewire:admins.sms.compose-new.send-to-unregistered />
                        {{-- <select id="choices-multiple-default" multiple>
                            </select> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('.single-user-checkbox');

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    if (this.checked) {
                        checkboxes.forEach(cb => {
                            if (cb !== this) {
                                cb.checked = false;
                            }
                        });
                    }
                });
            });
        });

        function insertAtCursor(value, elementId) {
            const textarea = document.getElementById(elementId);
            const startPos = textarea.selectionStart;
            const endPos = textarea.selectionEnd;
            const textBefore = textarea.value.substring(0, startPos);
            const textAfter = textarea.value.substring(endPos, textarea.value.length);

            // Insert the value at the caret position
            textarea.value = textBefore + value + textAfter;

            // Move the caret position after the inserted value
            textarea.selectionStart = textarea.selectionEnd = startPos + value.length;

            // Focus on the textarea again after insertion
            textarea.focus();

        }
    </script>

    <!-- Select JS -->

    <!-- Choices JS -->
    <script src="{{ asset('build/assets/libs/choices.js/public/assets/scripts/choices.min.js') }}"></script>
    <script src={{ asset('assets/js/custom/sms/compose-sms.js') }}></script>
@endsection
