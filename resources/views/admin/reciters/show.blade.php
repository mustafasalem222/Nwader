<x-admin.layouts.app :title="$reciter->name">
    <x-admin.breadcrumb :items="[
        ['label' => 'الشيوخ', 'url' => route('admin.reciters.index')],
        ['label' => $reciter->name],
    ]" />

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Sheikh Info Card --}}
        <div class="lg:col-span-1">
            <div class="bg-gray-900/60 border border-gray-800 rounded-2xl p-6 space-y-4">
                <div class="flex flex-col items-center text-center gap-3">
                    <div class="w-24 h-24 rounded-full bg-gray-800 flex items-center justify-center text-2xl text-gray-400 font-bold overflow-hidden">
                        @if ($reciter->image_url)
                            <img src="{{ $reciter->image_url }}" alt="" class="w-full h-full object-cover">
                        @else
                            {{ mb_substr($reciter->name, 0, 1) }}
                        @endif
                    </div>
                    <h2 class="text-xl font-bold text-white">{{ $reciter->name }}</h2>
                    <span class="text-sm text-gray-500">{{ $reciter->telaawat->count() }} تلاوات</span>
                </div>

                @if ($reciter->description)
                    <p class="text-sm text-gray-400 text-center leading-relaxed">{{ $reciter->description }}</p>
                @endif

                <div class="flex items-center justify-center gap-3 pt-2">
                    <a href="{{ route('admin.reciters.edit', $reciter) }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition text-sm">
                        تعديل
                    </a>
                    <button
                        @click="window.dispatchEvent(new CustomEvent('open-delete-modal', { detail: { title: 'حذف شيخ', message: 'هل أنت متأكد من حذف &quot;{{ $reciter->name }}&quot;؟ سيتم حذف جميع تلاواته أيضاً.', action: '{{ route('admin.reciters.destroy', $reciter) }}' } }))"
                        class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition text-sm">
                        حذف
                    </button>
                </div>
            </div>
        </div>

        {{-- Telaawat List --}}
        <div class="lg:col-span-2">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-white">التلاوات</h3>
                <a href="{{ route('admin.telaawat.create', ['sheikh_id' => $reciter->id]) }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition text-sm">
                    + إضافة تلاوة
                </a>
            </div>

            @forelse ($reciter->telaawat as $telaawah)
                <div class="bg-gray-900/60 border border-gray-800 rounded-2xl p-5 mb-3 flex items-center justify-between gap-4">
                    <div class="min-w-0">
                        <h4 class="text-white font-medium">{{ $telaawah->name }}</h4>
                        @if ($telaawah->description)
                            <p class="text-sm text-gray-500 mt-1 truncate">{{ $telaawah->description }}</p>
                        @endif
                        <span class="text-xs text-gray-600 mt-1 block">{{ $telaawah->created_at->format('Y/m/d') }}</span>
                    </div>
                    <div class="flex items-center gap-2 flex-shrink-0">
                        <a href="{{ route('admin.telaawat.edit', $telaawah) }}" class="px-3 py-1.5 text-xs text-blue-500 hover:text-blue-400 transition">تعديل</a>
                        <button
                            @click="window.dispatchEvent(new CustomEvent('open-delete-modal', { detail: { title: 'حذف تلاوة', message: 'هل أنت متأكد من حذف تلاوة &quot;{{ $telaawah->name }}&quot;?', action: '{{ route('admin.telaawat.destroy', $telaawah) }}' } }))"
                            class="px-3 py-1.5 text-xs text-red-500 hover:text-red-400 transition">
                            حذف
                        </button>
                    </div>
                </div>
            @empty
                <div class="bg-gray-900/60 border border-gray-800 rounded-2xl p-10 text-center">
                    <p class="text-gray-500">لا توجد تلاوات لهذا الشيخ بعد</p>
                </div>
            @endforelse
        </div>

    </div>
</x-admin.layouts.app>
