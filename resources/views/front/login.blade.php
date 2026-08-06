@extends('front.layout.master')

@section('content')
    <section class="py-20 px-4">
        <div class="container max-w-md">
            <!-- Login Card -->
            @if($errors->any())
                <div class="relative mb-6 bg-red-500/10 dark:bg-red-500/20 backdrop-blur-xl p-5 rounded-3xl border border-red-500/30 dark:border-red-500/40 shadow-xl animate-shake">
                    <div class="flex items-start gap-4">
                        <!-- Icon -->
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 rounded-full bg-red-500/20 dark:bg-red-500/30 flex items-center justify-center">
                                <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="flex-1">
                            <h3 class="text-sm font-black text-red-700 dark:text-red-400 mb-2">خطا در اطلاعات وارد شده</h3>
                            <ul class="space-y-1">
                                @foreach($errors->all() as $error)
                                    <li class="text-xs text-red-600 dark:text-red-300 flex items-start gap-2">
                                        <span class="text-red-500 mt-0.5">•</span>
                                        <span>{{ $error }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <!-- Close Button -->
                        <button onclick="this.parentElement.parentElement.remove()"
                                class="flex-shrink-0 text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-200 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>
            @endif

            <div class="relative bg-white/60 dark:bg-gray-900/90 backdrop-blur-2xl p-8 sm:p-10 rounded-[2.5rem] border border-white/50 dark:border-gray-700/50 shadow-2xl">

                <div class="text-center mb-8">
                    <h2 class="text-2xl font-black text-gray-900 dark:text-white">ورود به حساب کاربری</h2>
                    <p class="text-gray-500 dark:text-gray-400 text-sm mt-2">خوش آمدید، لطفا اطلاعات خود را وارد کنید</p>
                </div>


                <form action="{{route('login.submit')}}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Phone Number -->
                    <div>
                        <label class="block text-[12px] font-bold text-gray-700 dark:text-gray-300 mb-2">شماره موبایل</label>
                        <input type="tel" name="mobile" placeholder="۰۹۱۲۰۰۰۰۰۰۰"
                               class="w-full px-5 py-4 rounded-2xl bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-400 outline-none transition-all text-gray-900 dark:text-white placeholder:text-gray-400 dark:placeholder:text-gray-500" required>
                    </div>

                    <!-- Password -->
                    <div>
                        <label class="block text-[12px] font-bold text-gray-700 dark:text-gray-300 mb-2">رمز عبور</label>
                        <div class="relative">
                            <input type="password" id="password" name="password" placeholder="••••••••"
                                   class="w-full px-5 py-4 rounded-2xl bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-400 outline-none transition-all text-gray-900 dark:text-white placeholder:text-gray-400 dark:placeholder:text-gray-500" required>

                            <!-- Toggle Button -->
                            <button type="button" onclick="togglePassword()"
                                    class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 dark:text-gray-500 dark:hover:text-gray-300 transition-colors">
                                <!-- Eye Icon (Show) -->
                                <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>

                                <!-- Eye Slash Icon (Hide) -->
                                <svg id="eye-slash-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="w-full py-4 rounded-2xl bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 text-white font-black transition-all duration-300 shadow-lg shadow-blue-600/20 active:scale-95">
                        ورود به سایت
                    </button>
                </form>

            </div>
        </div>
    </section>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            const eyeSlashIcon = document.getElementById('eye-slash-icon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.add('hidden');
                eyeSlashIcon.classList.remove('hidden');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('hidden');
                eyeSlashIcon.classList.add('hidden');
            }
        }
    </script>
@endsection
