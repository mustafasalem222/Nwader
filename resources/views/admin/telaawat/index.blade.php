<x-admin.layouts.app title="التلاوات">
    <x-admin.breadcrumb :items="[['label' => 'التلاوات']]" />

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-white">التلاوات</h1>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.telaawat.bulk-upload') }}" class="px-4 py-2 bg-gray-800 hover:bg-gray-700 text-gray-300 rounded-lg transition text-sm border border-gray-700">
                رفع متعدد
            </a>
            <a href="{{ route('admin.telaawat.create') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition text-sm">
                + إضافة تلاوة
            </a>
        </div>
    </div>

    @livewire('admin.telaawat-table')
</x-admin.layouts.app>
