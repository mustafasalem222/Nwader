<x-admin.layouts.app title="لوحة التحكم">
    <x-admin.breadcrumb />

    <h1 class="text-3xl font-bold text-white mb-8">لوحة التحكم</h1>

    {{-- Stats --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <x-admin.stat-card title="إجمالي الشيوخ" :value="$totalReciters">
            <x-slot:icon>
                <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            </x-slot:icon>
        </x-admin.stat-card>

        <x-admin.stat-card title="إجمالي التلاوات" :value="$totalTelaawat">
            <x-slot:icon>
                <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
            </x-slot:icon>
        </x-admin.stat-card>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        {{-- Latest Recitations --}}
        <div class="bg-gray-900/60 border border-gray-800 rounded-2xl p-6">
            <h2 class="text-xl font-bold text-white mb-4">أحدث التلاوات</h2>
            @if ($latestTelaawat->count())
                <div class="space-y-3">
                    @foreach ($latestTelaawat as $telaawah)
                        <div class="flex items-center justify-between py-2 border-b border-gray-800 last:border-0">
                            <div>
                                <p class="text-white font-medium">{{ $telaawah->name }}</p>
                                <p class="text-sm text-gray-500">{{ $telaawah->sheikh->name }}</p>
                            </div>
                            <span class="text-xs text-gray-600">{{ $telaawah->created_at->diffForHumans() }}</span>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-8">لا توجد تلاوات بعد</p>
            @endif
        </div>

        {{-- Top Reciters --}}
        <div class="bg-gray-900/60 border border-gray-800 rounded-2xl p-6">
            <h2 class="text-xl font-bold text-white mb-4">أكثر الشيوخ تلاوات</h2>
            @if ($topReciters->count())
                <div class="space-y-3">
                    @foreach ($topReciters as $reciter)
                        <div class="flex items-center justify-between py-2 border-b border-gray-800 last:border-0">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-gray-800 flex items-center justify-center text-sm text-gray-400 font-bold">
                                    {{ mb_substr($reciter->name, 0, 1) }}
                                </div>
                                <p class="text-white font-medium">{{ $reciter->name }}</p>
                            </div>
                            <span class="text-sm text-gray-500">{{ $reciter->telaawat_count }} تلاوة</span>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-8">لا يوجد شيوخ بعد</p>
            @endif
        </div>
    </div>
</x-admin.layouts.app>
