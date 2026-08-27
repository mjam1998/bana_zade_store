@extends('front.layout.master')

@section('title', $product->meta_title ?: $product->name)

@section('content')
    <style>
        .qty-box {
            display: flex;
            flex-wrap: nowrap;
            width: max-content;
            direction: ltr;
        }
        .qty-box > .btn,
        .qty-box > #qty-input {
            border-radius: 0;
        }
        .qty-box > .btn:first-child {
            border-top-left-radius: .375rem;
            border-bottom-left-radius: .375rem;
        }
        .qty-box > .btn:last-child {
            border-top-right-radius: .375rem;
            border-bottom-right-radius: .375rem;
            margin-right: -1px;
        }
        .qty-box > #qty-input {
            width: 4rem;
            min-width: 4rem;
            margin-left: -1px;
            z-index: 2;
        }
        .qty-box > .btn {
            width: 2.5rem;
            flex: 0 0 2.5rem;
        }
    </style>


    @php
        $imagePath = $product->image
            ?? optional($product->category)->image;
        $imageUrl =  $product->image ? asset('product/'.$imagePath) : asset('category/'.$imagePath);

        $discountedBasePrice = $product->discount > 0
            ? round($product->base_price * (1 - $product->discount / 100))
            : $product->base_price;

        $tiers = $product->productPriceTiers->map(fn ($t) => [
            'min_qty' => $t->min_qty,
            'max_qty' => $t->max_qty,
            'unit_price' => (float) $t->unit_price,
        ])->values();
    @endphp

    <div class="container py-4">
        <div class="row g-4">
            {{-- تصویر محصول --}}
            <div class="col-lg-5">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    @if($product->discount > 0)
                        <span class="badge bg-danger position-absolute top-0 end-0 m-2 fs-6 px-3 py-2 rounded-pill">
                {{ $product->discount }}%-
            </span>
                    @endif
                    <img src="{{ $imageUrl }}"
                         alt="{{ $product->image_alt ?: $product->name }}"
                         title="{{ $product->image_title ?: $product->name }}"
                         class="img-fluid w-100" style="aspect-ratio: 1/1; object-fit: cover;">
                </div>
                @if($product->category)
                    <span class="badge bg-light text-dark border mt-2">{{ $product->category->name }}</span>
                @endif
            </div>

            {{-- اطلاعات و خرید --}}
            <div class="col-lg-7">
                <h1 class="h4 fw-bold mb-2">{{ $product->name }}</h1>

                @if($product->count <= 0)
                    <span class="badge bg-danger mb-3">ناموجود</span>
                @endif

                {{-- باکس قیمت زنده --}}
                <div class="card border-0 bg-light rounded-4 p-3 mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="text-muted small">قیمت واحد</span>
                        <div class="text-end">
                            @if($product->discount > 0)
                                <span class="text-decoration-line-through text-muted small d-block" id="old-unit-price">
                                {{ number_format($product->base_price) }} تومان
                            </span>
                            @endif
                            <span class="fw-bold fs-5" id="unit-price">
                            {{ number_format($discountedBasePrice) }} تومان
                        </span>
                        </div>
                    </div>
                    <hr class="my-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-semibold">مبلغ کل</span>
                        <span class="fw-bold fs-5 text-primary" id="total-price">
                        {{ number_format($discountedBasePrice * ($product->min_shop_count ?: 1)) }} تومان
                    </span>
                    </div>
                </div>

                {{-- فرم افزودن به سبد خرید --}}
                <form action="#" method="POST" id="add-to-cart-form">
                    @csrf
                    <div class="d-flex align-items-start gap-3 mb-3 flex-wrap">
                        <label class="fw-semibold small mb-0 mt-2">تعداد ({{ $product->unit_name ?: 'عدد' }}):</label>
                        <div>
                            <div class="input-group qty-box">
                                <button type="button" class="btn btn-outline-secondary" id="qty-decrease">-</button>
                                <input type="text"
                                       inputmode="numeric"
                                       pattern="[0-9]*"
                                       name="quantity"
                                       id="qty-input"
                                       class="form-control text-center"
                                       value="{{ max($product->min_shop_count ?? 1, 1) }}"
                                       data-min="{{ max($product->min_shop_count ?? 1, 1) }}"
                                       data-max="{{ $product->count }}"
                                       autocomplete="off">
                                <button type="button" class="btn btn-outline-secondary" id="qty-increase">+</button>
                            </div>
                            @if($product->min_shop_count && $product->min_shop_count > 1)
                                <small class="text-muted d-block mt-1">
                                    حداقل خرید: {{ $product->min_shop_count }} {{ $product->unit_name ?: 'عدد' }}
                                </small>
                            @endif
                        </div>
                    </div>



                    <button type="submit" class="btn btn-primary rounded-pill px-4" @disabled($product->count <= 0)>
                        {{ $product->count > 0 ? 'افزودن به سبد خرید' : 'ناموجود' }}
                    </button>
                </form>

                {{-- جدول قیمت پلکانی --}}
                @if($tiers->isNotEmpty())
                    <div class="mt-4">
                        <h2 class="h6 fw-bold mb-2">تخفیف پلکانی بر اساس تعداد</h2>
                        <div class="table-responsive" >
                            <table class="table table-sm table-bordered text-center align-middle" id="price-tier-table">
                                <thead class="table-light">
                                <tr>
                                    <th>تعداد</th>
                                    <th>قیمت واحد</th>
                                    <th>تخفیف نسبت به قیمت پایه</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($product->productPriceTiers as $tier)
                                    <tr data-min="{{ $tier->min_qty }}" data-max="{{ $tier->max_qty }}">
                                        <td>
                                            {{ $tier->min_qty }}
                                            @if($tier->max_qty) تا {{ $tier->max_qty }} @else به بالا @endif
                                        </td>
                                        <td>{{ number_format($tier->unit_price) }} تومان</td>
                                        <td class="text-success">{{ $tier->discount_percent }}%</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{-- توضیحات محصول (HTML از ادیتور) --}}
        <div class="card border-0 shadow-sm rounded-4 p-4 mt-4">
            <h2 class="h6 fw-bold mb-3">توضیحات محصول</h2>
            <div class="product-description">
                {!! $product->description !!}
            </div>
        </div>
        @if(!empty($product->keywords_array))
            <div class="mt-2">
                @foreach($product->keywords_array as $keyword)
                    <span class="badge bg-secondary-subtle text-dark border me-1">{{ $keyword }}</span>
                @endforeach
            </div>
        @endif

        {{-- نظرات --}}
        <div class="card  border-0 shadow-sm rounded-4 p-4 mt-4">
            <h2 class="h6 fw-bold mb-3">نظرات کاربران ({{ $comments->count() }})</h2>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="mb-4">
                @forelse($comments as $comment)
                    <div class="border rounded-3 p-3 mb-2">
                        <div class="d-flex justify-content-between">
                            <span class="fw-semibold small">{{ $comment->name }}</span>
                            <span class="text-muted small">{{ $comment->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="mb-0 mt-1 small">{{ $comment->comment }}</p>

                        @if($comment->admin_response)
                            <div class="bg-light rounded-3 p-2 mt-2 border-start border-primary border-3">
                                <span class="fw-semibold small text-primary d-block">پاسخ پشتیبانی</span>
                                <span class="small">{{ $comment->admin_response }}</span>
                            </div>
                        @endif
                    </div>
                    @if($comments->hasPages())
                        <div class="d-flex justify-content-center mt-5">
                            {{ $comments->links('pagination::bootstrap-5') }}
                        </div>
                    @endif
                @empty
                    <p class="text-muted small" >هنوز نظری ثبت نشده است .</p>
                @endforelse
            </div>

            <form action="{{ route('product.comment.store', $product->slug) }}" method="POST">
                @csrf
                <div class="mb-2">
                    <input type="text" name="name" class="form-control" placeholder="نام شما" required maxlength="100">
                </div>
                <div class="mb-2">
                    <textarea name="comment" class="form-control" rows="3" placeholder="متن نظر" required maxlength="2000"></textarea>
                </div>
                <button type="submit" class="btn btn-dark rounded-pill px-4">ارسال نظر</button>
            </form>
        </div>
    </div>


@endsection

@push('scripts')
    <script>
        (function () {
            const tiers = @json($tiers);
            const basePrice = {{ $product->base_price }};
            const discountPercent = {{ (float) $product->discount }};

            const qtyInput = document.getElementById('qty-input');
            const unitPriceEl = document.getElementById('unit-price');
            const oldUnitPriceEl = document.getElementById('old-unit-price');
            const totalPriceEl = document.getElementById('total-price');
            const tierRows = document.querySelectorAll('#price-tier-table tbody tr');

            function toEnglishDigits(str) {
                return String(str || '').replace(/[۰-۹]/g, d => '۰۱۲۳۴۵۶۷۸۹'.indexOf(d))
                    .replace(/[٠-٩]/g, d => '٠١٢٣٤٥٦٧٨٩'.indexOf(d));
            }

            function parseQty(value) {
                return parseInt(toEnglishDigits(value), 10);
            }

            function formatNumber(num) {
                return new Intl.NumberFormat('fa-IR').format(Math.round(num));
            }

            function findTier(qty) {
                return tiers.find(t => qty >= t.min_qty && (t.max_qty === null || qty <= t.max_qty));
            }

            function recalculate() {
                let qty = parseQty(qtyInput.value);
                const min = parseQty(qtyInput.dataset.min) || 1;
                const max = parseQty(qtyInput.dataset.max);

                if (isNaN(qty) || qty < min) qty = min;
                if (!isNaN(max) && qty > max) qty = max;

                qtyInput.value = qty;

                const tier = findTier(qty);
                let unitPrice;

                if (tier) {
                    unitPrice = tier.unit_price;
                    if (oldUnitPriceEl) oldUnitPriceEl.style.display = 'none';
                } else {
                    unitPrice = discountPercent > 0
                        ? basePrice * (1 - discountPercent / 100)
                        : basePrice;
                    if (oldUnitPriceEl) oldUnitPriceEl.style.display = discountPercent > 0 ? 'block' : 'none';
                }

                unitPriceEl.textContent = formatNumber(unitPrice) + ' تومان';
                totalPriceEl.textContent = formatNumber(unitPrice * qty) + ' تومان';

                tierRows.forEach(row => {
                    const rowMin = parseInt(row.dataset.min, 10);
                    const rowMax = row.dataset.max ? parseInt(row.dataset.max, 10) : null;
                    const active = qty >= rowMin && (rowMax === null || qty <= rowMax);
                    row.classList.toggle('table-primary', active);
                });
            }

            document.getElementById('qty-increase').addEventListener('click', function () {
                qtyInput.value = (parseQty(qtyInput.value) || 0) + 1;
                recalculate();
            });

            document.getElementById('qty-decrease').addEventListener('click', function () {
                qtyInput.value = (parseQty(qtyInput.value) || 0) - 1;
                recalculate();
            });

            qtyInput.addEventListener('input', recalculate);
            recalculate();
        })();
    </script>
@endpush

