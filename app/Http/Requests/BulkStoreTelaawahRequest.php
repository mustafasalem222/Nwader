<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BulkStoreTelaawahRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'sheikh_id' => ['required', 'exists:sheikhs,id'],
            'audios' => ['required', 'array'],
            'audios.*' => ['file', 'mimes:mp3,wav,ogg,flac,m4a', 'max:51200'],
        ];
    }

    public function messages(): array
    {
        return [
            'sheikh_id.required' => 'يجب اختيار الشيخ',
            'sheikh_id.exists' => 'الشيخ المحدد غير موجود',
            'audios.required' => 'يجب رفع ملف واحد على الأقل',
            'audios.array' => 'بيانات غير صالحة',
            'audios.*.file' => 'الملفات المرفوعة يجب أن تكون ملفات صوتية',
            'audios.*.mimes' => 'الملفات الصوتية يجب أن تكون من نوع: mp3, wav, ogg, flac, m4a',
            'audios.*.max' => 'حجم الملف الصوتي يجب ألا يتجاوز 50 ميجابايت',
        ];
    }
}
