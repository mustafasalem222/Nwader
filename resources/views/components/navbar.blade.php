<nav class="bg-black text-white border-b border-gray-800">
    <div class="container mx-auto flex justify-between items-center px-6 py-4">

        <a href="{{ route('home') }}" class="text-2xl font-bold tracking-wide hover:text-gray-300 transition">
            نوادر
        </a>

        <div class="flex items-center gap-6 text-base font-medium">

            <x-nav-link href="/">
                الشيوخ
            </x-nav-link>

            <x-nav-link href="/">
                الاقتراحات
            </x-nav-link>

            @guest
                <a href="{{ route('login') }}" class="text-blue-500 hover:text-blue-400 transition">
                    تسجيل الدخول
                </a>
                <a href="{{ route('register') }}" class="text-blue-500 hover:text-blue-400 transition">
                    تسجيل حساب
                </a>
            @endguest

            @auth
                @if (auth()->user()->is_admin)
                    <a href="{{ route('admin.dashboard') }}" class="text-gray-300 hover:text-white transition text-sm">
                        لوحة التحكم
                    </a>
                @endif

                <div x-data="{ open: false }" class="relative">

                    <button @click="open = !open"
                        class="flex items-center gap-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-full transition">
                        @if(auth()->user()->provider_avatar)
                            <img src="{{ auth()->user()->provider_avatar }}" alt="{{ auth()->user()->name }}"
                                class="w-9 h-9 rounded-full object-cover border border-gray-700 hover:border-blue-500 transition">
                        @else
                            <div
                                class="w-9 h-9 rounded-full bg-gray-800 flex items-center justify-center border border-gray-700 text-gray-400 font-bold hover:border-blue-500 transition">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                        @endif
                    </button>

                    <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="transform opacity-100 scale-100"
                        x-transition:leave-end="transform opacity-0 scale-95"
                        class="absolute left-0 mt-3 w-48 rounded-md shadow-lg py-1 bg-black border border-gray-800 z-50"
                        style="display: none;">
                        <a href="/" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-900 hover:text-white transition">
                            الملف الشخصي
                        </a>

                        @if (auth()->user()->is_admin)
                            <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-900 hover:text-white transition">
                                لوحة التحكم
                            </a>
                        @endif

                        <div class="border-t border-gray-800"></div>

                        <form method="POST" action="/logout">
                            @csrf
                            <button type="submit"
                                class="block w-full text-right px-4 py-2 text-sm text-red-500 hover:bg-gray-900 transition">
                                تسجيل الخروج
                            </button>
                        </form>
                    </div>
                </div>
            @endauth

        </div>
    </div>
</nav>
