<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTelaawahRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'sheikh_id' => ['required', 'exists:sheikhs,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'audio' => ['nullable', 'file', 'mimes:mp3,wav,ogg,flac,m4a', 'max:51200'],
        ];
    }

    public function messages(): array
    {
        return [
            'sheikh_id.required' => 'يجب اختيار الشيخ',
            'sheikh_id.exists' => 'الشيخ المحدد غير موجود',
            'name.required' => 'اسم التلاوة مطلوب',
            'name.max' => 'اسم التلاوة يجب ألا يتجاوز 255 حرفاً',
            'description.max' => 'الوصف يجب ألا يتجاوز 1000 حرف',
            'audio.file' => 'يجب رفع ملف صوتي',
            'audio.mimes' => 'الملف الصوتي يجب أن يكون من نوع: mp3, wav, ogg, flac, m4a',
            'audio.max' => 'حجم الملف الصوتي يجب ألا يتجاوز 50 ميجابايت',
        ];
    }
}
