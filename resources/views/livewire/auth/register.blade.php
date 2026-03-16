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

    return redirect('/dashboard');
  }

  public function render()
  {
    return view('livewire.auth.register');
  }
};
?>
<div>
  <div class="flex items-center justify-center min-h-screen">

    <div class="w-full max-w-md bg-gray-900/90 shadow-2xl rounded-2xl p-8 space-y-6">

      <!-- Title -->
      <div class="text-center space-y-2">
        <h2 class="text-2xl font-bold text-white">
          إنشاء حساب
        </h2>

        <p class="text-sm text-gray-300">
          أنشئ حسابك للمتابعة
        </p>
      </div>

      <!-- Form -->
      <form wire:submit="register" class="space-y-4">

        <flux:input label="الاسم" variant="outline" wire:model="name" placeholder="ادخل اسمك"
          class="bg-gray-800 text-white border-gray-700 placeholder-gray-400" />

        <flux:input type="email" label="الإيميل" wire:model="email" placeholder="example@email.com"
          class="bg-gray-800 text-white border-gray-700 placeholder-gray-400" />

        <flux:input type="password" label="كلمة المرور" wire:model="password"
          class="bg-gray-800 text-white border-gray-700 placeholder-gray-400" />

        <flux:input type="password" label="تأكيد كلمة المرور" wire:model="password_confirmation"
          class="bg-gray-800 text-white border-gray-700 placeholder-gray-400" />

        <flux:button variant="primary" type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white">
          إنشاء الحساب
        </flux:button>

      </form>

      <!-- Divider -->
      <div class="flex items-center gap-3">
        <div class="flex-1 h-px bg-gray-700"></div>
        <span class="text-sm text-gray-400">أو</span>
        <div class="flex-1 h-px bg-gray-700"></div>
      </div>

      <!-- Google Button -->
      <a href="{{ route('auth.redirect', 'google') }}"
        class="flex items-center justify-center gap-2 border border-gray-600 rounded-lg py-2 hover:bg-gray-800 transition text-white">

        <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="w-5 h-5">

        التسجيل باستخدام Google

      </a>
      <a href="{{ route('auth.redirect', 'facebook') }}"
        class="flex items-center justify-center gap-2 border border-gray-600 rounded-lg py-2 hover:bg-gray-800 transition text-white">

        <img src="https://www.svgrepo.com/show/475647/facebook-color.svg" class="w-5 h-5">

        التسجيل باستخدام Facebook

      </a>

    </div>

  </div>
</div>