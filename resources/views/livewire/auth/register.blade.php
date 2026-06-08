<?php

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

new class extends Component {
  public $name;
  public $email;
  public $password;
  public $password_confirmation;

  protected $rules = [
    'name' => 'required|min:3',
    'email' => 'required|email|unique:users,email',
    'password' => 'required|min:6|confirmed',
  ];

  public function register()
  {
    $this->validate();

    $user = User::create([
      'name' => $this->name,
      'email' => $this->email,
      'password' => Hash::make($this->password),
    ]);

    Auth::login($user);

    return redirect('/');
  }

  public function render()
  {
    return view('livewire.auth.register');
  }
};
?>
<div class="flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md bg-gray-900/90 shadow-2xl rounded-2xl p-8 space-y-6">

        <div class="text-center space-y-2">
            <h2 class="text-2xl md:text-3xl font-bold text-white">
                إنشاء حساب
            </h2>
            <p class="text-base md:text-lg text-gray-400">
                أنشئ حسابك للمتابعة
            </p>
        </div>

        <form wire:submit="register" class="space-y-5">
            <x-input label="الاسم" placeholder="ادخل اسمك" wire:model="name" />
            <x-input label="الإيميل" type="email" placeholder="example@email.com" wire:model="email" />
            <x-input label="كلمة المرور" type="password" wire:model="password" />
            <x-input label="تأكيد كلمة المرور" type="password" wire:model="password_confirmation" />
            <x-button>إنشاء الحساب</x-button>
        </form>

        <div class="flex items-center gap-3">
            <div class="flex-1 h-px bg-gray-700"></div>
            <span class="text-base text-gray-500">أو</span>
            <div class="flex-1 h-px bg-gray-700"></div>
        </div>

        <a href="{{ route('auth.redirect', 'google') }}"
            class="flex items-center justify-center gap-2 border border-gray-600 rounded-lg py-3 hover:bg-gray-800 transition text-white text-base md:text-lg">
            <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="w-5 h-5">
            التسجيل باستخدام Google
        </a>
        <a href="{{ route('auth.redirect', 'facebook') }}"
            class="flex items-center justify-center gap-2 border border-gray-600 rounded-lg py-3 hover:bg-gray-800 transition text-white text-base md:text-lg">
            <img src="https://www.svgrepo.com/show/475647/facebook-color.svg" class="w-5 h-5">
            التسجيل باستخدام Facebook
        </a>

        <p class="text-center text-base md:text-lg text-gray-500">
            لديك حساب بالفعل؟
            <a href="{{ route('login') }}" class="text-blue-500 hover:text-blue-400 transition">
                تسجيل الدخول
            </a>
        </p>
    </div>
</div>
