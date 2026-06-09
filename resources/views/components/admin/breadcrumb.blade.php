@props(['items' => []])

<nav class="flex items-center gap-2 text-sm text-gray-500 mb-6">
    @foreach ($items as $item)
        @if (isset($item['url']))
            <a href="{{ $item['url'] }}" class="hover:text-white transition">{{ $item['label'] }}</a>
            <span>/</span>
        @else
            <span class="text-gray-300">{{ $item['label'] }}</span>
        @endif
    @endforeach
</nav>
