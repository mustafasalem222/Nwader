<x-admin.layouts.app title="إضافة تلاوة">
    <x-admin.breadcrumb :items="[['label' => 'التلاوات', 'url' => route('admin.telaawat.index')], ['label' => 'إضافة تلاوة']]" />

    <h1 class="text-3xl font-bold text-white mb-8">إضافة تلاوة جديدة</h1>

    <form method="POST" action="{{ route('admin.telaawat.store') }}" enctype="multipart/form-data" class="max-w-2xl space-y-6">
        @csrf

        <div>
            <x-label>الشيخ</x-label>
            <select name="sheikh_id" required
                class="w-full bg-gray-800 text-white border border-gray-700 rounded-lg px-4 py-3 text-base focus:outline-none focus:border-blue-500 transition">
                <option value="">اختر الشيخ</option>
                @foreach ($sheikhs as $sheikh)
                    <option value="{{ $sheikh->id }}" {{ old('sheikh_id') == $sheikh->id ? 'selected' : '' }}>{{ $sheikh->name }}</option>
                @endforeach
            </select>
            @error('sheikh_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <x-label>اسم التلاوة</x-label>
            <input type="text" name="name" value="{{ old('name') }}" required
                class="w-full bg-gray-800 text-white border border-gray-700 rounded-lg px-4 py-3 text-base placeholder-gray-500 focus:outline-none focus:border-blue-500 transition">
            @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <x-label>الوصف</x-label>
            <textarea name="description" rows="3"
                class="w-full bg-gray-800 text-white border border-gray-700 rounded-lg px-4 py-3 text-base placeholder-gray-500 focus:outline-none focus:border-blue-500 transition">{{ old('description') }}</textarea>
            @error('description') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <x-label>الملف الصوتي</x-label>
            <input type="file" name="audio" accept="audio/*"
                class="w-full text-sm text-gray-400 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:bg-gray-800 file:text-white file:text-sm hover:file:bg-gray-700 transition">
            @error('audio') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex items-center gap-3">
            <button type="submit" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition text-base">حفظ</button>
            <a href="{{ route('admin.telaawat.index') }}" class="px-6 py-3 text-gray-400 hover:text-white transition text-base">إلغاء</a>
        </div>
    </form>
</x-admin.layouts.app>
