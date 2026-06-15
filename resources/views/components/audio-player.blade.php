<div
    x-data="playerUI"
    x-show="$store.player.track"
    x-cloak
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="translate-y-full"
    x-transition:enter-end="translate-y-0"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="translate-y-0"
    x-transition:leave-end="translate-y-full"
    class="fixed bottom-0 inset-x-0 z-50 bg-gray-900/95 border-t border-gray-800 backdrop-blur-md"
    tabindex="0"
    dir="ltr"
>
    <div class="max-w-7xl mx-auto px-4 py-3">
        {{-- Progress Bar with time labels --}}
        <div class="relative mb-3 select-none">
            <div class="flex justify-between text-xs text-gray-400 tabular-nums mb-1.5">
                <span x-text="$store.player.formatTime($store.player.currentTime)">00:00</span>
                <span x-text="$store.player.formatTime($store.player.duration)">00:00</span>
            </div>
            <div
                x-ref="progressTrack"
                class="relative h-2 bg-gray-700 rounded-full cursor-pointer group"
                @click="clickTrack"
                @mousedown="startDrag"
                @touchstart.prevent="startDrag"
            >
                <div
                    class="absolute inset-y-0 left-0 bg-blue-600 rounded-full group-hover:bg-blue-500 transition-colors"
                    :style="progressStyle()"
                    :class="{ 'transition-all duration-75': !dragging }"
                ></div>

                <div
                    class="absolute top-1/2 -translate-y-1/2 -ml-4 w-8 h-8 flex items-center justify-center"
                    :style="{ ...thumbStyle(), cursor: dragging ? 'grabbing' : 'grab' }"
                >
                    <div
                        class="w-5 h-5 rounded-full bg-white border-2 border-blue-600 shadow-md transition-transform duration-150 group-hover:scale-110"
                        :class="{ 'scale-125': dragging, 'opacity-60 group-hover:opacity-100': !dragging }"
                    ></div>
                </div>
            </div>
        </div>

        {{-- Global drag end listeners --}}
        <div
            @mousemove.window="onDrag"
            @mouseup.window="stopDrag"
            @touchmove.window="onDrag"
            @touchend.window="stopDrag"
            @touchcancel.window="stopDrag"
        ></div>

        {{-- Controls Row --}}
        <div class="flex items-center justify-between gap-4 flex-wrap">
            {{-- Left: Track Info --}}
            <div class="flex items-center gap-3 min-w-0 flex-1">
                <div class="w-10 h-10 rounded-lg bg-gray-800 flex items-center justify-center flex-shrink-0">
                    <template x-if="$store.player.loading">
                        <svg class="w-5 h-5 text-gray-400 animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                        </svg>
                    </template>
                    <template x-if="!$store.player.loading">
                        <svg class="w-5 h-5 text-blue-500" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M8 5v14l11-7z"/>
                        </svg>
                    </template>
                </div>
                <div class="min-w-0">
                    <a :href="$store.player.track?.show_url || '#'"
                        wire:navigate
                        class="text-sm font-medium text-white truncate block hover:text-blue-400 transition-colors"
                        x-text="$store.player.track?.name"></a>
                    <p class="text-xs text-gray-500 truncate" x-text="$store.player.track?.sheikh_name"></p>
                </div>
            </div>

            {{-- Center: Playback Controls --}}
            <div class="flex items-center gap-1">
                <button @click="$store.player.skip(-30)"
                    class="text-gray-400 hover:text-white hover:scale-110 transition-all p-2 rounded-full hover:bg-gray-800 cursor-pointer"
                    title="Rewind 30s">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12.066 11.2a1 1 0 000 1.6l5.334 4A1 1 0 0019 16V8a1 1 0 00-1.6-.8l-5.333 4zM4.066 11.2a1 1 0 000 1.6l5.334 4A1 1 0 0011 16V8a1 1 0 00-1.6-.8l-5.334 4z"/>
                    </svg>
                </button>

                <button @click="$store.player.skip(-10)"
                    class="text-gray-400 hover:text-white hover:scale-110 transition-all p-1.5 rounded-full hover:bg-gray-800 cursor-pointer"
                    title="-10s">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12.066 11.2a1 1 0 000 1.6l5.334 4A1 1 0 0019 16V8a1 1 0 00-1.6-.8l-5.333 4zM4.066 11.2a1 1 0 000 1.6l5.334 4A1 1 0 0011 16V8a1 1 0 00-1.6-.8l-5.334 4z"/>
                    </svg>
                </button>

                <button @click="$store.player.toggle()"
                    class="w-11 h-11 rounded-full bg-blue-600 hover:bg-blue-500 hover:scale-110 active:scale-95 flex items-center justify-center text-white transition-all cursor-pointer mx-1"
                    title="Play / Pause">
                    <template x-if="$store.player.playing">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M6 4h4v16H6V4zm8 0h4v16h-4V4z"/>
                        </svg>
                    </template>
                    <template x-if="!$store.player.playing">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M8 5v14l11-7z"/>
                        </svg>
                    </template>
                </button>

                <button @click="$store.player.skip(10)"
                    class="text-gray-400 hover:text-white hover:scale-110 transition-all p-1.5 rounded-full hover:bg-gray-800 cursor-pointer"
                    title="+10s">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.933 12.8a1 1 0 000-1.6L6.6 7.2A1 1 0 005 8v8a1 1 0 001.6.8l5.333-4zM19.933 12.8a1 1 0 000-1.6l-5.333-4A1 1 0 0013 8v8a1 1 0 001.6.8l5.333-4z"/>
                    </svg>
                </button>

                <button @click="$store.player.skip(30)"
                    class="text-gray-400 hover:text-white hover:scale-110 transition-all p-2 rounded-full hover:bg-gray-800 cursor-pointer"
                    title="Forward 30s">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.933 12.8a1 1 0 000-1.6L6.6 7.2A1 1 0 005 8v8a1 1 0 001.6.8l5.333-4zM19.933 12.8a1 1 0 000-1.6l-5.333-4A1 1 0 0013 8v8a1 1 0 001.6.8l5.333-4z"/>
                    </svg>
                </button>
            </div>

            {{-- Right: Volume + Speed + Actions --}}
            <div class="flex items-center gap-3">
                {{-- Volume --}}
                <div class="flex items-center gap-1.5">
                    <button @click="$store.player.setVolume($store.player.volume > 0 ? 0 : 1)"
                        class="text-gray-400 hover:text-white transition-colors p-1 rounded hover:bg-gray-800 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"/>
                        </svg>
                    </button>
                    <input type="range" min="0" max="1" step="0.05"
                        :value="$store.player.volume"
                        @input="$store.player.setVolume(parseFloat($event.target.value))"
                        class="w-16 h-1 accent-blue-600 cursor-pointer">
                </div>

                {{-- Speed --}}
                <select :value="$store.player.speed" @change="$store.player.setSpeed(parseFloat($event.target.value))"
                    class="bg-gray-800 text-gray-300 text-xs border border-gray-700 rounded px-1.5 py-1 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500/50 transition-all cursor-pointer hover:bg-gray-700">
                    <option value="0.5">0.5x</option>
                    <option value="0.75">0.75x</option>
                    <option value="1">1x</option>
                    <option value="1.25">1.25x</option>
                    <option value="1.5">1.5x</option>
                    <option value="2">2x</option>
                </select>

                {{-- Download --}}
                <button @click="downloadTrack"
                    class="text-gray-400 hover:text-white hover:scale-110 transition-all p-1.5 rounded-full hover:bg-gray-800 cursor-pointer"
                    title="Download">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                </button>

                {{-- Share --}}
                <button @click="
                    if (navigator.share) {
                        navigator.share({ title: $store.player.track?.name, text: $store.player.track?.name + ' - ' + $store.player.track?.sheikh_name, url: $store.player.track?.share_url });
                    } else {
                        navigator.clipboard.writeText($store.player.track?.share_url).then(() => { $el.innerText = 'Copied'; setTimeout(() => $el.innerHTML = `...`, 2000); });
                    }
                " class="text-gray-400 hover:text-white hover:scale-110 transition-all p-1.5 rounded-full hover:bg-gray-800 cursor-pointer" title="Share">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Error --}}
        <template x-if="$store.player.error">
            <div class="mt-2 text-xs text-red-500 text-center" x-text="$store.player.error"></div>
        </template>
    </div>
</div>
