@extends('front.layout.master')

@section('content')

    <section class="py-5">
        <div class="container">

            {{-- عنوان --}}
            <div class="mb-4">
                <h2 class="fw-bold text-primary mb-0">محصولات</h2>
                <p class="text-muted mt-1">{{ $products->total() }} محصول یافت شد</p>
            </div>

            <div class="row g-4">

                {{-- ستون فیلتر --}}
                <div class="col-lg-3">
                    <div class="card border-0 shadow-sm rounded-4 sticky-top" style="top: 80px;">
                        <div class="card-body p-4">
                            <form method="GET" action="{{ route('products') }}" id="filterForm">

                                {{-- جستجو --}}
                                <div class="mb-4">
                                    <label class="form-label fw-semibold text-dark mb-2">
                                        <i class="bi bi-search ms-1"></i> جستجو
                                    </label>
                                    <input type="text"
                                           name="search"
                                           class="form-control rounded-3"
                                           placeholder="نام محصول..."
                                           value="{{ request('search') }}">
                                </div>

                                <hr class="my-3 text-muted opacity-25">

                                {{-- فیلتر دسته‌بندی (اصلاح شده با slug) --}}
                                <div class="mb-4">
                                    <label class="form-label fw-semibold text-dark mb-2">
                                        <i class="bi bi-grid ms-1"></i> دسته‌بندی
                                    </label>
                                    <select name="category" class="form-select rounded-3" id="categorySelect">
                                        <option value="">همه دسته‌بندی‌ها</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->slug }}"
                                                @selected(request('category') === $category->slug)>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <hr class="my-3 text-muted opacity-25">

                                {{-- مرتب‌سازی --}}
                                <div class="mb-4">
                                    <label class="form-label fw-semibold text-dark mb-2">
                                        <i class="bi bi-sort-down ms-1"></i> مرتب‌سازی
                                    </label>
                                    <div class="d-flex flex-column gap-2">
                                        @foreach([
                                            'newest'    => 'جدیدترین',
                                            'cheapest'  => 'ارزان‌ترین',
                                            'expensive' => 'گران‌ترین',
                                        ] as $value => $label)
                                            <div class="form-check">
                                                <input class="form-check-input sort-radio"
                                                       type="radio"
                                                       name="sort"
                                                       id="sort_{{ $value }}"
                                                       value="{{ $value }}"
                                                    @checked(request('sort', 'newest') === $value)>
                                                <label class="form-check-label" for="sort_{{ $value }}">
                                                    {{ $label }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <hr class="my-3 text-muted opacity-25">

                                {{-- فیلتر قیمت --}}
                                <div class="mb-4">
                                    <label class="form-label fw-semibold text-dark mb-2">
                                        <i class="bi bi-cash-stack ms-1"></i> بازه قیمت (تومان)
                                    </label>
                                    <div class="d-flex gap-2">
                                        <input type="number"
                                               name="min_price"
                                               class="form-control form-control-sm rounded-3 text-center"
                                               placeholder="از"
                                               value="{{ request('min_price') }}">
                                        <input type="number"
                                               name="max_price"
                                               class="form-control form-control-sm rounded-3 text-center"
                                               placeholder="تا"
                                               value="{{ request('max_price') }}">
                                    </div>
                                </div>

                                <hr class="my-3 text-muted opacity-25">

                                {{-- فیلتر تخفیف --}}
                                <div class="mb-4">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input"
                                               type="checkbox"
                                               role="switch"
                                               name="has_discount"
                                               id="has_discount"
                                               value="1"
                                            @checked(request('has_discount') == '1')>
                                        <label class="form-check-label fw-semibold" for="has_discount">
                                            فقط محصولات تخفیف‌دار
                                        </label>
                                    </div>
                                </div>

                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary rounded-3">
                                        <i class="bi bi-funnel me-1"></i> اعمال فیلتر
                                    </button>
                                    <a href="{{ route('products') }}" class="btn btn-outline-secondary rounded-3">
                                        <i class="bi bi-arrow-counterclockwise me-1"></i> پاک‌سازی
                                    </a>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>


                {{-- ستون محصولات --}}
                <div class="col-lg-9">

                    @forelse($products as $product)
                        @php
                            $finalPrice = $product->discount > 0
                                ? $product->base_price - ($product->discount * $product->base_price / 100)
                                : $product->base_price;
                        @endphp

                        {{-- ردیف کارت‌ها: ۳ تا در هر سطر --}}
                        @if($loop->first)
                            <div class="row g-4">
                                @endif

                                <div class="col-sm-6 col-xl-4">
                                    <div class="card product-card h-100 border-0 shadow-sm rounded-4 overflow-hidden position-relative">
                                        <a href="{{ route('product.show', $product->slug) }}" class="text-decoration-none text-reset">
                                        {{-- بج تخفیف --}}
                                        @if($product->discount > 0)
                                            <span class="position-absolute top-0 start-0 m-2 badge rounded-pill text-white"
                                                  style="background: #e63946; font-size: 0.75rem; z-index: 1;">
                                    ٪{{ $product->discount }} تخفیف
                                </span>
                                        @endif

                                        @if($product->image)
                                            <img src="{{ asset('product/' . $product->image) }}"
                                                 alt="{{ $product->image_alt }}"
                                                 title="{{ $product->image_title }}"
                                                 class="card-img-top"
                                                 style="height: 200px; object-fit: cover;">
                                        @else
                                            <img src="{{ asset('category/' . $product->category->image) }}"
                                                 alt="{{ $product->category->image_alt }}"
                                                 title="{{ $product->category->image_title }}"
                                                 class="card-img-top"
                                                 style="height: 200px; object-fit: cover;">
                                        @endif


                                        <div class="card-body d-flex flex-column p-3">
                                            <h6 class="fw-bold mb-2 lh-base" style="min-height: 2.8rem;">
                                                {{ $product->name }}
                                            </h6>

                                            <div class="text-muted small mb-1">
                                                <i class="bi bi-box me-1"></i>واحد: {{ $product->unit_name }}
                                            </div>
                                            <div class="text-muted small mb-3">
                                                <i class="bi bi-basket me-1"></i>حداقل سفارش: {{ $product->min_shop_count }}
                                            </div>

                                            <div class="mt-auto d-flex justify-content-between align-items-end">
                                                <div>
                                                    @if($product->discount > 0)
                                                        <div class="text-muted text-decoration-line-through small">
                                                            {{ number_format($product->base_price) }}
                                                        </div>
                                                    @endif
                                                    <div class="fw-bold {{ $product->discount > 0 ? 'text-danger' : 'text-primary' }}"
                                                         style="font-size: 1.05rem;">
                                                        {{ number_format($finalPrice) }}
                                                        <span class="text-muted fw-normal small">تومان</span>
                                                    </div>
                                                </div>
                                                <button class="btn btn-light rounded-circle shadow-sm"
                                                        style="width: 42px; height: 42px; padding: 0;"
                                                        aria-label="افزودن به سبد خرید">
                                                    <i class="bi bi-cart-plus text-primary fs-5"></i>
                                                </button>
                                            </div>
                                        </div>
                                        </a>
                                    </div>
                                </div>

                                @if($loop->last)
                            </div>
                        @endif

                    @empty
                        <div class="d-flex flex-column align-items-center justify-content-center py-5 text-muted">
                            <i class="bi bi-box-seam" style="font-size: 3rem; opacity: 0.3;"></i>
                            <p class="mt-3 mb-0">محصولی با این مشخصات پیدا نشد.</p>
                            <a href="{{ route('products') }}" class="btn btn-sm btn-outline-primary mt-3 rounded-pill">
                                نمایش همه محصولات
                            </a>
                        </div>
                    @endforelse

                    {{-- Pagination --}}
                    @if($products->hasPages())
                        <div class="d-flex justify-content-center mt-5">
                            {{ $products->links('pagination::bootstrap-5') }}
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </section>

    @push('scripts')
        <script>
            // مرتب‌سازی با radio → submit خودکار
            document.querySelectorAll('.sort-radio').forEach(radio => {
                radio.addEventListener('change', () => {
                    document.getElementById('filterForm').submit();
                });
            });
        </script>
        <script>

            document.addEventListener('DOMContentLoaded', function () {

                const element = document.getElementById('categorySelect');

                new Choices(element, {

                    searchEnabled: true,
                    removeItemButton: true,
                    shouldSort: false,
                    rtl: true,
                    placeholderValue: 'جستجوی دسته بندی...',
                    noResultsText: 'نتیجه‌ای یافت نشد',
                    noChoicesText: 'دسته بندی وجود ندارد',
                    itemSelectText: '',
                });

            });

        </script>
    @endpush

@endsection

