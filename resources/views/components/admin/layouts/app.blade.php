<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم | {{ $title ?? '' }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Lalezar&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <style>
        body {
            font-family: 'Lalezar', sans-serif;
            background-color: #000;
            color: #fff;
        }
        .sidebar-link {
            transition: all 0.15s ease;
        }
        .sidebar-link:hover {
            background-color: rgba(59, 130, 246, 0.1);
        }
        .sidebar-link.active {
            background-color: rgba(59, 130, 246, 0.15);
            border-color: #3b82f6;
        }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body>
    <div class="min-h-screen flex" x-data="{ sidebarOpen: true }">
        {{-- Sidebar --}}
        <aside class="w-64 bg-black border-l border-gray-800 flex flex-col flex-shrink-0" x-show="sidebarOpen" x-cloak>
            <div class="h-16 flex items-center px-6 border-b border-gray-800">
                <a href="{{ route('admin.dashboard') }}" class="text-2xl font-bold text-white tracking-wide" wire:navigate>
                    نوادر
                </a>
            </div>

            <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1">
                <a href="{{ route('admin.dashboard') }}" wire:navigate
                    class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-gray-300 hover:text-white border-r-2 border-transparent {{ request()->routeIs('admin.dashboard') ? 'active text-white' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    <span>الرئيسية</span>
                </a>

                <a href="{{ route('admin.reciters.index') }}" wire:navigate
                    class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-gray-300 hover:text-white border-r-2 border-transparent {{ request()->routeIs('admin.reciters.*') ? 'active text-white' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    <span>الشيوخ</span>
                </a>

                <a href="{{ route('admin.telaawat.index') }}" wire:navigate
                    class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-gray-300 hover:text-white border-r-2 border-transparent {{ request()->routeIs('admin.telaawat.*') ? 'active text-white' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
                    <span>التلاوات</span>
                </a>
            </nav>

            <div class="border-t border-gray-800 p-4">
                <a href="{{ route('home') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-gray-500 hover:text-gray-300 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    <span>العودة للموقع</span>
                </a>
            </div>
        </aside>

        {{-- Main Content --}}
        <div class="flex-1 flex flex-col min-h-screen">
            {{-- Top Bar --}}
            <header class="h-16 bg-black border-b border-gray-800 flex items-center justify-between px-6">
                <button @click="sidebarOpen = !sidebarOpen" class="text-gray-400 hover:text-white transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>

                <div class="flex items-center gap-4">
                    <a href="{{ route('home') }}" class="text-sm text-gray-400 hover:text-white transition flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        العودة للموقع
                    </a>
                    <span class="text-gray-700">|</span>
                    <span class="text-sm text-gray-400">{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sm text-red-500 hover:text-red-400 transition">
                            تسجيل الخروج
                        </button>
                    </form>
                </div>
            </header>

            {{-- Page Content --}}
            <main class="flex-1 overflow-y-auto p-6 pb-28">
                {{ $slot }}
            </main>
        </div>
    </div>

    {{-- Audio Player (persistent across admin pages via wire:navigate) --}}
    <x-audio-player />

    {{-- Delete Modal --}}
    <x-admin.modal />

    @livewireScripts
</body>
</html>
