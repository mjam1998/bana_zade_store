@php
    $cart = session('cart', []);
    $totalPrice = 0;
    $totalDiscount = 0;
    foreach($cart as $item) {
        $totalPrice += $item['price'] * $item['quantity'];
        $totalDiscount += $item['discount'] * $item['quantity'];
    }
    $finalTotal = $totalPrice - $totalDiscount;
@endphp

<div class="relative bg-white/80 dark:bg-[#0a0a0a]/40 backdrop-blur-3xl rounded-[2rem] border border-gray-100 dark:border-white/5 shadow-sm p-5" id="cart-sidebar-content">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-base font-black text-gray-900 dark:text-white">سبد خرید</h3>
        @if(!empty($cart))
            <span class="text-xs bg-blue-100 dark:bg-blue-900/40 text-blue-600 dark:text-blue-400 font-bold px-2 py-1 rounded-full">
                {{ array_sum(array_column($cart, 'quantity')) }} کالا
            </span>
        @endif
    </div>

    @if(empty($cart))
        <div class="flex flex-col items-center py-8 text-center">
            <svg class="w-12 h-12 text-gray-300 dark:text-gray-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
            <p class="text-sm text-gray-400 dark:text-gray-500">سبد خرید خالی است</p>
        </div>
    @else
        <!-- آیتم‌های سبد -->
        <div class="space-y-3 max-h-[50vh] overflow-y-auto mb-4 pl-1" id="sidebar-cart-items">
            @foreach($cart as $key => $item)
                <div class="flex gap-3 items-start sidebar-cart-item" data-cart-key="{{ $key }}">
                    <img src="{{ $item['image'] }}" class="w-12 h-12 rounded-xl object-cover shrink-0" alt="{{ $item['name'] }}">
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-bold text-gray-800 dark:text-gray-200 line-clamp-2 mb-1">{{ $item['name'] }}</p>
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-black text-blue-600 dark:text-blue-400">
                                {{ number_format($item['final_price']) }} <span class="font-normal text-gray-400">تومان</span>
                            </span>
                            <span class="text-xs text-gray-400">× {{ $item['quantity'] }}</span>
                        </div>
                    </div>
                    <button class="sidebar-remove-item text-red-400 hover:text-red-600 transition-colors shrink-0 mt-0.5" data-cart-key="{{ $key }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            @endforeach
        </div>

        <!-- جمع -->
        <div class="border-t border-gray-100 dark:border-white/5 pt-4 space-y-2">
            @if($totalDiscount > 0)
                <div class="flex justify-between text-xs text-gray-500 dark:text-gray-400">
                    <span>تخفیف:</span>
                    <span class="text-red-500 font-bold">{{ number_format($totalDiscount) }} تومان</span>
                </div>
            @endif<div class="flex justify-between items-center">
                <span class="text-sm font-bold text-gray-700 dark:text-gray-300">قابل پرداخت:</span>
                <span class="text-lg font-black text-blue-600 dark:text-blue-400" id="sidebar-final-total">{{ number_format($finalTotal) }} <span class="text-xs font-normal text-gray-400">تومان</span></span>
            </div>
        </div>

        <a href="{{ route('cart.view') }}" class="mt-4 w-full h-10 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white text-sm font-bold rounded-xl flex items-center justify-center gap-2 transition-all hover:scale-105">
            مشاهده سبد خرید
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
    @endif
</div>

{{--@push('scripts')--}}
{{--    <script>--}}
{{--        document.addEventListener('click', function (e) {--}}
{{--            if (!e.target.closest('.sidebar-remove-item')) return;--}}

{{--            const btn = e.target.closest('.sidebar-remove-item');--}}
{{--            const cartKey = btn.dataset.cartKey;--}}

{{--            fetch('{{ route("cart.remove") }}', {--}}
{{--                method: 'POST',--}}
{{--                headers: {--}}
{{--                    'Content-Type': 'application/json',--}}
{{--                    'X-CSRF-TOKEN': '{{ csrf_token() }}'--}}
{{--                },--}}
{{--                body: JSON.stringify({ cart_key: cartKey })--}}
{{--            })--}}
{{--                .then(res => res.json())--}}
{{--                .then(data => {--}}

{{--                    // آپدیت تعداد سبد بالا--}}
{{--                    document.querySelectorAll('.cart-badge').forEach(el => {--}}
{{--                        el.textContent = data.cart_count;--}}
{{--                    });--}}
{{--                    if (window.innerWidth < 1024) {--}}
{{--                        refreshMobileCartDrawer(true);--}}
{{--                    }--}}
{{--                    // اگر سبد خالی شد → کل سایدبار را مجدد لود کن--}}
{{--                    if (data.cart_empty) {--}}
{{--                        fetch('{{ route("cart.sidebar") }}')--}}
{{--                            .then(r => r.text())--}}
{{--                            .then(html => {--}}
{{--                                document.getElementById('cart-sidebar-content').innerHTML = html;--}}
{{--                            });--}}

{{--                        return;--}}
{{--                    }--}}

{{--                    // اگر سبد خالی نشد → رندر جدید--}}
{{--                    fetch('{{ route("cart.sidebar") }}')--}}
{{--                        .then(r => r.text())--}}
{{--                        .then(html => {--}}
{{--                            document.getElementById('cart-sidebar-content').innerHTML = html;--}}
{{--                        });--}}
{{--                })--}}
{{--        });--}}

{{--    </script>--}}
{{--@endpush--}}
