@props(['type' => 'submit'])

<button type="{{ $type }}"
    {{ $attributes->merge(['class' => 'w-full bg-blue-600 hover:bg-blue-700 text-white text-lg md:text-xl font-medium rounded-lg px-6 py-3 transition']) }}>
    {{ $slot }}
</button>
