@props(['type' => 'success', 'title' => null, 'message' => null])

@php
    // Determine styles based on the type
    $bgColor = $type === 'success' ? 'bg-success/20' : 'bg-danger/20';
    $borderColor = $type === 'success' ? 'border-success' : 'border-danger';
    $iconBgColor = $type === 'success' ? 'bg-success/50' : 'bg-danger/40';
    $iconBorderColor = $type === 'success' ? 'border-success' : 'border-danger';
    $iconSvgPath = $type === 'success'
        ? '<path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"/><path d="m9 12 2 2 4-4"/>'
        : '<path d="M18 6 6 18"/><path d="m6 6 12 12"/>';
@endphp

<div class="{{ $bgColor }} border-t-2 {{ $borderColor }} rounded-lg p-4 dark:{{ $bgColor }}" role="alert">
    <div class="flex">
        <div class="flex-shrink-0">
            <!-- Icon -->
            <span class="inline-flex justify-center items-center size-8 rounded-full border-1 {{ $iconBorderColor }} {{ $iconBgColor }} text-teal-800 dark:border-teal-900 dark:bg-teal-800 dark:text-teal-400">
                <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">{!! $iconSvgPath !!}</svg>
            </span>
            <!-- End Icon -->
        </div>
        <div class="ms-3">
            @if ($title)
                <h6 class="text-gray-800 font-semibold dark:text-white">{{ $title }}</h6>
            @endif
            @if ($message)
                <p class="text-sm text-gray-700 dark:text-gray-400">{{ $message }}</p>
            @endif
        </div>
    </div>
</div>
