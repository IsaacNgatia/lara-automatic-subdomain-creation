@props(['message'])

<div
    {{ $attributes->merge(['class' => 'absolute inset-0 bg-bodybg bg-opacity-75 flex items-center justify-center z-10 shadow-2xl']) }}>
    <div class="text-center">
        <i class="ri-loader-2-fill text-primary text-4xl animate-spin"></i>
        <p class="mt-2 text-primary font-semibold">{{ $message ?? 'Loading...' }}</p>
    </div>
</div>
