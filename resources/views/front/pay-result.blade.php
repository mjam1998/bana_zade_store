@extends('front.layout.master')

@section('content')
    <div class="container mx-auto px-4 py-16">
        <div class="max-w-2xl mx-auto">

            @if($failed)
                {{-- آیکون خطا --}}
                <div class="flex flex-col items-center mb-10">
                    <div class="w-24 h-24 bg-red-100 dark:bg-red-900 rounded-full ring-4 ring-red-200 dark:ring-red-800 flex items-center justify-center mb-6 shadow-lg">
                        <svg class="w-12 h-12 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </div>
                    <h1 class="text-3xl font-bold text-gray-800 dark:text-white mb-2">پرداخت ناموفق</h1>
                    <p class="text-gray-500 dark:text-gray-400 text-center">
                        متأسفانه پرداخت شما با خطا مواجه شد.
                    </p>
                </div>

                {{-- کارت اطلاعات --}}
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-8 mb-6">

                    {{-- کد سفارش --}}
                    <div class="flex items-center justify-between p-4 bg-red-50 dark:bg-red-950 border border-red-200 dark:border-red-800 rounded-xl mb-6">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-red-100 dark:bg-red-900 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400">کد سفارش</p>
                                <p class="text-lg font-bold text-gray-800 dark:text-white tracking-widest">{{ $order->code }}</p>
                            </div>
                        </div>
                        <button onclick="copyCode('{{ $order->code }}', 'copy-icon-failed')" title="کپی کد سفارش"
                                class="text-red-500 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 transition-colors">
                            <svg id="copy-icon-failed" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                            </svg>
                        </button>
                    </div>

                    <div class="space-y-4">
                        <div class="flex justify-between items-center py-3 border-b border-gray-100 dark:border-gray-700">
                            <span class="text-gray-500 dark:text-gray-400 text-sm">نام گیرنده</span>
                            <span class="font-medium text-gray-800 dark:text-white">{{ $order->name }}</span>
                        </div>
                        <div class="flex justify-between items-center py-3 border-b border-gray-100 dark:border-gray-700">
                            <span class="text-gray-500 dark:text-gray-400 text-sm">مبلغ سفارش</span>
                            <span class="font-bold text-gray-800 dark:text-white">{{ number_format($order->pay_amount) }} تومان</span>
                        </div>
                        <div class="flex justify-between items-center py-3">
                            <span class="text-gray-500 dark:text-gray-400 text-sm">وضعیت پرداخت</span>
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-400 text-sm font-medium rounded-full">
                                <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span>
                                ناموفق
                            </span>
                        </div>
                    </div>
                </div>

                {{-- بنر هشدار --}}
                <div class="p-5 bg-amber-50 dark:bg-amber-950 border border-amber-200 dark:border-amber-800 rounded-2xl flex items-start gap-4 mb-6">
                    <div class="flex-shrink-0 w-10 h-10 bg-amber-100 dark:bg-amber-900 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-amber-800 dark:text-amber-300 mb-1">توجه مهم</h4>
                        <p class="text-sm text-amber-700 dark:text-amber-400 leading-relaxed">
                            در صورتی که وجهی از حساب شما کسر شده باشد، تا <span class="font-bold">۴۸ ساعت کاری</span> به حساب شما بازگشت خواهد شد.
                            در غیر این صورت با پشتیبانی تماس بگیرید.
                        </p>
                    </div>
                </div>

                {{-- دکمه‌ها --}}
                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="tel:09136437210"
                       class="flex-1 flex items-center justify-center gap-2 bg-red-600 hover:bg-red-700 text-white py-3 rounded-xl font-bold transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        تماس با پشتیبانی
                    </a>
                    <a href="{{ route('home') }}"
                       class="flex-1 flex items-center justify-center gap-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 py-3 rounded-xl font-bold transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        بازگشت به فروشگاه
                    </a>
                </div>

            @else
                {{-- آیکون موفقیت --}}
                <div class="flex flex-col items-center mb-10">
                    <div  style="color: #0e9f6e!important;" class="w-24 h-24 bg-green-100 dark:bg-green-900 rounded-full ring-4 ring-green-200 dark:ring-green-800 flex items-center justify-center mb-6 shadow-lg">
                        <svg style="color: #0e9f6e!important;" class="w-12 h-12 text-green-600 dark:text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path  stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>

                    <h1 class="text-3xl font-bold text-gray-800 dark:text-white mb-2" style="color: #0e9f6e!important;">پرداخت موفق</h1>
                    <p class="text-gray-500 dark:text-gray-400 text-center">
                        سفارش شما با موفقیت پرداخت شد و به زودی توسط همکاران ما ارسال خواهد شد.
                    </p>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-8 mb-6">
                    <div  style="color: #0e9f6e!important;" class="flex items-center justify-between p-4 bg-green-50 dark:bg-green-950 border border-green-200 dark:border-green-800 rounded-xl mb-6">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400">کد سفارش</p>
                                <p class="text-lg font-bold text-gray-800 dark:text-white tracking-widest">{{ $order->code }}</p>
                            </div>
                        </div>
                        <button onclick="copyCode('{{ $order->code }}', 'copy-icon-success')" title="کپی کد سفارش"
                                class="text-green-600 dark:text-green-400 hover:text-green-800 dark:hover:text-green-300 transition-colors">
                            <svg id="copy-icon-success" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                            </svg>
                        </button>
                    </div>

                    <div class="space-y-4">
                        <div class="flex justify-between items-center py-3 border-b border-gray-100 dark:border-gray-700">
                            <span class="text-gray-500 dark:text-gray-400 text-sm">نام گیرنده</span>
                            <span class="font-medium text-gray-800 dark:text-white">{{ $order->name }}</span>
                        </div>
                        <div class="flex justify-between items-center py-3 border-b border-gray-100 dark:border-gray-700">
                            <span class="text-gray-500 dark:text-gray-400 text-sm">شماره موبایل</span>
                            <span class="font-medium text-gray-800 dark:text-white">{{ $order->mobile }}</span>
                        </div>
                        <div class="flex justify-between items-center py-3 border-b border-gray-100 dark:border-gray-700">
                            <span class="text-gray-500 dark:text-gray-400 text-sm">مبلغ پرداخت شده</span>
                            <span class="font-bold text-green-600 dark:text-green-400">{{ number_format($order->pay_amount) }} تومان</span>
                        </div>
                        @if($order->ref_id)
                            <div class="flex justify-between items-center py-3 border-b border-gray-100 dark:border-gray-700">
                                <span class="text-gray-500 dark:text-gray-400 text-sm">کد پیگیری بانک</span>
                                <span class="font-medium text-gray-800 dark:text-white">{{ $order->ref_id }}</span>
                            </div>
                        @endif
                        <div class="flex justify-between items-center py-3">
                            <span class="text-gray-500 dark:text-gray-400 text-sm">وضعیت سفارش</span>
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-yellow-100 dark:bg-yellow-900 text-yellow-700 dark:text-yellow-400 text-sm font-medium rounded-full">
                                <span class="w-1.5 h-1.5 bg-yellow-500 rounded-full"></span>
                                در حال پردازش
                            </span>
                        </div>
                    </div>
                </div>

                {{-- بنر پیگیری --}}
                <div class="p-5 bg-blue-50 dark:bg-blue-950 border border-blue-200 dark:border-blue-800 rounded-2xl flex items-start gap-4 mb-6">
                    <div class="flex-shrink-0 w-10 h-10 bg-blue-100 dark:bg-blue-900 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-blue-800 dark:text-blue-300 mb-1">پیگیری سفارش</h4>
                        <p class="text-sm text-blue-700 dark:text-blue-400">
                            می‌توانید از طریق صفحه پیگیری سفارش، وضعیت ارسال سفارش خود را دنبال کنید.
                        </p>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="#"
                       class="flex-1 flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-xl font-bold transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                        </svg>
                        پیگیری سفارش
                    </a>
                    <a href="{{ route('home') }}"
                       class="flex-1 flex items-center justify-center gap-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 py-3 rounded-xl font-bold transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        بازگشت به فروشگاه
                    </a>
                </div>
            @endif

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function copyCode(code, iconId) {
            navigator.clipboard.writeText(code).then(() => {
                const icon = document.getElementById(iconId);
                icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>`;
                setTimeout(() => {
                    icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>`;
                }, 2000);
            });
        }
    </script>
@endpush
