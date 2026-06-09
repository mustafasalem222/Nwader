<x-admin.layouts.app title="تعديل شيخ">
    <x-admin.breadcrumb :items="[['label' => 'الشيوخ', 'url' => route('admin.reciters.index')], ['label' => 'تعديل شيخ']]" />

    <h1 class="text-3xl font-bold text-white mb-8">تعديل: {{ $reciter->name }}</h1>

    <form method="POST" action="{{ route('admin.reciters.update', $reciter) }}" enctype="multipart/form-data" class="max-w-2xl space-y-6">
        @csrf
        @method('PUT')

        <div>
            <x-label>الاسم</x-label>
            <input type="text" name="name" value="{{ old('name', $reciter->name) }}" required
                class="w-full bg-gray-800 text-white border border-gray-700 rounded-lg px-4 py-3 text-base placeholder-gray-500 focus:outline-none focus:border-blue-500 transition">
            @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <x-label>الوصف</x-label>
            <textarea name="description" rows="3"
                class="w-full bg-gray-800 text-white border border-gray-700 rounded-lg px-4 py-3 text-base placeholder-gray-500 focus:outline-none focus:border-blue-500 transition">{{ old('description', $reciter->description) }}</textarea>
            @error('description') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <x-label>الصورة</x-label>
            @if ($reciter->image_url)
                <div class="mb-2">
                    <img src="{{ $reciter->image_url }}" alt="" class="w-20 h-20 rounded-full object-cover border border-gray-700">
                </div>
            @endif
            <input type="file" name="image" accept="image/*"
                class="w-full text-sm text-gray-400 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:bg-gray-800 file:text-white file:text-sm hover:file:bg-gray-700 transition">
            @error('image') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex items-center gap-3">
            <button type="submit" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition text-base">حفظ التغييرات</button>
            <a href="{{ route('admin.reciters.index') }}" class="px-6 py-3 text-gray-400 hover:text-white transition text-base">إلغاء</a>
        </div>
    </form>
</x-admin.layouts.app>
