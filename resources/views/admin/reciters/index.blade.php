<x-admin.layouts.app title="الشيوخ">
    <x-admin.breadcrumb :items="[['label' => 'الشيوخ']]" />

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-white">الشيوخ</h1>
        <a href="{{ route('admin.reciters.create') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition text-sm">
            + إضافة شيخ
        </a>
    </div>

    @livewire('admin.reciters-table')
</x-admin.layouts.app>
