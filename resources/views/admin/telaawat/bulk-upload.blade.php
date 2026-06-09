<x-admin.layouts.app title="رفع متعدد">
    <x-admin.breadcrumb :items="[['label' => 'التلاوات', 'url' => route('admin.telaawat.index')], ['label' => 'رفع متعدد']]" />

    <div class="max-w-3xl mx-auto">
        <h1 class="text-3xl font-bold text-white mb-4">رفع تلاوات متعددة</h1>
        <p class="text-gray-400 mb-8 text-lg">يمكنك رفع عدة ملفات صوتية مرة واحدة وتعيينها لشيخ واحد</p>

        <form id="bulk-form" method="POST" action="{{ route('admin.telaawat.bulk-store') }}" enctype="multipart/form-data"
              x-data="{
                  files: [],
                  uploading: false,
                  addFiles(event) {
                      const newFiles = Array.from(event.target.files || event.dataTransfer.files);
                      this.files = [...this.files, ...newFiles].slice(0, 20);
                      event.target.value = '';
                  },
                  removeFile(index) {
                      this.files.splice(index, 1);
                  },
                  submitForm() {
                      if (this.files.length === 0) return;
                      this.uploading = true;
                      const form = document.getElementById('bulk-form');
                      const formData = new FormData(form);
                      fetch(form.action, {
                          method: 'POST',
                          body: formData,
                      }).then(r => {
                          if (r.redirected) window.location.href = r.url;
                      }).catch(() => { this.uploading = false; });
                  }
              }">
            @csrf

            <div class="space-y-6">
                <div>
                    <x-label>اختر الشيخ</x-label>
                    <select name="sheikh_id" required
                        class="w-full bg-gray-800 text-white border border-gray-700 rounded-lg px-4 py-3 text-base focus:outline-none focus:border-blue-500 transition">
                        <option value="">اختر الشيخ</option>
                        @foreach ($sheikhs as $sheikh)
                            <option value="{{ $sheikh->id }}">{{ $sheikh->name }}</option>
                        @endforeach
                    </select>
                    @error('sheikh_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <x-label>الملفات الصوتية</x-label>
                    <div @dragover.prevent @drop.prevent="addFiles($event)"
                         class="border-2 border-dashed border-gray-700 rounded-2xl p-10 text-center hover:border-blue-500/50 transition cursor-pointer"
                         @click="$refs.fileInput.click()">
                        <svg class="w-12 h-12 mx-auto text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                        <p class="text-gray-400 text-base">اسحب وأفلت الملفات هنا أو اضغط للاختيار</p>
                        <p class="text-gray-600 text-sm mt-1">MP3, WAV, OGG, FLAC, M4A — حد أقصى 50MB لكل ملف</p>
                        <input type="file" name="audios[]" multiple accept="audio/*" x-ref="fileInput" @change="addFiles($event)" class="hidden">
                    </div>
                </div>

                <template x-if="files.length > 0">
                    <div class="bg-gray-900/60 border border-gray-800 rounded-2xl p-4 space-y-2">
                        <p class="text-sm text-gray-400 mb-2" x-text="`${files.length} ملفات مختارة`"></p>
                        <template x-for="(file, index) in files" :key="index">
                            <div class="flex items-center justify-between py-2 border-b border-gray-800 last:border-0">
                                <div class="flex items-center gap-3 min-w-0">
                                    <svg class="w-4 h-4 text-blue-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2z"/>
                                    </svg>
                                    <span class="text-sm text-white truncate" x-text="file.name"></span>
                                    <span class="text-xs text-gray-600 flex-shrink-0" x-text="(file.size / 1024 / 1024).toFixed(1) + ' MB'"></span>
                                </div>
                                <button @click="removeFile(index)" class="text-red-500 hover:text-red-400 transition flex-shrink-0 p-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            </div>
                        </template>
                    </div>
                </template>

                <div class="flex items-center gap-3">
                    <button type="button" @click="submitForm" :disabled="files.length === 0 || uploading"
                        class="px-6 py-3 bg-blue-600 hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed text-white rounded-lg transition text-base"
                        x-text="uploading ? 'جاري الرفع...' : 'رفع الملفات'">
                    </button>
                    <a href="{{ route('admin.telaawat.index') }}" class="px-6 py-3 text-gray-400 hover:text-white transition text-base">إلغاء</a>
                </div>
            </div>
        </form>
    </div>
</x-admin.layouts.app>
