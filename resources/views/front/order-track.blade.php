@extends('front.layout.master')

@section('content')
    <section class="py-20 px-4">
        <div class="container max-w-md">

            {{-- Alert Messages --}}
            @if(session('error'))
                <div class="relative mb-6 bg-red-500/10 dark:bg-red-500/20 backdrop-blur-xl p-5 rounded-3xl border border-red-500/30 dark:border-red-500/40 shadow-xl">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 rounded-full bg-red-500/20 dark:bg-red-500/30 flex items-center justify-center">
                                <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-sm font-black text-red-700 dark:text-red-400 mb-1">خطا</h3>
                            <p class="text-xs text-red-600 dark:text-red-300">{{ session('error') }}</p>
                        </div>
                        <button onclick="this.parentElement.parentElement.remove()"
                                class="flex-shrink-0 text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-200 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>
            @endif

            @if(session('success'))
                <div class="relative mb-6 bg-green-500/10 dark:bg-green-500/20 backdrop-blur-xl p-5 rounded-3xl border border-green-500/30 dark:border-green-500/40 shadow-xl">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 rounded-full bg-green-500/20 dark:bg-green-500/30 flex items-center justify-center">
                                <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-sm font-black text-green-700 dark:text-green-400 mb-1">موفق</h3>
                            <p class="text-xs text-green-600 dark:text-green-300">{{ session('success') }}</p>
                        </div>
                        <button onclick="this.parentElement.parentElement.remove()"
                                class="flex-shrink-0 text-green-600 dark:text-green-400 hover:text-green-800 dark:hover:text-green-200 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>
            @endif

            {{-- Main Card --}}
            <div class="relative bg-white/60 dark:bg-gray-900/90 backdrop-blur-2xl p-8 sm:p-10 rounded-[2.5rem] border border-white/50 dark:border-gray-700/50 shadow-2xl">

                <div class="text-center mb-8">
                    <h2 class="text-2xl font-black text-gray-900 dark:text-white">پیگیری سفارش</h2>
                    <p class="text-gray-500 dark:text-gray-400 text-sm mt-2">کد سفارش خود را وارد کنید</p>
                </div>

                <form action="{{ route('order.track.result') }}" method="POST" class="space-y-6">
                    @csrf

                    <div>
                        <label class="block text-[12px] font-bold text-gray-700 dark:text-gray-300 mb-2">کد سفارش</label>
                        <input
                            type="text"
                            id="order_code"
                            name="order_code"
                            required
                            placeholder="مثال: ORD-12345"
                            value="{{ old('order_code') }}"
                            class="w-full px-5 py-4 rounded-2xl bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-400 outline-none transition-all text-gray-900 dark:text-white placeholder:text-gray-400 dark:placeholder:text-gray-500"
                        />
                        @error('order_code')
                        <p class="text-red-500 text-xs mt-2 pr-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="w-full py-4 rounded-2xl bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 text-white font-black transition-all duration-300 shadow-lg shadow-blue-600/20 active:scale-95">
                        جستجوی سفارش
                    </button>
                </form>

            </div>
        </div>
    </section>
@endsection
