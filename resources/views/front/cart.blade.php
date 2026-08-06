@extends('front.layout.master')

@section('content')
    <!-- CART SECTION -->
    <section class="relative overflow-hidden py-16 transition-colors duration-700">
        <div class="container relative z-10">
            <!-- Header -->
            <div class="flex items-end justify-between mb-10 gap-4 flex-wrap">
                <div class="flex items-center gap-6">
                    <div class="relative group">
                        <div class="relative w-16 h-16 bg-white dark:bg-black border border-gray-100 dark:border-blue-500/40 rounded-[1.8rem] flex items-center justify-center text-blue-600 shadow-2xl">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <h2 class="text-3xl font-black text-gray-900 dark:text-white tracking-tight">سبد خرید</h2>
                        <p class="text-[10px] font-black text-blue-500 uppercase tracking-[0.4em] mt-2 flex items-center gap-2">
                            <span class="w-8 h-[2px] bg-blue-500/30"></span>
                            Shopping Cart
                        </p>
                    </div>
                </div>
            </div>
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
            @if(empty($cart))
                <!-- Empty Cart State -->
                <div class="flex flex-col items-center justify-center py-20">
                    <div class="relative w-32 h-32 mb-6">
                        <div class="absolute inset-0 bg-gradient-to-br from-blue-500/20 to-purple-500/20 dark:from-blue-500/10 dark:to-purple-500/10 rounded-full blur-2xl"></div>
                        <div class="relative w-full h-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-full flex items-center justify-center shadow-xl">
                            <svg class="w-16 h-16 text-gray-400 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-2xl font-black text-gray-800 dark:text-gray-200 mb-2">سبد خرید شما خالی است</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">برای خرید به صفحه محصولات بروید</p>
                    <a href="{{ route('search') }}" class="px-8 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold rounded-xl shadow-lg hover:scale-105 transition-all">
                        مشاهده محصولات
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Cart Items -->
                    <div class="lg:col-span-2 space-y-4" id="cart-items-container">
                        @foreach($cart as $key => $item)
                            <div class="cart-item relative group" data-cart-key="{{ $key }}">
                                <!-- Card Background -->
                                <div class="absolute inset-0 bg-white/80 dark:bg-[#0a0a0a]/40 backdrop-blur-3xl rounded-[2rem] border border-gray-100 dark:border-white/5 shadow-sm transition-all duration-500"></div>

                                <!-- Card Content -->
                                <div class="relative p-5 z-10">
                                    <div class="flex gap-4">
                                        <!-- Product Image -->
                                        <a href="{{ route('product.detail', $item['slug']) }}" class="flex-shrink-0">
                                            <div class="w-24 h-24 rounded-xl overflow-hidden shadow-lg">
                                                <img src="{{ $item['image']  }}"
                                                     class="w-full h-full object-cover"
                                                     alt="{{ $item['name'] }}">
                                            </div>
                                        </a>

                                        <!-- Product Info -->
                                        <div class="flex-1 min-w-0">
                                            <a href="{{ route('product.detail', $item['slug']) }}" class="block mb-2">
                                                <h3 class="text-base font-black text-gray-800 dark:text-gray-100 line-clamp-2 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                                                    {{ $item['name'] }}
                                                </h3>
                                            </a>

                                            <!-- Price Info -->
                                            <div class="mb-3">
                                                @if($item['discount'] > 0)
                                                    <div class="flex items-center gap-2 mb-1">
                                                        <span class="text-sm text-gray-400 dark:text-gray-500 line-through">
                                                            {{ number_format($item['price']) }}
                                                        </span>
                                                        <span class="text-xs text-red-500 font-bold">
                                                            {{ round(($item['discount'] * 100) / $item['price']) }}%
                                                        </span>
                                                    </div>
                                                @endif
                                                <div class="flex items-baseline gap-1">
                                                    <span class="text-xl font-black text-gray-900 dark:text-white">
                                                        {{ number_format($item['final_price']) }}
                                                    </span>
                                                    <span class="text-xs text-gray-500 dark:text-gray-400">تومان</span>
                                                </div>
                                            </div>

                                            <!-- Quantity Controls & Remove Button -->
                                            <div class="flex items-center justify-between gap-3">
                                                <!-- Quantity Controls -->
                                                <div class="flex items-center gap-2">
                                                    <button type="button"
                                                            class="qty-decrease w-8 h-8 flex items-center justify-center bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg transition-colors"
                                                            data-cart-key="{{ $key }}">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                                        </svg>
                                                    </button>

                                                    <input type="number"
                                                           class="qty-input w-14 h-8 text-center text-sm font-bold bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 text-gray-900 dark:text-white rounded-lg focus:border-blue-500 dark:focus:border-blue-400 outline-none"
                                                           value="{{ $item['quantity'] }}"
                                                           min="1"

                                                           data-cart-key="{{ $key }}">

                                                    <button type="button"
                                                            class="qty-increase w-8 h-8 flex items-center justify-center bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg transition-colors"
                                                            data-cart-key="{{ $key }}">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                                        </svg>
                                                    </button>
                                                </div>

                                                <!-- Item Total -->
                                                <div class="flex items-baseline gap-1">
                                                    <span class="text-sm text-gray-500 dark:text-gray-400">جمع:</span>
                                                    <span class="text-lg font-black text-gray-900 dark:text-white item-total">
                                                        {{ number_format($item['final_price'] * $item['quantity']) }}
                                                    </span>
                                                    <span class="text-xs text-gray-500 dark:text-gray-400">تومان</span>
                                                </div>

                                                <!-- Remove Button -->
                                                <button type="button"
                                                        class="remove-item w-8 h-8 flex items-center justify-center bg-red-50 dark:bg-red-900/20 hover:bg-red-100 dark:hover:bg-red-900/40 text-red-600 dark:text-red-400 rounded-lg transition-colors"
                                                        data-cart-key="{{ $key }}"
                                                        title="حذف از سبد">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Order Summary -->
                    <div class="lg:col-span-1">
                        <div class="sticky top-24">
                            <div class="relative">
                                <!-- Card Background -->
                                <div class="absolute inset-0 bg-white/80 dark:bg-[#0a0a0a]/40 backdrop-blur-3xl rounded-[2rem] border border-gray-100 dark:border-white/5 shadow-sm"></div>

                                <!-- Card Content -->
                                <div class="relative p-6 z-10">
                                    <h3 class="text-xl font-black text-gray-900 dark:text-white mb-6">خلاصه سفارش</h3>

                                    <div class="space-y-4 mb-6">
                                        <!-- Total Price -->
                                        <div class="flex items-center justify-between">
                                            <span class="text-sm text-gray-600 dark:text-gray-400">جمع کل:</span>
                                            <div class="flex items-baseline gap-1">
                                                <span class="text-lg font-bold text-gray-900 dark:text-white" id="summary-total-price">
                                                    {{ number_format($totalPrice) }}
                                                </span>
                                                <span class="text-xs text-gray-500 dark:text-gray-400">تومان</span>
                                            </div>
                                        </div>

                                        <!-- Total Discount -->
                                        @if($totalDiscount > 0)
                                            <div class="flex items-center justify-between">
                                                <span class="text-sm text-gray-600 dark:text-gray-400">تخفیف:</span>
                                                <div class="flex items-baseline gap-1">
                                                    <span class="text-lg font-bold text-red-600 dark:text-red-400" id="summary-total-discount">
                                                        {{ number_format($totalDiscount) }}
                                                    </span>
                                                    <span class="text-xs text-gray-500 dark:text-gray-400">تومان</span>
                                                </div>
                                            </div>
                                        @endif

                                        <!-- Divider -->
                                        <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                                            <div class="flex items-center justify-between">
                                                <span class="text-base font-bold text-gray-900 dark:text-white">مبلغ قابل پرداخت:</span>
                                                <div class="flex items-baseline gap-1">
                                                    <span class="text-2xl font-black text-blue-600 dark:text-blue-400" id="summary-final-total">
                                                        {{ number_format($finalTotal) }}
                                                    </span>
                                                    <span class="text-xs text-gray-500 dark:text-gray-400">تومان</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <!-- Checkout Button -->
                                    @if($gatewayActive)
                                        <a href="{{ route('checkout') }}" class="w-full h-12 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white text-base font-bold rounded-xl flex items-center justify-center gap-2 shadow-lg hover:scale-105 transition-all mb-3">
                                            <span>ادامه فرآیند خرید</span>
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                            </svg>
                                        </a>
                                    @else
                                        <div class="w-full mb-3 p-4 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-500/30 rounded-xl text-center">
                                            <p class="text-sm font-bold text-amber-800 dark:text-amber-300 mb-1">برای استعلام و خرید تماس بگیرید</p>

                                            <a href="tel:09136437210" class="inline-flex items-center gap-2 px-5 py-2.5 bg-amber-500 hover:bg-amber-600 text-white text-sm font-bold rounded-xl transition-all hover:scale-105 shadow-md">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.948V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                                </svg>
                                                <span>09136437210</span>
                                            </a>
                                        </div>
                                    @endif

                                    <!-- Clear Cart Button -->
                                    <button id="clear-cart-btn" class="w-full h-10 bg-red-50 dark:bg-red-900/20 hover:bg-red-100 dark:hover:bg-red-900/40 text-red-600 dark:text-red-400 text-sm font-bold rounded-xl transition-all">
                                        خالی کردن سبد خرید
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
    <!-- END CART SECTION -->
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
            const cartCountBadge = document.querySelectorAll('.cart-badge');

            // Update cart count badge
            function updateCartBadge(count) {
                document.querySelectorAll('.cart-badge').forEach(el => {
                    el.textContent = count;
                });
            }

            // Update quantity
            function updateQuantity(cartKey, quantity) {
                fetch('{{ route("cart.update") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        cart_key: cartKey,
                        quantity: quantity
                    })
                })
                    .then(response => response.json())
                    .then(data => {
                        if(data.status === 'success') {
                            // Update item total
                            const cartItem = document.querySelector(`.cart-item[data-cart-key="${cartKey}"]`);
                            cartItem.querySelector('.item-total').textContent = data.item_total;

                            // Update summary
                            document.getElementById('summary-total-price').textContent = data.total_price;
                            document.getElementById('summary-final-total').textContent = data.final_total;
                            if(document.getElementById('summary-total-discount')) {
                                document.getElementById('summary-total-discount').textContent = data.total_discount;
                            }

                            // Update cart badge
                            updateCartBadge(data.cart_count);
                        }
                    });
            }

            // Remove item
            document.querySelectorAll('.remove-item').forEach(btn => {
                btn.addEventListener('click', function() {
                    const cartKey = this.getAttribute('data-cart-key');
                    fetch('{{ route("cart.remove") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({ cart_key: cartKey })
                    })
                        .then(response => response.json())
                        .then(data => {
                            if(data.status === 'success') {
                                // Update cart badge
                                updateCartBadge(data.cart_count);

                                if(data.cart_empty) {
                                    location.reload();
                                } else {
                                    document.querySelector(`.cart-item[data-cart-key="${cartKey}"]`).remove();
                                    document.getElementById('summary-total-price').textContent = data.total_price;
                                    document.getElementById('summary-final-total').textContent = data.final_total;
                                    if(document.getElementById('summary-total-discount')) {
                                        document.getElementById('summary-total-discount').textContent = data.total_discount;
                                    }
                                }
                            }
                        });
                });
            });

            // Events for quantity inputs
            document.querySelectorAll('.qty-increase').forEach(btn => {
                btn.addEventListener('click', function() {
                    const input = this.previousElementSibling;
                    input.value = parseInt(input.value) + 1;
                    updateQuantity(this.getAttribute('data-cart-key'), input.value);
                });
            });

            document.querySelectorAll('.qty-decrease').forEach(btn => {
                btn.addEventListener('click', function() {
                    const input = this.nextElementSibling;
                    if (input.value > 1) {
                        input.value = parseInt(input.value) - 1;
                        updateQuantity(this.getAttribute('data-cart-key'), input.value);
                    }
                });
            });

            // Clear Cart
            document.getElementById('clear-cart-btn')?.addEventListener('click', function() {
                if(confirm('آیا از خالی کردن سبد خرید اطمینان دارید؟')) {
                    fetch('{{ route("cart.clear") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        }
                    })
                        .then(response => response.json())
                        .then(data => {
                            location.reload();
                        });
                }
            });
        });
    </script>
@endpush

