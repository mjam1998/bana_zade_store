@extends('front.layout.master')
@section('title', 'سبد خرید')

@section('content')
    <div class="container py-5 mt-5">
        <h1 class="h3 fw-bold mb-4">سبد خرید شما</h1>

        @if(count($cart) > 0)
            @php
                $grandOriginalTotal = 0; // جمع کل بدون تخفیف
                $grandTotal = 0;         // جمع کل پرداختی
                $totalDiscount = 0;      // سود شما (مجموع تخفیف‌ها)
            @endphp
            <div class="row g-4">
                {{-- لیست محصولات --}}
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm rounded-4 p-3">
                        @foreach($products as $product)
                            @php
                                $qty = $cart[$product->id];
                                $imagePath = $product->image ?? optional($product->category)->image;
                                $imageUrl = $product->image ? asset('product/'.$imagePath) : asset('category/'.$imagePath);

                                $basePrice = $product->base_price;
                                $unitPrice = $product->unitPriceFor($qty);

                                // اگر قیمت پلکانی اعمال نشده بود، تخفیف درصدی عادی را چک کن
                                if ($unitPrice == $basePrice && $product->discount > 0) {
                                    $unitPrice = round($basePrice * (1 - $product->discount / 100));
                                }

                                $itemOriginalTotal = $basePrice * $qty;
                                $itemFinalTotal = $unitPrice * $qty;

                                $itemDiscountAmount = $itemOriginalTotal - $itemFinalTotal;
                                $itemDiscountPercent = $basePrice > 0 ? round(($basePrice - $unitPrice) / $basePrice * 100) : 0;

                                $grandOriginalTotal += $itemOriginalTotal;
                                $grandTotal += $itemFinalTotal;
                                $totalDiscount += $itemDiscountAmount;
                            @endphp

                            <div class="row align-items-center mb-3 cart-item" id="cart-item-{{ $product->id }}">
                                <div class="col-3 col-md-2">
                                    <img src="{{ $imageUrl }}" class="img-fluid rounded" alt="{{ $product->name }}">
                                </div>

                                <div class="col-9 col-md-4">
                                    <h5 class="h6 mb-1 fw-bold">{{ $product->name }}</h5>
                                    <small class="text-muted d-block">حداقل خرید: {{ $product->min_shop_count ?: 1 }} عدد</small>

                                    {{-- تگ بج همیشه رندر می‌شود، وضعیت نمایش با CSS کنترل می‌شود --}}
                                    <span class="badge bg-danger mt-1 item-discount-badge" id="badge-{{ $product->id }}"
                                          style="display: {{ $itemDiscountPercent > 0 ? 'inline-block' : 'none' }};">
                                        {{ $itemDiscountPercent }}% تخفیف
                                    </span>
                                </div>

                                <div class="col-6 col-md-3 mt-3 mt-md-0">
                                    <div class="input-group input-group-sm w-100" style="direction: ltr;">
                                        <button class="btn btn-outline-secondary cart-qty-btn" data-action="decrease" data-id="{{ $product->id }}">-</button>
                                        <input type="text" class="form-control text-center fw-bold"
                                               id="qty-{{ $product->id }}"
                                               value="{{ $qty }}"
                                               data-min="{{ $product->min_shop_count ?: 1 }}"
                                               data-max="{{ $product->count }}" readonly>
                                        <button class="btn btn-outline-secondary cart-qty-btn" data-action="increase" data-id="{{ $product->id }}">+</button>
                                    </div>
                                </div>

                                <div class="col-6 col-md-3 mt-3 mt-md-0 text-end d-flex flex-column justify-content-center">

                                    {{-- تگ قیمت خط‌خورده همیشه رندر می‌شود --}}
                                    <del class="text-muted small item-original-total" id="orig-total-{{ $product->id }}"
                                         style="display: {{ $itemDiscountAmount > 0 ? 'inline' : 'none' }};">
                                        {{ number_format($itemOriginalTotal) }}
                                    </del>

                                    <span class="fw-bold text-success item-total" id="total-{{ $product->id }}">
                                        {{ number_format($itemFinalTotal) }} تومان
                                    </span>
                                    <button class="btn btn-sm text-danger mt-1 remove-item" data-id="{{ $product->id }}">حذف</button>
                                </div>
                            </div>
                            @if(!$loop->last) <hr class="my-3"> @endif
                        @endforeach
                    </div>
                </div>

                {{-- خلاصه سفارش --}}
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm rounded-4 p-4 sticky-top" style="top: 120px;">
                        <h5 class="fw-bold mb-4">خلاصه سفارش</h5>

                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted">قیمت کالاها</span>
                            <span id="grand-orig-total">{{ number_format($grandOriginalTotal) }} تومان</span>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-3 text-danger">
                            <span>سود شما از خرید</span>
                            <span id="grand-discount">{{ number_format($totalDiscount) }} تومان</span>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="fw-bold">جمع کل پرداختی</span>
                            <span class="fw-bold fs-5 text-success" id="grand-total">{{ number_format($grandTotal) }} تومان</span>
                        </div>

                        <a href="#" class="btn btn-primary w-100 mt-3 rounded-pill py-2">ادامه فرآیند خرید</a>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-cart-x fs-1 text-danger"></i>
                <h4 class="mt-3">سبد خرید شما خالی است.</h4>
                <a href="{{ route('home') }}" class="btn btn-primary mt-3">بازگشت به فروشگاه</a>
            </div>
        @endif
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // تابع کمکی برای فرمت کردن اعداد به صورت سه‌رقم سه‌رقم
            const formatNumber = (num) => new Intl.NumberFormat('fa-IR').format(num);

            // تابع اصلی برای به‌روزرسانی DOM پس از دریافت پاسخ از سرور
            function updateView(data) {
                // ۱. به‌روزرسانی آیتم خاصی که تغییر کرده
                if (data.itemData) {
                    const item = data.itemData;
                    const itemRow = document.getElementById(`cart-item-${item.id}`);

                    if (itemRow) {
                        // قیمت نهایی آیتم
                        const finalTotalEl = itemRow.querySelector(`#total-${item.id}`);
                        if (finalTotalEl) {
                            finalTotalEl.innerText = `${formatNumber(item.finalTotal)} تومان`;
                        }

                        // قیمت خط‌خورده
                        const originalTotalEl = itemRow.querySelector(`#orig-total-${item.id}`);
                        if (originalTotalEl) {
                            if (item.originalTotal > item.finalTotal) {
                                originalTotalEl.innerText = formatNumber(item.originalTotal);
                                originalTotalEl.style.display = 'inline';
                            } else {
                                originalTotalEl.style.display = 'none';
                            }
                        }

                        // بج تخفیف
                        const badgeEl = itemRow.querySelector(`#badge-${item.id}`);
                        if (badgeEl) {
                            if (item.discountPercent > 0) {
                                badgeEl.innerText = `${item.discountPercent}% تخفیف`;
                                badgeEl.style.display = 'inline-block';
                            } else {
                                badgeEl.style.display = 'none';
                            }
                        }
                    }
                }

                // ۲. به‌روزرسانی خلاصه سفارش (همیشه)
                const cartSummary = data.cartData;
                document.getElementById('grand-orig-total').innerText = `${formatNumber(cartSummary.grandOriginalTotal)} تومان`;
                document.getElementById('grand-discount').innerText = `${formatNumber(cartSummary.totalDiscount)} تومان`;
                document.getElementById('grand-total').innerText = `${formatNumber(cartSummary.grandTotal)} تومان`;

                // ۳. به‌روزرسانی تعداد آیتم‌ها در هدر
                const badgeCount = document.getElementById('cart-badge-count');
                if (badgeCount) {
                    badgeCount.innerText = data.cartItemCount;
                    badgeCount.style.display = data.cartItemCount > 0 ? 'block' : 'none';
                }

                // ۴. اگر سبد خرید خالی شد، صفحه را رفرش کن تا پیام "سبد خالی" نمایش داده شود
                if (data.cartItemCount === 0) {
                    location.reload();
                }
            }

            // تابع برای ارسال درخواست آپدیت تعداد
            function updateCartItem(id, qty, button) {
                // دکمه‌ها را غیرفعال کن تا از کلیک‌های تکراری جلوگیری شود
                const buttons = document.querySelectorAll(`[data-id='${id}']`);
                buttons.forEach(btn => btn.disabled = true);

                fetch(`/cart/update/${id}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ quantity: qty })
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            updateView(data);
                        } else {
                            // اگر سرور خطا داد، مقدار را به حالت قبل برگردان (این بخش اختیاری و برای بهبود UX است)
                            alert(data.message || "خطایی رخ داد");
                        }
                    }).catch(err => console.error(err))
                    .finally(() => {
                        buttons.forEach(btn => btn.disabled = false); // دکمه‌ها را دوباره فعال کن
                    });
            }

            // رویداد برای دکمه‌های افزایش/کاهش
            document.querySelectorAll('.cart-qty-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const action = this.dataset.action;
                    const id = this.dataset.id;
                    const input = document.getElementById('qty-' + id);
                    let currentVal = parseInt(input.value);
                    const min = parseInt(input.dataset.min);
                    const max = parseInt(input.dataset.max);
                    const originalVal = currentVal;

                    if (action === 'increase' && currentVal < max) currentVal++;
                    else if (action === 'decrease' && currentVal > min) currentVal--;

                    if (currentVal !== originalVal) {
                        input.value = currentVal;
                        updateCartItem(id, currentVal, this);
                    }
                });
            });

            // رویداد برای دکمه حذف
            document.querySelectorAll('.remove-item').forEach(btn => {
                btn.addEventListener('click', function() {
                    const id = this.dataset.id;
                    if (!confirm('آیا از حذف این محصول اطمینان دارید؟')) return;

                    fetch(`/cart/remove/${id}`, {
                        method: 'POST',
                        headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
                    })
                        .then(res => res.json())
                        .then(data => {
                            if(data.success) {
                                // حذف المان آیتم از DOM
                                document.getElementById(`cart-item-${id}`).remove();
                                updateView(data); // به‌روزرسانی خلاصه سبد و هدر
                            }
                        }).catch(err => console.error(err));
                });
            });
        });
    </script>
@endpush
