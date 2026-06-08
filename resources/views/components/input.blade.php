@props(['type' => 'text', 'placeholder' => '', 'label' => false])

<div class="space-y-1">
    @if ($label)
        <x-label>{{ $label }}</x-label>
    @endif
    <input type="{{ $type }}" placeholder="{{ $placeholder }}"
        {{ $attributes->merge(['class' => 'w-full bg-gray-800 text-white border border-gray-700 rounded-lg px-4 py-3 text-base md:text-lg placeholder-gray-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition']) }}>
</div>
