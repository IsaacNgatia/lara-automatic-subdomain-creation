@props(['options' => [], 'placeholderValue' => '', 'model', 'valueKey' => 'id', 'displayName'])

@php
    $uniqId = 'select' . uniqid();
@endphp
<div wire:ignore x-data x-init="$nextTick(() => {
    const choices = new Choices($refs.{{ $uniqId }}, {
        removeItems: true,
        removeItemButton: true,
        placeholderValue: '{{ $placeholderValue }}',
    })

    // Add this block to handle 'Send to All' checkbox
    @this.on('sendToGroup', (selectedOptions) => {
        if (selectedOptions[0].length > 0) {
            // Select all options
            choices.removeActiveItems();
            selectedOptions[0].map((option) => {
                choices.setChoiceByValue(`${option}`, true);
            });
        } else {
            // Deselect all options
            choices.removeActiveItems();
        }
    })
    //This is to reset the select component
    @this.on('reset-multi-select', () => {
        choices.removeActiveItems();
    })
})">
    <select x-ref="{{ $uniqId }}"
        wire:change="$set('{{ $model }}', [...$event.target.options].filter(option => option.selected).map(option => option.value))"
        {{ $attributes }} multiple>
        @foreach ($options as $option)
            <option value="{{ $option[$valueKey] }}">{{ $option[$displayName] }}</option>
        @endforeach
    </select>
</div>
@pushOnce('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
@endPushOnce
@pushOnce('scripts')
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
@endPushOnce
