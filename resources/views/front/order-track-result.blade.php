@extends('front.layout.master')

@section('content')
    <section class="py-12 px-4">
        <div class="container max-w-5xl">

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
                        <button onclick="this.parentElement.parentElement.remove()" class="flex-shrink-0 text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-200 transition-colors">
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
                        <button onclick="this.parentElement.parentElement.remove()" class="flex-shrink-0 text-green-600 dark:text-green-400 hover:text-green-800 dark:hover:text-green-200 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>
            @endif

            {{-- Main Card --}}
            <div class="relative bg-white/60 dark:bg-gray-900/90 backdrop-blur-2xl rounded-[2.5rem] border border-white/50 dark:border-gray-700/50 shadow-2xl overflow-hidden">

                {{-- Header --}}
                <div class="px-8 sm:px-10 py-6 border-b border-gray-200/60 dark:border-gray-700/60">
                    <h2 class="text-xl font-black text-gray-900 dark:text-white">
                        جزئیات سفارش
                        <span class="text-blue-600 dark:text-blue-400">#{{ $order->code }}</span>
                    </h2>
                </div>

                <div class="p-8 sm:p-10 space-y-8">

                    {{-- Info Grid --}}
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                        {{-- Customer Info --}}
                        <div class="bg-gray-50/80 dark:bg-gray-800/60 rounded-2xl p-6 border border-gray-200/50 dark:border-gray-700/50">
                            <h5 class="text-sm font-black text-gray-700 dark:text-gray-300 mb-4 flex items-center gap-2">
                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                اطلاعات مشتری
                            </h5>
                            <div class="space-y-3">
                                @foreach([
                                    ['نام', $order->name],
                                    ['موبایل', $order->mobile],
                                    ['استان', $order->state],
                                    ['شهر', $order->city],
                                    ['کد پستی', $order->postal_code],
                                    ['آدرس', $order->address],
                                ] as [$label, $value])
                                    <div class="flex gap-3 text-sm">
                                        <span class="w-20 flex-shrink-0 text-gray-500 dark:text-gray-400 font-medium">{{ $label }}</span>
                                        <span class="text-gray-900 dark:text-gray-100">{{ $value }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Financial Info --}}
                        <div class="bg-gray-50/80 dark:bg-gray-800/60 rounded-2xl p-6 border border-gray-200/50 dark:border-gray-700/50">
                            <h5 class="text-sm font-black text-gray-700 dark:text-gray-300 mb-4 flex items-center gap-2">
                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                </svg>
                                اطلاعات مالی و ارسال
                            </h5>
                            <div class="space-y-3">
                                <div class="flex gap-3 text-sm">
                                    <span class="w-32 flex-shrink-0 text-gray-500 dark:text-gray-400 font-medium">مبلغ کل</span>
                                    <span class="text-gray-900 dark:text-gray-100">{{ number_format($order->total_amount) }} تومان</span>
                                </div>
                                <div class="flex gap-3 text-sm">
                                    <span class="w-32 flex-shrink-0 text-gray-500 dark:text-gray-400 font-medium">مبلغ پرداختی</span>
                                    <span class="text-gray-900 dark:text-gray-100">{{ number_format($order->pay_amount) }} تومان</span>
                                </div>
                                <div class="flex gap-3 text-sm items-center">
                                    <span class="w-32 flex-shrink-0 text-gray-500 dark:text-gray-400 font-medium">وضعیت پرداخت</span>
                                    @if($order->is_paid)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700 dark:bg-green-500/20 dark:text-green-400" style="color: #0e9f6e">پرداخت شده</span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700 dark:bg-red-500/20 dark:text-red-400" style="color: red ;">پرداخت نشده</span>
                                    @endif
                                </div>
                                @if($order->ref_id)
                                    <div class="flex gap-3 text-sm">
                                        <span class="w-32 flex-shrink-0 text-gray-500 dark:text-gray-400 font-medium">شناسه ارجاع</span>
                                        <span class="font-mono text-gray-900 dark:text-gray-100">{{ $order->ref_id }}</span>
                                    </div>
                                @endif
                                @if($order->paid_at)
                                    <div class="flex gap-3 text-sm">
                                        <span class="w-32 flex-shrink-0 text-gray-500 dark:text-gray-400 font-medium">زمان پرداخت</span>
                                        <span class="text-gray-900 dark:text-gray-100">{{ \Morilog\Jalali\Jalalian::fromDateTime($order->paid_at)->format('Y/m/d H:i') }}</span>
                                    </div>
                                @endif
                                <div class="flex gap-3 text-sm">
                                    <span class="w-32 flex-shrink-0 text-gray-500 dark:text-gray-400 font-medium">تاریخ ثبت</span>
                                    <span class="text-gray-900 dark:text-gray-100">{{ \Morilog\Jalali\Jalalian::fromDateTime($order->created_at)->format('Y/m/d H:i') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Order Items --}}
                    <div>
                        <h5 class="text-sm font-black text-gray-700 dark:text-gray-300 mb-4 flex items-center gap-2">
                            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                            محصولات سفارش
                        </h5>
                        <div class="overflow-x-auto rounded-2xl border border-gray-200/50 dark:border-gray-700/50">
                            <table class="min-w-full">
                                <thead>
                                <tr class="bg-gray-100/80 dark:bg-gray-800/80">
                                    <th class="px-5 py-3 text-right text-xs font-black text-gray-500 dark:text-gray-400">ردیف</th>
                                    <th class="px-5 py-3 text-right text-xs font-black text-gray-500 dark:text-gray-400">نام محصول</th>
                                    <th class="px-5 py-3 text-right text-xs font-black text-gray-500 dark:text-gray-400">قیمت واحد</th>
                                    <th class="px-5 py-3 text-right text-xs font-black text-gray-500 dark:text-gray-400">تخفیف</th>
                                    <th class="px-5 py-3 text-right text-xs font-black text-gray-500 dark:text-gray-400">تعداد</th>
                                    <th class="px-5 py-3 text-right text-xs font-black text-gray-500 dark:text-gray-400">قیمت نهایی</th>
                                </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200/60 dark:divide-gray-700/60">
                                @foreach($order->orderItems as $index => $item)
                                    @php
                                        $productName = $item->product->has_sub_product
                                            ? $item->product->name . ' - ' . $item->subProduct->name
                                            : $item->product->name;
                                    @endphp
                                    <tr class="bg-white/40 dark:bg-gray-900/40 hover:bg-blue-50/40 dark:hover:bg-blue-900/10 transition-colors">
                                        <td class="px-5 py-3 text-sm text-gray-500 dark:text-gray-400">{{ $index + 1 }}</td>
                                        <td class="px-5 py-3 text-sm text-gray-900 dark:text-gray-100" title="{{ $productName }}">
                                            {{ \Illuminate\Support\Str::limit($productName, 30) }}
                                        </td>
                                        <td class="px-5 py-3 text-sm text-gray-900 dark:text-gray-100">{{ number_format($item->price) }} تومان</td>
                                        <td class="px-5 py-3 text-sm text-gray-900 dark:text-gray-100">{{ $item->discount ? number_format($item->discount) . ' تومان' : '-' }}</td>
                                        <td class="px-5 py-3 text-sm text-gray-900 dark:text-gray-100">{{ $item->quantity }}</td>
                                        <td class="px-5 py-3 text-sm font-bold text-gray-900 dark:text-gray-100">{{ number_format(($item->price - ($item->discount ?? 0)) * $item->quantity) }} تومان</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Order Status --}}
                    @php
                        $color = $order->status->color();
                        $statusStyles = match($color) {
                            'green' => 'bg-green-500/10 dark:bg-green-500/20 border-green-500/30 dark:border-green-500/40 text-green-700 dark:text-green-300',
                            'red'   => 'bg-red-500/10 dark:bg-red-500/20 border-red-500/30 dark:border-red-500/40 text-red-700 dark:text-red-300',
                            default => 'bg-blue-500/10 dark:bg-blue-500/20 border-blue-500/30 dark:border-blue-500/40 text-blue-700 dark:text-blue-300',
                        };
                    @endphp
                    <div class="p-5 rounded-2xl border backdrop-blur-sm {{ $statusStyles }}">
                        <div class="flex flex-wrap gap-x-5 gap-y-2 items-center text-sm">
                            <span class="font-black">وضعیت فعلی:</span>
                            <span>{{ $order->status->label() }}</span>
                            @if($order->send_method_id)
                                <span class="opacity-40">|</span>
                                <span class="font-black">روش ارسال:</span>
                                <span>{{ $order->sendMethod->name }}</span>
                            @endif
                            @if($order->track_number)
                                <span class="opacity-40">|</span>
                                <span class="font-black">کد پیگیری:</span>
                                <span class="font-mono">{{ $order->track_number }}</span>
                            @endif
                            @if($order->send_at)
                                <span class="opacity-40">|</span>
                                <span class="font-black">تاریخ ارسال:</span>
                                <span>{{ \Morilog\Jalali\Jalalian::fromDateTime($order->send_at)->format('Y/m/d') }}</span>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection
