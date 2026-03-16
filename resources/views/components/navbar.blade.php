<nav class="bg-black text-white border-b border-gray-700">
    <div class="container mx-auto flex justify-between items-center px-6 py-4">

        <!-- Logo -->
        <a href="{{ route('home') }}" class="text-2xl font-bold tracking-wide hover:text-gray-300 transition">
            نوادر
        </a>

        <!-- Links -->
        <div class="flex items-center gap-8 text-lg font-medium">

            <x-nav-link href="/">
                الشيوخ
            </x-nav-link>

            <x-nav-link href="/">
                الاقتراحات
            </x-nav-link>

            @guest
                <a href="/login" class="text-blue-500  hover:text-blue-900 transition">
                    تسجيل الدخول
                </a>
                <a href="/register" class="text-blue-500  hover:text-blue-900 transition">
                    تسجيل حساب
                </a>
            @endguest

        </div>
    </div>
</nav>