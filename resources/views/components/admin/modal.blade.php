<div
    x-data="{ open: false, title: '', message: '', action: '' }"
    x-on:open-delete-modal.window="open = true; title = $event.detail.title; message = $event.detail.message; action = $event.detail.action"
    x-show="open"
    x-cloak
    class="fixed inset-0 z-50 flex items-center justify-center"
>
    {{-- Overlay --}}
    <div x-show="open" class="absolute inset-0 bg-black/60" @click="open = false"></div>

    {{-- Modal --}}
    <div x-show="open" class="relative bg-gray-900 border border-gray-800 rounded-2xl p-6 w-full max-w-md mx-4 shadow-2xl">
        <h3 class="text-xl font-bold text-white mb-2" x-text="title"></h3>
        <p class="text-gray-400 mb-6" x-text="message"></p>

        <div class="flex items-center justify-end gap-3">
            <button @click="open = false" class="px-4 py-2 text-gray-400 hover:text-white transition text-sm">إلغاء</button>
            <form method="POST" x-bind:action="action">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition text-sm">
                    تأكيد الحذف
                </button>
            </form>
        </div>
    </div>
</div>
