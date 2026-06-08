<x-layouts.app>
    @section('title', 'الرئيسية')

    {{-- Hero --}}
    <section class="relative min-h-[80vh] flex items-center justify-center text-center px-4 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-b from-blue-900/20 via-black to-black pointer-events-none"></div>
        <div class="relative z-10 max-w-3xl animate-fade-in">
            <h1 class="text-5xl md:text-7xl font-bold text-white mb-6 leading-tight">
                كنوز التلاوات <span class="text-blue-500">النادرة</span>
            </h1>
            <p class="text-lg md:text-xl text-gray-400 mb-10 leading-relaxed">
                نوادر هو منصة مخصصة للحفاظ على تلاوات القرآن النادرة، وتوثيقها، وفهرستها، والبحث فيها بسهولة
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="#sheikhs"
                    class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition text-lg font-medium">
                    استعرض الشيوخ
                </a>
                <a href="#about"
                    class="px-8 py-3 border border-gray-600 hover:border-gray-500 text-gray-300 hover:text-white rounded-lg transition text-lg font-medium">
                    عن المنصة
                </a>
            </div>
        </div>
    </section>

    {{-- Stats --}}
    <section class="py-16 px-4">
        <div class="max-w-5xl mx-auto grid grid-cols-2 md:grid-cols-3 gap-6 text-center">
            <div class="bg-gray-900/60 border border-gray-800 rounded-2xl p-8 animate-fade-in-up animation-delay-200">
                <div class="text-4xl font-bold text-blue-500 mb-2">{{ $totalSheikhs }}</div>
                <div class="text-gray-400 text-lg">شيخ</div>
            </div>
            <div class="bg-gray-900/60 border border-gray-800 rounded-2xl p-8 animate-fade-in-up animation-delay-400">
                <div class="text-4xl font-bold text-blue-500 mb-2">{{ $totalTelaawat }}</div>
                <div class="text-gray-400 text-lg">تلاوة</div>
            </div>
            <div class="bg-gray-900/60 border border-gray-800 rounded-2xl p-8 animate-fade-in-up animation-delay-600 md:col-span-1 col-span-2">
                <div class="text-4xl font-bold text-blue-500 mb-2">{{ $totalSheikhs + $totalTelaawat }}</div>
                <div class="text-gray-400 text-lg">محتوى</div>
            </div>
        </div>
    </section>

    {{-- About --}}
    <section id="about" class="py-20 px-4">
        <div class="max-w-4xl mx-auto">
            <h2 class="text-3xl md:text-5xl font-bold text-white text-center mb-6 animate-fade-in">حول المنصة</h2>
            <div class="w-24 h-1 bg-blue-600 mx-auto rounded-full mb-10 animate-scale-in"></div>
            <div class="space-y-6 text-gray-300 text-lg leading-relaxed animate-fade-in-up animation-delay-200">
                <p>
                    <span class="text-white font-bold">نوادر</span> هو مشروع يهدف إلى الحفاظ على التلاوات القرآنية النادرة
                    التي قد تندثر مع الزمن، وتوفيرها للأجيال القادمة بصورة منظمة وسهلة الوصول.
                </p>
                <p>
                    نوفر مكتبة متكاملة من التلاوات لكبار القراء حول العالم الإسلامي، مع إمكانية البحث والتصفح
                    والاستماع بجودة عالية. كل تلاوة موثقة بمصدرها وقارئها لضمان الأمانة العلمية.
                </p>
            </div>
        </div>
    </section>

    {{-- Sheikhs --}}
    <section id="sheikhs" class="py-20 px-4">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-3xl md:text-5xl font-bold text-white text-center mb-6 animate-fade-in">الشيوخ</h2>
            <div class="w-24 h-1 bg-blue-600 mx-auto rounded-full mb-4"></div>
            <p class="text-gray-400 text-center mb-12 text-lg">تصفح تلاوات أشهر قراء العالم الإسلامي</p>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @forelse ($sheikhs as $index => $sheikh)
                    <div class="bg-gray-900/50 border border-gray-800 rounded-2xl p-6 hover:border-gray-600 transition group animate-fade-in-up"
                        style="animation-delay: {{ ($index % 8) * 100 }}ms">
                        <div class="w-20 h-20 rounded-full bg-gray-800 mx-auto mb-4 flex items-center justify-center border-2 border-gray-700 group-hover:border-blue-500 transition overflow-hidden">
                            @if ($sheikh->image_url)
                                <img src="{{ $sheikh->image_url }}" alt="{{ $sheikh->name }}"
                                    class="w-full h-full object-cover">
                            @else
                                <span class="text-2xl text-gray-500 font-bold">{{ mb_substr($sheikh->name, 0, 1) }}</span>
                            @endif
                        </div>
                        <h3 class="text-xl font-bold text-white text-center mb-2">{{ $sheikh->name }}</h3>
                        <p class="text-sm text-gray-400 text-center mb-4 leading-relaxed">{{ $sheikh->description }}</p>
                        <div class="flex items-center justify-center gap-2 text-sm text-gray-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2z"/>
                            </svg>
                            <span>{{ $sheikh->telaawat_count ?? $sheikh->telaawat->count() }} تلاوة</span>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-20">
                        <p class="text-gray-500 text-xl">لا يوجد شيوخ بعد</p>
                        <p class="text-gray-600 mt-2">قم بتشغيل البذور لإضافة بيانات</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- Telaawat --}}
    <section id="telaawat" class="py-20 px-4">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-3xl md:text-5xl font-bold text-white text-center mb-6 animate-fade-in">أحدث التلاوات</h2>
            <div class="w-24 h-1 bg-blue-600 mx-auto rounded-full mb-4"></div>
            <p class="text-gray-400 text-center mb-12 text-lg">تلاوات نادرة مضافة حديثاً للمنصة</p>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($telaawat as $index => $telaawah)
                    <div class="bg-gray-900/50 border border-gray-800 rounded-2xl p-6 hover:border-gray-600 transition group animate-fade-in-up"
                        style="animation-delay: {{ ($index % 6) * 100 }}ms">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-12 h-12 rounded-full bg-gray-800 flex items-center justify-center border border-gray-700 group-hover:border-blue-500 transition flex-shrink-0">
                                <span class="text-blue-500">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M8 5v14l11-7z"/>
                                    </svg>
                                </span>
                            </div>
                            <div class="min-w-0">
                                <h3 class="text-lg font-bold text-white truncate">{{ $telaawah->name }}</h3>
                                <p class="text-sm text-gray-500 truncate">{{ $telaawah->sheikh->name }}</p>
                            </div>
                        </div>
                        <p class="text-sm text-gray-400 leading-relaxed mb-4">{{ $telaawah->description }}</p>
                        <div class="flex items-center justify-between text-xs text-gray-600">
                            <span>{{ $telaawah->created_at->diffForHumans() }}</span>
                            <span class="text-blue-500 group-hover:text-blue-400 transition flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                استماع
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-20">
                        <p class="text-gray-500 text-xl">لا توجد تلاوات بعد</p>
                        <p class="text-gray-600 mt-2">قم بتشغيل البذور لإضافة بيانات</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="border-t border-gray-800 py-8 px-4 mt-10">
        <div class="max-w-7xl mx-auto text-center text-gray-600 text-sm">
            <p>نوادر &mdash; الحفاظ على التلاوات القرآنية النادرة</p>
        </div>
    </footer>
</x-layouts.app>
