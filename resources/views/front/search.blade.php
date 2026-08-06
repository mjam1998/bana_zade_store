@extends('front.layout.master')

@section('content')
    <!-- PRODUCTS SECTION -->
    <section class="relative overflow-hidden py-16 transition-colors duration-700">
        <div class="container relative z-10">
            <div class="flex gap-6 items-start">
                <div class="flex-1 min-w-0">
            <!-- Header -->
            <div class="flex items-end justify-between mb-10 gap-4 flex-wrap">
                <div class="flex items-center gap-6">
                    <div class="relative group">
                        <div class="relative w-16 h-16 bg-white dark:bg-black border border-gray-100 dark:border-blue-500/40 rounded-[1.8rem] flex items-center justify-center text-blue-600 shadow-2xl">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <h2 class="text-3xl font-black text-gray-900 dark:text-white tracking-tight">محصولات</h2>
                        <p class="text-[10px] font-black text-blue-500 uppercase tracking-[0.4em] mt-2 flex items-center gap-2">
                            <span class="w-8 h-[2px] bg-blue-500/30"></span>
                            Products
                        </p>
                    </div>
                </div>
            </div>

            <!-- Filter Section -->
            <form method="GET" action="{{ url()->current() }}" id="filterForm" class="mb-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Search Box -->
                    <div class="relative">
                        <input type="text"
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="جستجوی محصول..."
                               class="w-full px-5 py-3 pr-12 rounded-2xl bg-white dark:bg-gray-800/80 border border-gray-200 dark:border-gray-700 text-sm font-bold text-gray-700 dark:text-gray-200 focus:border-blue-500 dark:focus:border-blue-400 focus:ring-2 focus:ring-blue-500/20 outline-none transition-all shadow-sm hover:shadow-md backdrop-blur-xl">
                        <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400 dark:text-gray-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                    </div>

                    <!-- Category Filter -->
                    <div class="relative">
                        <select name="category"
                                id="categorySelect"
                                class="w-full px-5 py-3 pr-12 pl-10 rounded-2xl bg-white dark:bg-gray-800/80 border border-gray-200 dark:border-gray-700 text-sm font-bold text-gray-700 dark:text-gray-200 focus:border-blue-500 dark:focus:border-blue-400 focus:ring-2 focus:ring-blue-500/20 outline-none transition-all appearance-none cursor-pointer shadow-sm hover:shadow-md backdrop-blur-xl">
                            <option value="">همه دسته‌بندی‌ها</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400 dark:text-gray-500 category-icon">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                        </div>
                    </div>

                    <!-- Sort Select Box -->
                    <div class="relative">
                        <select name="sort"
                                onchange="document.getElementById('filterForm').submit()"
                                class="w-full px-5 py-3 pr-12 pl-10 rounded-2xl bg-white dark:bg-gray-800/80 border border-gray-200 dark:border-gray-700 text-sm font-bold text-gray-700 dark:text-gray-200 focus:border-blue-500 dark:focus:border-blue-400 focus:ring-2 focus:ring-blue-500/20 outline-none transition-all appearance-none cursor-pointer shadow-sm hover:shadow-md backdrop-blur-xl">
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>جدیدترین</option>
                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>ارزان‌ترین</option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>گران‌ترین</option>
                        </select>
                        <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400 dark:text-gray-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"/>
                            </svg>
                        </div>
                        <div class="absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400 dark:text-gray-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Search Button (Mobile) -->
                <div class="mt-4 md:hidden">
                    <button type="submit" class="w-full px-5 py-3 rounded-2xl bg-blue-600 dark:bg-blue-500 text-white font-bold text-sm shadow-lg hover:shadow-xl transition-all">
                        جستجو
                    </button>
                </div>
            </form>

            @if($products->isEmpty())
                <!-- Empty State -->
                <div class="flex flex-col items-center justify-center py-20">
                    <div class="relative w-32 h-32 mb-6">
                        <div class="absolute inset-0 bg-gradient-to-br from-blue-500/20 to-purple-500/20 dark:from-blue-500/10 dark:to-purple-500/10 rounded-full blur-2xl"></div>
                        <div class="relative w-full h-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-full flex items-center justify-center shadow-xl">
                            <svg class="w-16 h-16 text-gray-400 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-2xl font-black text-gray-800 dark:text-gray-200 mb-2">محصولی یافت نشد</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">در حال حاضر محصولی برای نمایش وجود ندارد</p>
                </div>
            @else
                <!-- Products Grid -->
                <div class="flex flex-col gap-3">
                    @foreach($products as $product)
                        @php
                            $finalPrice = $product->price;
                            $hasDiscount = $product->discount > 0;
                            if($hasDiscount) $finalPrice = $product->price - $product->discount;
                        @endphp
                        <div class="relative bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm p-4"
                             data-product-id="{{ $product->id }}">

                            <div class="flex gap-4" style="direction: rtl;">

                                {{-- تصویر - سمت راست --}}
                                <a href="{{ route('product.detail', $product->slug) }}" class="shrink-0">
                                    <img src="@if($product->image) {{ asset('product/'.$product->image) }}@else {{asset('category/'.$product->category->image)}} @endif"
                                         alt="{{ $product->image_alt }}"
                                         title="{{ $product->image_title }}"
                                         class="w-36 h-36 object-cover rounded-xl">
                                </a>

                                {{-- اطلاعات - سمت چپ --}}
                                <div class="flex-1 flex flex-col gap-2" style="text-align: right;">

                                    {{-- نام --}}
                                    <a href="{{ route('product.detail', $product->slug) }}"
                                       class="font-bold text-gray-800 dark:text-white text-base hover:text-primary line-clamp-2">
                                        {{ $product->name }}
                                    </a>

                                    {{-- دسته و کد --}}
                                    <div class="flex items-center gap-2 text-xs text-gray-400">
                                        <a href="{{ route('category', ['slug' => $product->category->slug]) }}"
                                           class="hover:text-primary">
                                            {{ $product->category->name }}
                                        </a>
                                        <span>•</span>
                                        <span>کد: {{ $product->code }}</span>
                                    </div>
                                    @php
                                        $firstSub = ($product->has_sub_product && $product->subProducts->count() > 0)
    ? $product->subProducts->first()
    : null;

$basePrice    = $firstSub ? $firstSub->price    : $product->price;
$baseDiscount = $firstSub ? ($firstSub->discount ?? 0) : $product->discount;
$finalPrice   = $baseDiscount > 0 ? $basePrice - $baseDiscount : $basePrice;$hasDiscount  = $baseDiscount > 0;
                                    @endphp

                                    {{-- زیر محصول --}}
                                    @if($product->has_sub_product && $product->subProducts->count() > 0)
                                        <select class="sub-product-select w-full max-w-xs border border-gray-200 dark:border-gray-600 rounded-lg px-3 py-1.5 text-sm bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200"
                                                data-product-id="{{ $product->id }}">
                                            @foreach($product->subProducts as $sub)
                                                <option value="{{ $sub->id }}"
                                                        data-price="{{ $sub->price }}"
                                                        data-discount="{{ $sub->discount ?? 0 }}">
                                                    {{ $sub->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    @endif

                                    {{-- قیمت + تعداد + دکمه --}}
                                    <div class="flex flex-wrap items-center gap-3 mt-auto">

                                        {{-- قیمت --}}
                                        <div class="price-container flex flex-col items-start gap-0.5" data-product-id="{{ $product->id }}">
                                            @if($hasDiscount)
                                                <div class="discount-box flex items-center gap-1.5">
                                    <span class="text-xs text-gray-400 line-through">
                                        {{ number_format($product->price) }}
                                    </span>
                                                    <span class="text-xs bg-red-500 text-white rounded px-1.5 py-0.5 font-bold">
                                      {{ $basePrice > 0 ? round($baseDiscount * 100 / $basePrice) : 0 }}%

                                    </span>
                                                </div>
                                            @endif
                                            <span class="final-price font-bold text-primary text-lg">
                                {{ number_format($finalPrice) }}
                                <span class="text-xs font-normal text-gray-500">تومان</span>
                            </span>
                                        </div>

                                        {{-- تعداد --}}
                                        <div class="flex items-center border border-gray-200 dark:border-gray-600 rounded-lg overflow-hidden">
                                            <button class="qty-decrease w-8 h-8 flex items-center justify-center text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-700 text-lg font-bold"
                                                    data-product-id="{{ $product->id }}">−</button>
                                            <input type="number" value="1" min="1"
                                                   class="qty-input w-10 h-8 text-center text-sm border-x border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-800 dark:text-white"
                                                   data-product-id="{{ $product->id }}">
                                            <button class="qty-increase w-8 h-8 flex items-center justify-center text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-700 text-lg font-bold"
                                                    data-product-id="{{ $product->id }}">+</button>
                                        </div>

                                        {{-- دکمه سبد --}}
                                        <button class="add-to-cart-btn flex items-center gap-2 bg-primary hover:bg-primary/90 text-white rounded-lg px-4 py-2 text-sm font-bold transition"
                                                data-product-id="{{ $product->id }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                                 viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                            </svg>
                                            <span class="btn-text">افزودن به سبد</span>
                                        </button>

                                    </div>
                                </div>
                            </div>

                            {{-- بج تخفیف روی تصویر --}}
                            @if($hasDiscount)
                                <div class="absolute top-3 right-3 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full pointer-events-none">
                                    {{ $basePrice > 0 ? round($baseDiscount * 100 / $basePrice) : 0 }}%

                                </div>
                            @endif

                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($products->hasPages())
                    <div class="mt-12 flex justify-center">
                        {{ $products->appends(['sort' => request('sort'), 'search' => request('search'), 'category' => request('category')])->links() }}
                    </div>
                @endif
                </div>
                <div class="hidden lg:block w-96 shrink-0">
                    <div class="sticky top-24" id="sidebar-cart">
                        @include('front.partials.cart-sidebar')
                    </div>
                </div>

            </div>
            @endif
        </div>
    </section>
    <!-- END PRODUCTS SECTION -->
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const subProductSelects = document.querySelectorAll('.sub-product-select');

            subProductSelects.forEach(select => {
                select.addEventListener('change', function() {
                    const selectedOption = this.options[this.selectedIndex];
                    const price = parseFloat(selectedOption.dataset.price);
                    const discount = parseFloat(selectedOption.dataset.discount);
                    const productId = this.dataset.productId;

                    const priceContainer = document.querySelector(`.price-container[data-product-id="${productId}"]`);
                    const finalPriceElement = priceContainer.querySelector('.final-price');

                    let finalPrice = price;
                    let discountPercent = 0;

                    if(discount > 0){
                        finalPrice = price - discount;
                        discountPercent = Math.round((discount * 100) / price);
                    }

                    finalPriceElement.textContent = finalPrice.toLocaleString('fa-IR');

                    let discountBox = priceContainer.querySelector('.discount-box');

                    if(discount > 0){
                        if(!discountBox){
                            discountBox = document.createElement('div');
                            discountBox.className = "discount-box flex items-center gap-2 mb-2";
                            priceContainer.prepend(discountBox);
                        }

                        discountBox.innerHTML = `
                            <span class="text-sm text-gray-400 dark:text-gray-500 line-through">
                                ${price.toLocaleString('fa-IR')}
                            </span>
                            <span class="text-xs text-red-500 font-bold">
                                ${discountPercent}%
                            </span>
                        `;
                    }else{
                        if(discountBox){
                            discountBox.remove();
                        }
                    }
                });
            });
            // Quantity controls
            document.querySelectorAll('.qty-increase').forEach(btn => {
                btn.addEventListener('click', function() {
                    const productId = this.dataset.productId;
                    const input = document.querySelector(`.qty-input[data-product-id="${productId}"]`);
                    let value = parseInt(input.value);

                        input.value = value + 1;

                });
            });

            document.querySelectorAll('.qty-decrease').forEach(btn => {
                btn.addEventListener('click', function() {
                    const productId = this.dataset.productId;
                    const input = document.querySelector(`.qty-input[data-product-id="${productId}"]`);
                    let value = parseInt(input.value);
                    if(value > 1) {
                        input.value = value - 1;
                    }
                });
            });

            // Validate quantity input
            document.querySelectorAll('.qty-input').forEach(input => {
                input.addEventListener('input', function() {
                    let value = parseInt(this.value);
                    if(isNaN(value) || value < 1) {
                        this.value = 1;
                    }
                });
            });

            // Add to cart functionality

            document.querySelectorAll('.add-to-cart-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    if(this.disabled) return;

                    const productId = this.dataset.productId;
                    const qtyInput = document.querySelector(`.qty-input[data-product-id="${productId}"]`);
                    const quantity = parseInt(qtyInput.value);

                    // دریافت sub_product_id اگر وجود داشته باشد
                    const subProductSelect = document.querySelector(`.sub-product-select[data-product-id="${productId}"]`);
                    let subProductId = null;

                    if(subProductSelect) {
                        const selectedValue = parseInt(subProductSelect.value);
                        const mainProductId = parseInt(productId);

                        // اگر مقدار انتخاب شده با ID محصول اصلی متفاوت باشد، یعنی sub-product انتخاب شده
                        if(selectedValue !== mainProductId) {
                            subProductId = selectedValue;
                        }
                    }



                    // نمایش لودینگ
                    const btnText = this.querySelector('.btn-text');
                    const originalText = btnText.textContent;
                    btnText.textContent = 'در حال افزودن...';
                    this.disabled = true;

                    // ارسال درخواست AJAX
                    fetch('{{ route("cart.add") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            product_id: productId,
                            sub_product_id: subProductId,
                            quantity: quantity
                        })
                    })
                        .then(response => response.json())
                        .then(data => {


                            if(data.status === 'success') {
                                // به‌روزرسانی شمارنده سبد خرید
                                const cartCounts = document.querySelectorAll('.cart-badge');

                                cartCounts.forEach(cartCount => {
                                    cartCount.textContent = data.cart_count;

                                    cartCount.classList.add('animate-bounce');

                                    setTimeout(() => {
                                        cartCount.classList.remove('animate-bounce');
                                    }, 1000);
                                });

                                // نمایش نوتیفیکیشن موفقیت
                                showNotification('success', data.message);

                                // ریست کردن تعداد
                                qtyInput.value = 1;

                                fetch('{{ route("cart.sidebar") }}')
                                    .then(res => res.text())
                                    .then(html => {
                                        document.getElementById('cart-sidebar-content').innerHTML = html;
                                    });
                                if (window.innerWidth < 1024) {
                                    refreshMobileCartDrawer(true);
                                }
                            } else {
                                showNotification('error', data.message || 'خطا در افزودن به سبد خرید');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showNotification('error', 'خطا در برقراری ارتباط با سرور');
                        })
                        .finally(() => {
                            btnText.textContent = originalText;
                            this.disabled = false;
                        });
                });
            });

        });

        // تابع نمایش نوتیفیکیشن
        function showNotification(type, message) {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 left-1/2 transform -translate-x-1/2 -translate-y-20 z-50 px-6 py-4 rounded-lg shadow-2xl transition-all duration-500 flex items-center gap-3 ${
                type === 'success'
                    ? 'bg-emerald-600 text-white border-2 border-emerald-400'
                    : 'bg-rose-600 text-white border-2 border-rose-400'
            }`;

            const icon = type === 'success'
                ? '<svg class="w-6 h-6 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>'
                : '<svg class="w-6 h-6 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>';

            notification.innerHTML = `${icon}<span class="font-semibold text-lg">${message}</span>`;

            document.body.appendChild(notification);

            setTimeout(() => {
                notification.style.transform = 'translate(-50%, 0)';
            }, 10);

            setTimeout(() => {
                notification.style.transform = 'translate(-50%, -20px)';
                notification.style.opacity = '0';
                setTimeout(() => notification.remove(), 500);
            }, 3000);
        }
    </script>
@endpush
