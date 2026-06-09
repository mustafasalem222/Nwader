<div>
    <div class="mb-6">
        <div class="flex gap-3 flex-wrap">
            <input type="text" placeholder="بحث عن تلاوة أو شيخ..."
                wire:model.live.debounce.500ms="search"
                class="flex-1 min-w-[200px] bg-gray-800 text-white border border-gray-700 rounded-lg px-4 py-2.5 text-sm placeholder-gray-500 focus:outline-none focus:border-blue-500 transition">

            <select wire:model.live="sheikhId"
                class="bg-gray-800 text-white border border-gray-700 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:border-blue-500 transition">
                <option value="">كل الشيوخ</option>
                @foreach ($sheikhs as $sheikh)
                    <option value="{{ $sheikh->id }}">{{ $sheikh->name }}</option>
                @endforeach
            </select>

            @if ($search || $sheikhId)
                <button wire:click="$set('search', ''); $set('sheikhId', '')" class="text-sm text-gray-500 hover:text-white transition">إلغاء</button>
            @endif
        </div>
    </div>

    <div class="bg-gray-900/60 border border-gray-800 rounded-2xl overflow-hidden">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-800 text-right">
                    <th class="px-6 py-4 text-sm text-gray-400 font-medium">الاسم</th>
                    <th class="px-6 py-4 text-sm text-gray-400 font-medium">الشيخ</th>
                    <th class="px-6 py-4 text-sm text-gray-400 font-medium">الوصف</th>
                    <th class="px-6 py-4 text-sm text-gray-400 font-medium">التاريخ</th>
                    <th class="px-6 py-4 text-sm text-gray-400 font-medium"></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($telaawat as $telaawah)
                    <tr wire:key="telaawah-{{ $telaawah->id }}" class="border-b border-gray-800 last:border-0 hover:bg-gray-800/30 transition">
                        <td class="px-6 py-4 text-white font-medium">{{ $telaawah->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-400">{{ $telaawah->sheikh->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate">{{ $telaawah->description ?? '—' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $telaawah->created_at->format('Y/m/d') }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.telaawat.edit', $telaawah) }}" class="px-3 py-1.5 text-xs text-blue-500 hover:text-blue-400 transition">تعديل</a>
                                <button
                                    @click="window.dispatchEvent(new CustomEvent('open-delete-modal', { detail: { title: 'حذف تلاوة', message: 'هل أنت متأكد من حذف تلاوة &quot;{{ $telaawah->name }}&quot; لـ {{ $telaawah->sheikh->name }}؟', action: '{{ route('admin.telaawat.destroy', $telaawah) }}' } }))"
                                    class="px-3 py-1.5 text-xs text-red-500 hover:text-red-400 transition">
                                    حذف
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-500">لا توجد تلاوات بعد</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if ($telaawat->hasPages())
            <div class="px-6 py-4 border-t border-gray-800">
                {{ $telaawat->links() }}
            </div>
        @endif
    </div>
</div>
