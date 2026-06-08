<?php

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

new class extends Component {
    public $email;
    public $password;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required',
    ];

    public function login()
    {
        $this->validate();

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            return redirect()->intended('/');
        }

        session()->flash('error', 'البريد الإلكتروني أو كلمة المرور غير صحيحة');
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
};
?>

<div class="flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md bg-gray-900/90 shadow-2xl rounded-2xl p-8 space-y-6">

        <div class="text-center space-y-2">
            <h2 class="text-2xl md:text-3xl font-bold text-white">
                تسجيل الدخول
            </h2>
            <p class="text-base md:text-lg text-gray-400">
                مرحباً بعودتك
            </p>
        </div>

        @if (session('error'))
            <div class="bg-red-900/50 border border-red-700 text-red-300 rounded-lg px-4 py-3 text-base text-center">
                {{ session('error') }}
            </div>
        @endif

        <form wire:submit="login" class="space-y-5">
            <x-input label="الإيميل" type="email" placeholder="example@email.com" wire:model="email" />
            <x-input label="كلمة المرور" type="password" wire:model="password" />
            <x-button>تسجيل الدخول</x-button>
        </form>

        <div class="flex items-center gap-3">
            <div class="flex-1 h-px bg-gray-700"></div>
            <span class="text-base text-gray-500">أو</span>
            <div class="flex-1 h-px bg-gray-700"></div>
        </div>

        <a href="{{ route('auth.redirect', 'google') }}"
            class="flex items-center justify-center gap-2 border border-gray-600 rounded-lg py-3 hover:bg-gray-800 transition text-white text-base md:text-lg">
            <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="w-5 h-5">
            تسجيل الدخول باستخدام Google
        </a>
        <a href="{{ route('auth.redirect', 'facebook') }}"
            class="flex items-center justify-center gap-2 border border-gray-600 rounded-lg py-3 hover:bg-gray-800 transition text-white text-base md:text-lg">
            <img src="https://www.svgrepo.com/show/475647/facebook-color.svg" class="w-5 h-5">
            تسجيل الدخول باستخدام Facebook
        </a>

        <p class="text-center text-base md:text-lg text-gray-500">
            ليس لديك حساب؟
            <a href="{{ route('register') }}" class="text-blue-500 hover:text-blue-400 transition">
                إنشاء حساب
            </a>
        </p>
    </div>
</div>
