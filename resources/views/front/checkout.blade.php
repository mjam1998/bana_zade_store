@extends('front.layout.master')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-8 dark:text-white">تایید نهایی سفارش</h1>
        @if(session('error'))
            <div class="mb-6 relative">
                <div class="absolute inset-0 bg-red-500/10 dark:bg-red-500/5 backdrop-blur-xl rounded-2xl"></div>
                <div class="relative p-4 border border-red-200 dark:border-red-500/30 rounded-2xl flex items-start gap-3">
                    <div class="flex-shrink-0 w-10 h-10 bg-red-100 dark:bg-red-900/30 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h4 class="text-sm font-bold text-red-800 dark:text-red-300 mb-1">خطا</h4>
                        <p class="text-sm text-red-700 dark:text-red-400">{{ session('error') }}</p>
                    </div>
                    <button onclick="this.parentElement.parentElement.remove()" class="flex-shrink-0 text-red-400 hover:text-red-600 dark:hover:text-red-300 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        @endif
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- فرم اطلاعات مشتری -->
            <div class="lg:col-span-2">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-bold mb-6 dark:text-white">اطلاعات گیرنده</h2>

                    <form action="{{ route('checkout.process') }}" method="POST" id="checkout-form">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    نام و نام خانوادگی <span class="text-red-500">*</span>
                                </label>
                                <input type="text"
                                       id="name"
                                       name="name"
                                       value="{{ old('name') }}"
                                       class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 dark:text-white @error('name') border-red-500 @enderror"
                                       required>
                                @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="mobile" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    شماره موبایل <span class="text-red-500">*</span>
                                </label>
                                <input type="text"
                                       id="mobile"
                                       name="mobile"
                                       value="{{ old('mobile') }}"
                                       placeholder="09123456789"
                                       class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 dark:text-white @error('mobile') border-red-500 @enderror"
                                       required>
                                @error('mobile')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="state" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    استان <span class="text-red-500">*</span>
                                </label>
                                <input type="text"
                                       id="state"
                                       name="state"
                                       value="{{ old('state') }}"
                                       class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 dark:text-white @error('state') border-red-500 @enderror"
                                       required>
                                @error('state')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="city" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    شهر <span class="text-red-500">*</span>
                                </label>
                                <input type="text"
                                       id="city"
                                       name="city"
                                       value="{{ old('city') }}"
                                       class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 dark:text-white @error('city') border-red-500 @enderror"
                                       required>
                                @error('city')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                آدرس کامل <span class="text-red-500">*</span>
                            </label>
                            <textarea id="address"
                                      name="address"
                                      rows="3"
                                      class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 dark:text-white @error('address') border-red-500 @enderror"
                                      required>{{ old('address') }}</textarea>
                            @error('address')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="postal_code" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                کد پستی (10 رقم بدون خط تیره) <span class="text-red-500">*</span>
                            </label>
                            <input type="text"
                                   id="postal_code"
                                   name="postal_code"
                                   value="{{ old('postal_code') }}"
                                   placeholder="1234567890"
                                   maxlength="10"
                                   class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 dark:text-white @error('postal_code') border-red-500 @enderror"
                                   required>
                            @error('postal_code')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <h3 class="text-lg font-bold mb-4 dark:text-white">روش ارسال <span class="text-red-500">*</span></h3>
                            <div class="space-y-3">
                                @foreach($sendMethods as $method)
                                    <label class="flex items-center p-4 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition @error('send_method_id') border-red-500 @enderror">
                                        <input type="radio"
                                               name="send_method_id"
                                               value="{{ $method->id }}"
                                               data-price="{{ $method->price }}"
                                               class="send-method-radio ml-3"
                                               {{ old('send_method_id') == $method->id ? 'checked' : '' }}
                                               required>
                                        <div class="flex-1">
                                            <div class="font-medium dark:text-white">{{ $method->name }}</div>
                                            @if($method->description)
                                                <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $method->description }}</div>
                                            @endif
                                        </div>

                                    </label>
                                @endforeach
                            </div>
                            @error('send_method_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit"
                                class="w-full bg-green-600 text-white py-3 rounded-lg font-bold hover:bg-green-700 transition">
                            پرداخت و ثبت نهایی سفارش
                        </button>
                    </form>
                </div>
            </div>

            <!-- خلاصه سفارش -->
            <div class="lg:col-span-1">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 sticky top-4">
                    <h2 class="text-xl font-bold mb-6 dark:text-white">خلاصه سفارش</h2>

                    <!-- لیست محصولات -->
                    <div class="space-y-4 mb-6 max-h-64 overflow-y-auto">
                        @foreach($cart as $item)
                            <div class="flex items-center gap-3 pb-3 border-b border-gray-200 dark:border-gray-700">
                                <img src="{{ asset($item['image']) }}"
                                     alt="{{ $item['name'] }}"
                                     class="w-16 h-16 object-cover rounded">
                                <div class="flex-1">
                                    <div class="text-sm font-medium dark:text-white">{{ $item['name'] }}</div>
                                    <div class="text-xs text-gray-600 dark:text-gray-400 mt-1">
                                        تعداد: {{ number_format($item['quantity']) }}
                                    </div>
                                </div>
                                <div class="text-sm font-bold dark:text-white">
                                    {{ number_format($item['final_price'] * $item['quantity']) }}
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- جزئیات قیمت -->
                    <div class="space-y-3 border-t border-gray-200 dark:border-gray-700 pt-4">
                        <div class="flex justify-between text-gray-700 dark:text-gray-300">
                            <span>جمع کل محصولات:</span>
                            <span class="font-medium">{{ number_format($totalPrice) }} تومان</span>
                        </div>

                        @if($totalDiscount > 0)
                            <div class="flex justify-between text-red-600 dark:text-red-400">
                                <span>تخفیف:</span>
                                <span class="font-medium">{{ number_format($totalDiscount) }} تومان</span>
                            </div>
                        @endif


                        <div class="flex justify-between text-lg font-bold text-blue-600 dark:text-blue-400 border-t border-gray-200 dark:border-gray-700 pt-3">
                            <span>مبلغ قابل پرداخت:</span>
                            <span id="final-amount">{{ number_format($finalTotal) }} تومان</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
