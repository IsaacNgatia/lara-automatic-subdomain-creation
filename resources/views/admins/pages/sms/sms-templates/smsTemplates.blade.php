@extends('admins.layouts.master')

@section('styles')
@endsection

@section('content')
    <!-- Page Header -->
    <div class="block justify-between page-header md:flex">
        <div>
            <h3
                class="!text-defaulttextcolor dark:!text-defaulttextcolor/70 dark:text-white dark:hover:text-white text-[1.125rem] font-semibold">
                Sms Templates
            </h3>
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
                Sms Templates
            </li>
        </ol>
    </div>
    <!-- Page Header Close -->
    <!-- Start:: Sms Templates -->
    <livewire:admins.sms.sms-template lazy />
    <!-- End:: Sms Templates -->
@endsection

@section('scripts')
    <script>
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
@endsection
