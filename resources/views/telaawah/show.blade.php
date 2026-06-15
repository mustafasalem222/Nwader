<x-layouts.app :title="$telaawah->name">
    <div class="max-w-4xl mx-auto space-y-8">
        {{-- Recitation Card --}}
        <div class="bg-gray-900/50 border border-gray-800 rounded-2xl p-8 animate-fade-in">
            <div class="flex items-start gap-5">
                <button @click="$store.player.play({
                    id: {{ $telaawah->id }},
                    name: @js($telaawah->name),
                    audio_url: @js($telaawah->audio_url),
                    sheikh_name: @js($telaawah->sheikh_name),
                    download_url: @js($telaawah->download_url),
                    share_url: @js($telaawah->share_url),
                })"
                    class="w-14 h-14 rounded-full bg-blue-600 hover:bg-blue-700 flex items-center justify-center flex-shrink-0 transition"
                    :class="{ 'bg-green-600': $store.player.track?.id === {{ $telaawah->id }} && $store.player.playing }">
                    <template x-if="$store.player.track?.id === {{ $telaawah->id }} && $store.player.playing">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M6 4h4v16H6V4zm8 0h4v16h-4V4z"/>
                        </svg>
                    </template>
                    <template x-if="!($store.player.track?.id === {{ $telaawah->id }} && $store.player.playing)">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M8 5v14l11-7z"/>
                        </svg>
                    </template>
                </button>
                <div class="min-w-0 flex-1">
                    <h1 class="text-3xl font-bold text-white">{{ $telaawah->name }}</h1>
                    <p class="text-lg text-gray-400 mt-1">{{ $telaawah->sheikh_name }}</p>
                    @if ($telaawah->description)
                        <p class="text-gray-500 mt-4 leading-relaxed">{{ $telaawah->description }}</p>
                    @endif
                    <div class="flex items-center gap-4 mt-4 text-sm text-gray-600">
                        <span>{{ $telaawah->created_at->format('Y/m/d') }}</span>
                        <a :href="$store.player.track?.id === {{ $telaawah->id }} ? $store.player.track?.download_url : '{{ $telaawah->download_url }}'"
                            class="text-blue-500 hover:text-blue-400 transition flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                            </svg>
                            تحميل
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- More from same sheikh --}}
        @if ($moreFromSheikh->isNotEmpty())
            <section>
                <h2 class="text-2xl font-bold text-white mb-6">المزيد من {{ $telaawah->sheikh_name }}</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach ($moreFromSheikh as $related)
                        <a href="{{ route('telaawah.show', $related) }}" wire:navigate
                            class="bg-gray-900/50 border border-gray-800 rounded-xl p-5 hover:border-gray-600 transition group">
                            <div class="flex items-center gap-4">
                                <button @click.prevent="$store.player.play({
                                    id: {{ $related->id }},
                                    name: @js($related->name),
                                    audio_url: @js($related->audio_url),
                                    sheikh_name: @js($related->sheikh_name),
                                    download_url: @js($related->download_url),
                                    share_url: @js($related->share_url),
                                })"
                                    class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center flex-shrink-0 border border-gray-700 hover:border-blue-500 transition"
                                    :class="{ 'border-blue-500 bg-blue-600/20': $store.player.track?.id === {{ $related->id }} && $store.player.playing }">
                                    <template x-if="$store.player.track?.id === {{ $related->id }} && $store.player.playing">
                                        <svg class="w-4 h-4 text-blue-500" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M6 4h4v16H6V4zm8 0h4v16h-4V4z"/>
                                        </svg>
                                    </template>
                                    <template x-if="!($store.player.track?.id === {{ $related->id }} && $store.player.playing)">
                                        <svg class="w-4 h-4 text-blue-500" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M8 5v14l11-7z"/>
                                        </svg>
                                    </template>
                                </button>
                                <div class="min-w-0">
                                    <p class="text-white font-medium truncate">{{ $related->name }}</p>
                                    <p class="text-sm text-gray-500 truncate">{{ $related->sheikh_name }}</p>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif
    </div>
</x-layouts.app>
