<div>
    <div class="mb-6">
        <input type="text" placeholder="بحث عن شيخ..."
            wire:model.live.debounce.500ms="search"
            class="w-full bg-gray-800 text-white border border-gray-700 rounded-lg px-4 py-2.5 text-sm placeholder-gray-500 focus:outline-none focus:border-blue-500 transition">

        @if ($search)
            <div class="mt-2">
                <button wire:click="$set('search', '')" class="text-sm text-gray-500 hover:text-white transition">إلغاء البحث</button>
            </div>
        @endif
    </div>

    <div class="bg-gray-900/60 border border-gray-800 rounded-2xl overflow-hidden">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-800 text-right">
                    <th class="px-6 py-4 text-sm text-gray-400 font-medium">الاسم</th>
                    <th class="px-6 py-4 text-sm text-gray-400 font-medium">الوصف</th>
                    <th class="px-6 py-4 text-sm text-gray-400 font-medium">التلاوات</th>
                    <th class="px-6 py-4 text-sm text-gray-400 font-medium">التاريخ</th>
                    <th class="px-6 py-4 text-sm text-gray-400 font-medium"></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($reciters as $reciter)
                    <tr wire:key="reciter-{{ $reciter->id }}" class="border-b border-gray-800 last:border-0 hover:bg-gray-800/30 transition">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center text-sm text-gray-400 font-bold overflow-hidden flex-shrink-0">
                                    @if ($reciter->image_url)
                                        <img src="{{ $reciter->image_url }}" alt="" class="w-full h-full object-cover">
                                    @else
                                        {{ mb_substr($reciter->name, 0, 1) }}
                                    @endif
                                </div>
                                <a href="{{ route('admin.reciters.show', $reciter) }}" class="text-white font-medium hover:text-blue-500 transition">{{ $reciter->name }}</a>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-400 max-w-xs truncate">{{ $reciter->description ?? '—' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $reciter->telaawat_count }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $reciter->created_at->format('Y/m/d') }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.reciters.show', $reciter) }}" class="px-3 py-1.5 text-xs text-gray-400 hover:text-white transition">عرض</a>
                                <a href="{{ route('admin.reciters.edit', $reciter) }}" class="px-3 py-1.5 text-xs text-blue-500 hover:text-blue-400 transition">تعديل</a>
                                <button
                                    @click="window.dispatchEvent(new CustomEvent('open-delete-modal', { detail: { title: 'حذف شيخ', message: 'هل أنت متأكد من حذف &quot;{{ $reciter->name }}&quot;؟ سيتم حذف جميع تلاواته أيضاً.', action: '{{ route('admin.reciters.destroy', $reciter) }}' } }))"
                                    class="px-3 py-1.5 text-xs text-red-500 hover:text-red-400 transition">
                                    حذف
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-500">لا يوجد شيوخ بعد</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if ($reciters->hasPages())
            <div class="px-6 py-4 border-t border-gray-800">
                {{ $reciters->links() }}
            </div>
        @endif
    </div>
</div>
