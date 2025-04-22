@props(['id', 'maxWidth', 'preventModalClose'])

@php
    $id = $id ?? md5($attributes->wire('model'));
    $preventModalClose = $preventModalClose ?? false;

    $maxWidth = [
        'sm' => 'sm:max-w-sm',
        'md' => 'sm:max-w-md',
        'lg' => 'sm:max-w-lg',
        'xl' => 'sm:max-w-xl',
        '2xl' => 'sm:max-w-2xl',
        '3xl' => 'sm:max-w-2xl lg:max-w-3xl',
        '4xl' => 'sm:max-w-2xl lg:max-w-4xl',
        '5xl' => 'sm:max-w-2xl lg:max-w-5xl',
    ][$maxWidth ?? '2xl'];
@endphp

<div x-data="{ show: false }" x-on:close.stop="show = false"
    x-on:keydown.escape.window="show = @js($preventModalClose)" x-show="show" x-on:open-modal.window="show = true"
    x-on:close-modal.window="show = false" id="{{ $id }}"
    class="jetstream-modal fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50" style="display: none;">

    <div x-show="show" class="fixed inset-0 transform transition-all" x-on:click="show = @js($preventModalClose)"
        x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <div class="absolute inset-0 bg-gray-500 dark:bg-gray-900 opacity-75"></div>
    </div>

    <div x-show="show"
        class="relative mb-6 bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full {{ $maxWidth }} sm:mx-auto"
        x-trap.inert.noscroll="show" x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">

        <!-- Close (X) Button -->
        <button @click="$dispatch('close-modal')"
            class="absolute top-2 right-2 z-[999] py-1 px-2 !text-[1.5rem] !font-medium text-[#8c9097] dark:text-white/50 hover:text-defaulttextcolor">
            <span class="sr-only">Close</span>
            <i class="ri-close-line"></i>
        </button>

        {{ $slot }}
    </div>
</div>
