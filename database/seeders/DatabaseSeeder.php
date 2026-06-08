<?php

namespace Database\Seeders;

use App\Models\Sheikh;
use App\Models\Telaawah;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        if (!User::where('email', 'test@example.com')->exists()) {
            User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);
        }

        $sheikhs = [
            ['name' => 'محمد صديق المنشاوي', 'image_url' => null, 'description' => 'أحد أعلام القراءة في مصر والعالم الإسلامي، يتميز بصوت عذب وأداء رفيع'],
            ['name' => 'عبد الباسط عبد الصمد', 'image_url' => null, 'description' => 'قارئ قرآن مصري، يعد أحد أشهر قراء القرآن في العالم الإسلامي'],
            ['name' => 'محمود خليل الحصري', 'image_url' => null, 'description' => 'قارئ قرآن مصري أجاد القراءات العشر، تميز بدقة التلاوة وجودة الأداء'],
            ['name' => 'محمد رفعت', 'image_url' => null, 'description' => 'قارئ قرآن مصري من أعلام القراءة في الوطن العربي، يتميز بصوت شجي'],
            ['name' => 'مصطفى إسماعيل', 'image_url' => null, 'description' => 'قارئ قرآن مصري، تميز بصوته العذب وأسلوبه الفريد في التلاوة'],
            ['name' => 'ناصر القطامي', 'image_url' => null, 'description' => 'إمام وقارئ قرآن سعودي، يتميز بصوت جميل وأداء مؤثر'],
            ['name' => 'سعود الشريم', 'image_url' => null, 'description' => 'إمام الحرم المكي سابقاً، أحد أبرز قراء المملكة العربية السعودية'],
            ['name' => 'مشاري العفاسي', 'image_url' => null, 'description' => 'قارئ كويتي ومنشد إسلامي، تميز بصوته العذب وأدائه المتميز'],
        ];

        $telawahNames = [
            'سورة الفاتحة', 'سورة يس', 'سورة الرحمن', 'سورة الواقعة', 'سورة الملك',
            'سورة الكهف', 'سورة مريم', 'سورة طه', 'سورة الحجرات', 'سورة الصافات',
            'سورة الدخان', 'سورة النبأ', 'سورة الإنسان', 'سورة القيامة', 'سورة المطففين',
            'سورة الزمر', 'سورة غافر', 'سورة فصلت', 'سورة القمر', 'سورة الحاقة',
        ];

        foreach ($sheikhs as $s) {
            $sheikh = Sheikh::firstOrCreate(['name' => $s['name']], $s);

            for ($i = 0; $i < 3; $i++) {
                Telaawah::create([
                    'sheikh_id' => $sheikh->id,
                    'name' => $telawahNames[array_rand($telawahNames)],
                    'audio_url' => 'https://example.com/audio/' . fake()->uuid() . '.mp3',
                    'description' => 'تلاوة نادرة للشيخ ' . $sheikh->name,
                ]);
            }
        }
    }
}
