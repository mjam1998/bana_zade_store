@extends('front.layout.master')

@section('content')
    <!-- Hero Section -->
    <section class="hero text-center">
        <div class="container position-relative z-1">
            <h1 class="display-4 fw-bold mb-4">  بازرگانی بنازاده</h1>
            <p class="lead mb-5 opacity-75 fw-light mx-auto" style="max-width: 700px;"> تأمین مستقیم مواد غذایی با بهترین قیمت برای فروشگاه‌ها، رستوران‌ها و عمده‌فروشان سراسر کشور مستقیم از کارخانه</p>
            <div class="d-flex justify-content-center gap-3 flex-wrap">
                <a href="#products" class="btn btn-light text-primary btn-lg px-5 shadow">مشاهده محصولات</a>

            </div>
        </div>
    </section>

    <!-- Categories -->
    <section id="categories" class="py-5 mt-4">
        <div class="container position-relative">
            <div class="d-flex justify-content-between align-items-center mb-5">
                <h2 class="fw-bold mb-0 text-primary">دسته‌بندی‌ها</h2>
                <a href="#" class="btn btn-sm btn-outline-primary rounded-pill px-4">همه دسته‌ها</a>
            </div>

            <!-- Swiper -->
            <div class="swiper categorySwiper pb-4 px-2">
                <div class="swiper-wrapper">
                    <!-- دسته ۱ -->
                    <div class="swiper-slide">
                        <div class="card category-card text-center h-100">
                            <div class="card-body py-4">
                                <img src="assets/img/rice.jpg" alt="نوشیدنی‌ها" class="category-img mb-3 mx-auto d-block">
                                <h6 class="mb-0 fw-bold">نوشیدنی‌ها</h6>
                                <i class="bi bi-arrow-left-short category-arrow"></i>
                            </div>
                        </div>
                    </div>
                    <!-- دسته ۲ -->
                    <div class="swiper-slide">
                        <div class="card category-card text-center h-100">
                            <div class="card-body py-4">
                                <img src="assets/img/rice.jpg" alt="لبنیات" class="category-img mb-3 mx-auto d-block">
                                <h6 class="mb-0 fw-bold">لبنیات</h6>
                                <i class="bi bi-arrow-left-short category-arrow"></i>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="card category-card text-center h-100">
                            <div class="card-body py-4">
                                <img src="assets/img/rice.jpg" alt="لبنیات" class="category-img mb-3 mx-auto d-block">
                                <h6 class="mb-0 fw-bold">لبنیات</h6>
                                <i class="bi bi-arrow-left-short category-arrow"></i>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="card category-card text-center h-100">
                            <div class="card-body py-4">
                                <img src="assets/img/rice.jpg" alt="لبنیات" class="category-img mb-3 mx-auto d-block">
                                <h6 class="mb-0 fw-bold">لبنیات</h6>
                                <i class="bi bi-arrow-left-short category-arrow"></i>
                            </div>
                        </div>
                    </div>
                    <!-- دسته ۳ -->
                    <div class="swiper-slide">
                        <div class="card category-card text-center h-100">
                            <div class="card-body py-4">
                                <img src="assets/img/rice.jpg" alt="حبوبات و غلات" class="category-img mb-3 mx-auto d-block">
                                <h6 class="mb-0 fw-bold">حبوبات و غلات</h6>
                                <i class="bi bi-arrow-left-short category-arrow"></i>
                            </div>
                        </div>
                    </div>
                    <!-- دسته ۴ -->
                    <div class="swiper-slide">
                        <div class="card category-card text-center h-100">
                            <div class="card-body py-4">
                                <img src="assets/img/rice.jpg" alt="روغن و چاشنی" class="category-img mb-3 mx-auto d-block">
                                <h6 class="mb-0 fw-bold">روغن و چاشنی</h6>
                                <i class="bi bi-arrow-left-short category-arrow"></i>
                            </div>
                        </div>
                    </div>
                    <!-- دسته ۵ -->
                    <div class="swiper-slide">
                        <div class="card category-card text-center h-100">
                            <div class="card-body py-4">
                                <img src="assets/img/rice.jpg" alt="مواد بسته‌بندی" class="category-img mb-3 mx-auto d-block">
                                <h6 class="mb-0 fw-bold">مواد بسته‌بندی</h6>
                                <i class="bi bi-arrow-left-short category-arrow"></i>
                            </div>
                        </div>
                    </div>
                    <!-- دسته ۶ -->
                    <div class="swiper-slide">
                        <div class="card category-card text-center h-100">
                            <div class="card-body py-4">
                                <img src="assets/img/rice.jpg" alt="منجمد و یخچالی" class="category-img mb-3 mx-auto d-block">
                                <h6 class="mb-0 fw-bold">منجمد و یخچالی</h6>
                                <i class="bi bi-arrow-left-short category-arrow"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="promo-banner d-flex align-items-center p-4 p-md-5"
                 style="background: linear-gradient(135deg, #0d6efd 0%, #06357a 100%); border-radius:  40px 40px; box-shadow: 0 10px 30px rgba(13,110,253,0.15); overflow: hidden;">
                <div class="d-flex flex-column flex-md-row align-items-center justify-content-between w-100 gap-4">
                    <div class="text-white text-center text-md-start">
                        <h3 class="fw-bold mb-2">هر چقدر بیشتر بخری، ارزان‌تر می‌شه!</h3>
                        <p class="mb-0 fs-5" style="opacity:0.85;">با افزایش تعداد و حجم خرید، قیمت هر محصول کاهش می‌یابد</p>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <!-- Products: Discounted (Slider) -->
    <section id="discounted-products" class="py-5 discount-section">
        <div class="container position-relative">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold mb-0 text-danger"><i class="bi bi-tags me-2"></i>محصولات با تخفیف ویژه</h2>

                <a href="#" class="btn btn-sm btn-outline-danger rounded-pill px-4">مشاهده همه تخفیف‌ها</a>
            </div>

            <!-- Swiper -->
            <div class="swiper productSwiper pb-4 px-2">
                <div class="swiper-wrapper">
                    <!-- Discount Product 1 -->
                    <div class="swiper-slide">
                        <div class="card product-card h-100 border-danger border-opacity-25">
                            <div class="position-relative">
                                <img src="assets/img/rice.jpg" class="card-img-top product-img" alt="شکر">
                                <span class="badge-discount position-absolute top-0 start-0 m-3">٪۱۵ تخفیف</span>
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h6 class="card-title fw-bold mb-2">شکر سفید ۵۰ کیلویی (فروش ویژه)</h6>
                                <p class="text-muted small mb-3"><i class="bi bi-box me-1"></i>حداقل سفارش: ۲ گونی</p>
                                <div class="d-flex justify-content-between align-items-end mt-auto">
                                    <div>
                                        <div class="old-price text-decoration-line-through text-muted small">۲٬۴۵۰٬۰۰۰</div>
                                        <div class="price text-danger fw-bold fs-5">۲٬۰۸۲٬۵۰۰ <span class="fs-6 text-muted fw-normal">تومان</span></div>
                                    </div>
                                    <button class="btn cart-btn">
                                        <i class="bi bi-cart-plus fs-5"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Discount Product 1 -->
                    <div class="swiper-slide">
                        <div class="card product-card h-100 border-danger border-opacity-25">
                            <div class="position-relative">
                                <img src="assets/img/rice.jpg" class="card-img-top product-img" alt="شکر">
                                <span class="badge-discount position-absolute top-0 start-0 m-3">٪۱۵ تخفیف</span>
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h6 class="card-title fw-bold mb-2">شکر سفید ۵۰ کیلویی (فروش ویژه)</h6>
                                <p class="text-muted small mb-3"><i class="bi bi-box me-1"></i>حداقل سفارش: ۲ گونی</p>
                                <div class="d-flex justify-content-between align-items-end mt-auto">
                                    <div>
                                        <div class="old-price text-decoration-line-through text-muted small">۲٬۴۵۰٬۰۰۰</div>
                                        <div class="price text-danger fw-bold fs-5">۲٬۰۸۲٬۵۰۰ <span class="fs-6 text-muted fw-normal">تومان</span></div>
                                    </div>
                                    <button class="btn btn-danger rounded-circle shadow-sm text-white" style="padding: 10px 12px;">
                                        <i class="bi bi-cart-plus fs-5"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Discount Product 1 -->
                    <div class="swiper-slide">
                        <div class="card product-card h-100 border-danger border-opacity-25">
                            <div class="position-relative">
                                <img src="assets/img/rice.jpg" class="card-img-top product-img" alt="شکر">
                                <span class="badge-discount position-absolute top-0 start-0 m-3">٪۱۵ تخفیف</span>
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h6 class="card-title fw-bold mb-2">شکر سفید ۵۰ کیلویی (فروش ویژه)</h6>
                                <p class="text-muted small mb-3"><i class="bi bi-box me-1"></i>حداقل سفارش: ۲ گونی</p>
                                <div class="d-flex justify-content-between align-items-end mt-auto">
                                    <div>
                                        <div class="old-price text-decoration-line-through text-muted small">۲٬۴۵۰٬۰۰۰</div>
                                        <div class="price text-danger fw-bold fs-5">۲٬۰۸۲٬۵۰۰ <span class="fs-6 text-muted fw-normal">تومان</span></div>
                                    </div>
                                    <button class="btn btn-danger rounded-circle shadow-sm text-white" style="padding: 10px 12px;">
                                        <i class="bi bi-cart-plus fs-5"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Discount Product 1 -->
                    <div class="swiper-slide">
                        <div class="card product-card h-100 border-danger border-opacity-25">
                            <div class="position-relative">
                                <img src="assets/img/rice.jpg" class="card-img-top product-img" alt="شکر">
                                <span class="badge-discount position-absolute top-0 start-0 m-3">٪۱۵ تخفیف</span>
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h6 class="card-title fw-bold mb-2">شکر سفید ۵۰ کیلویی (فروش ویژه)</h6>
                                <p class="text-muted small mb-3"><i class="bi bi-box me-1"></i>حداقل سفارش: ۲ گونی</p>
                                <div class="d-flex justify-content-between align-items-end mt-auto">
                                    <div>
                                        <div class="old-price text-decoration-line-through text-muted small">۲٬۴۵۰٬۰۰۰</div>
                                        <div class="price text-danger fw-bold fs-5">۲٬۰۸۲٬۵۰۰ <span class="fs-6 text-muted fw-normal">تومان</span></div>
                                    </div>
                                    <button class="btn btn-danger rounded-circle shadow-sm text-white" style="padding: 10px 12px;">
                                        <i class="bi bi-cart-plus fs-5"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Discount Product 1 -->
                    <div class="swiper-slide">
                        <div class="card product-card h-100 border-danger border-opacity-25">
                            <div class="position-relative">
                                <img src="assets/img/rice.jpg" class="card-img-top product-img" alt="شکر">
                                <span class="badge-discount position-absolute top-0 start-0 m-3">٪۱۵ تخفیف</span>
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h6 class="card-title fw-bold mb-2">شکر سفید ۵۰ کیلویی (فروش ویژه)</h6>
                                <p class="text-muted small mb-3"><i class="bi bi-box me-1"></i>حداقل سفارش: ۲ گونی</p>
                                <div class="d-flex justify-content-between align-items-end mt-auto">
                                    <div>
                                        <div class="old-price text-decoration-line-through text-muted small">۲٬۴۵۰٬۰۰۰</div>
                                        <div class="price text-danger fw-bold fs-5">۲٬۰۸۲٬۵۰۰ <span class="fs-6 text-muted fw-normal">تومان</span></div>
                                    </div>
                                    <button class="btn btn-danger rounded-circle shadow-sm text-white" style="padding: 10px 12px;">
                                        <i class="bi bi-cart-plus fs-5"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Discount Product 2 -->
                    <div class="swiper-slide">
                        <div class="card product-card h-100 border-danger border-opacity-25">
                            <div class="position-relative">
                                <img src="assets/img/rice.jpg" class="card-img-top product-img" alt="چای">
                                <span class="badge-discount position-absolute top-0 start-0 m-3">٪۱۰ تخفیف</span>
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h6 class="card-title fw-bold mb-2">چای سیاه ممتاز (۵ کیلویی)</h6>
                                <p class="text-muted small mb-3"><i class="bi bi-box me-1"></i>حداقل سفارش: ۴ بسته</p>
                                <div class="d-flex justify-content-between align-items-end mt-auto">
                                    <div>
                                        <div class="old-price text-decoration-line-through text-muted small">۱٬۲۲۰٬۰۰۰</div>
                                        <div class="price text-danger fw-bold fs-5">۱٬۰۹۸٬۰۰۰ <span class="fs-6 text-muted fw-normal">تومان</span></div>
                                    </div>
                                    <button class="btn btn-danger rounded-circle shadow-sm text-white" style="padding: 10px 12px;">
                                        <i class="bi bi-cart-plus fs-5"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="swiper-button-next text-danger"></div>
                <div class="swiper-button-prev text-danger"></div>
            </div>
        </div>
    </section>

    <!-- Promo Banner -->
    <section class="py-5">
        <div class="container">
            <div class="promo-banner d-flex align-items-center p-4 p-md-5" style="background: linear-gradient(135deg, #0f2027 0%, #203a43 50%, #2c5364 100%);">
                <div class="d-flex flex-column flex-md-row align-items-center justify-content-between w-100 gap-4">
                    <div class="text-white text-center text-md-start">
                        <h3 class="fw-bold mb-2">عضویت در باشگاه مشتریان عمده</h3>
                        <p class="mb-0 opacity-75 fs-5">قیمت‌های پلکانی و پشتیبانی اختصاصی</p>
                    </div>
                    <button class="btn btn-warning btn-lg text-dark fw-bold px-5 shadow" data-bs-toggle="modal" data-bs-target="#wholesaleModal">
                        ثبت‌نام
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Products: Best Sellers (Slider) -->
    <section id="products" class="py-5">
        <div class="container position-relative">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold mb-0 text-primary">جدیدترین محصولات  </h2>
                <a href="#" class="btn btn-sm btn-outline-primary rounded-pill px-4">مشاهده همه</a>
            </div>

            <!-- Swiper -->
            <div class="swiper productSwiper pb-4 px-2">
                <div class="swiper-wrapper">
                    <!-- Product 1 -->
                    <div class="swiper-slide">
                        <div class="card product-card h-100">
                            <div class="position-relative">
                                <img src="assets/img/rice.jpg" class="card-img-top product-img" alt="روغن">
                                <span class="badge-wholesale position-absolute top-0 end-0 m-3">عمده</span>
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h6 class="card-primary fw-bold mb-2">روغن آفتابگردان ۱۸ لیتری</h6>
                                <p class="text-muted small mb-3"><i class="bi bi-box me-1"></i>حداقل سفارش: ۵ عدد</p>
                                <div class="d-flex justify-content-between align-items-end mt-auto">
                                    <div>
                                        <div class="old-price">۲٬۱۰۰٬۰۰۰</div>
                                        <div class="price">۱٬۸۵۰٬۰۰۰ <span class="fs-6 text-muted fw-normal">تومان</span></div>
                                    </div>
                                    <button class="btn btn-light text-primary rounded-circle shadow-sm" style="padding: 10px 12px;">
                                        <i class="bi bi-cart-plus fs-5"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="card product-card h-100">
                            <div class="position-relative">
                                <img src="assets/img/rice.jpg" class="card-img-top product-img" alt="روغن">
                                <span class="badge-wholesale position-absolute top-0 end-0 m-3">عمده</span>
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h6 class="card-primary fw-bold mb-2">روغن آفتابگردان ۱۸ لیتری</h6>
                                <p class="text-muted small mb-3"><i class="bi bi-box me-1"></i>حداقل سفارش: ۵ عدد</p>
                                <div class="d-flex justify-content-between align-items-end mt-auto">
                                    <div>
                                        <div class="old-price">۲٬۱۰۰٬۰۰۰</div>
                                        <div class="price">۱٬۸۵۰٬۰۰۰ <span class="fs-6 text-muted fw-normal">تومان</span></div>
                                    </div>
                                    <button class="btn btn-light text-primary rounded-circle shadow-sm" style="padding: 10px 12px;">
                                        <i class="bi bi-cart-plus fs-5"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="card product-card h-100">
                            <div class="position-relative">
                                <img src="assets/img/rice.jpg" class="card-img-top product-img" alt="روغن">
                                <span class="badge-wholesale position-absolute top-0 end-0 m-3">عمده</span>
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h6 class="card-primary fw-bold mb-2">روغن آفتابگردان ۱۸ لیتری</h6>
                                <p class="text-muted small mb-3"><i class="bi bi-box me-1"></i>حداقل سفارش: ۵ عدد</p>
                                <div class="d-flex justify-content-between align-items-end mt-auto">
                                    <div>
                                        <div class="old-price">۲٬۱۰۰٬۰۰۰</div>
                                        <div class="price">۱٬۸۵۰٬۰۰۰ <span class="fs-6 text-muted fw-normal">تومان</span></div>
                                    </div>
                                    <button class="btn btn-light text-primary rounded-circle shadow-sm" style="padding: 10px 12px;">
                                        <i class="bi bi-cart-plus fs-5"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="card product-card h-100">
                            <div class="position-relative">
                                <img src="assets/img/rice.jpg" class="card-img-top product-img" alt="روغن">
                                <span class="badge-wholesale position-absolute top-0 end-0 m-3">عمده</span>
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h6 class="card-primary fw-bold mb-2">روغن آفتابگردان ۱۸ لیتری</h6>
                                <p class="text-muted small mb-3"><i class="bi bi-box me-1"></i>حداقل سفارش: ۵ عدد</p>
                                <div class="d-flex justify-content-between align-items-end mt-auto">
                                    <div>
                                        <div class="old-price">۲٬۱۰۰٬۰۰۰</div>
                                        <div class="price">۱٬۸۵۰٬۰۰۰ <span class="fs-6 text-muted fw-normal">تومان</span></div>
                                    </div>
                                    <button class="btn btn-light text-primary rounded-circle shadow-sm" style="padding: 10px 12px;">
                                        <i class="bi bi-cart-plus fs-5"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Product 2 -->
                    <div class="swiper-slide">
                        <div class="card product-card h-100">
                            <div class="position-relative">
                                <img src="assets/img/rice.jpg" class="card-img-top product-img" alt="برنج">
                                <span class="badge-wholesale position-absolute top-0 end-0 m-3">عمده</span>
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h6 class="card-primary fw-bold mb-2">برنج طارم ممتاز (۱۰ کیلویی)</h6>
                                <p class="text-muted small mb-3"><i class="bi bi-box me-1"></i>حداقل سفارش: ۱۰ کیسه</p>
                                <div class="d-flex justify-content-between align-items-end mt-auto">
                                    <div>
                                        <div class="price">۹۸۰٬۰۰۰ <span class="fs-6 text-muted fw-normal">تومان</span></div>
                                    </div>
                                    <button class="btn btn-light text-primary rounded-circle shadow-sm" style="padding: 10px 12px;">
                                        <i class="bi bi-cart-plus fs-5"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- محصولات ۳ و ۴ را مشابه بالا داخل <div class="swiper-slide"> قرار دهید -->
                </div>

                <!-- دکمه‌های کنترل اسلایدر -->
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>
    </section>

    <!-- Articles -->
    <section id="articles" class="py-5">
        <div class="container position-relative">
            <div class="d-flex justify-content-between align-items-center mb-5">
                <h2 class="fw-bold mb-0 text-primary">مقالات </h2>
                <a href="#" class="btn btn-sm btn-outline-primary rounded-pill px-4">همه مقالات</a>
            </div>

            <!-- Swiper -->
            <div class="swiper articleSwiper pb-4 px-2">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class=" card article-card h-100">
                            <img src="assets/img/images.jfif" class="card-img-top article-img" alt="مقاله">
                            <div class="card-body d-flex flex-column">
                                <div class="text-muted small mb-3">
                                    <i class="bi bi-calendar3 me-1"></i> ۱۲ مرداد ۱۴۰۴
                                    <span class="mx-2 text-light">|</span>
                                    <i class="bi bi-person me-1"></i> تیم محتوا
                                </div>
                                <h5 class="card-primary fw-bold mb-3">چطور خرید عمده مواد غذایی را بهینه کنیم؟</h5>
                                <p class="card-text text-muted mb-4">راهنمای کامل مدیریت موجودی، حداقل سفارش و کاهش هزینه حمل برای فروشگاه‌ها و رستوران‌ها.</p>
                                <a href="#" class="article-link">
                                    مطالعه مطلب
                                    <i class="bi bi-arrow-left"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="card  article-card h-100">
                            <img src="assets/img/images.jfif" class="card-img-top article-img" alt="مقاله">
                            <div class="card-body d-flex flex-column">
                                <div class="text-muted small mb-3">
                                    <i class="bi bi-calendar3 me-1"></i> ۵ مرداد ۱۴۰۴
                                    <span class="mx-2 text-light">|</span>
                                    <i class="bi bi-person me-1"></i> واحد کیفیت
                                </div>
                                <h5 class="card-primary fw-bold mb-3">نکات نگهداری مواد غذایی در انبار فروشگاهی</h5>
                                <p class="card-text text-muted mb-4">دما، رطوبت، چیدمان FIFO و کنترل تاریخ انقضا؛ اصولی که ضایعات را کم می‌کند.</p>
                                <a href="#" class="article-link">
                                    مطالعه مطلب
                                    <i class="bi bi-arrow-left"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="card article-card h-100">
                            <img src="assets/img/images.jfif" class="card-img-top article-img" alt="مقاله">
                            <div class="card-body d-flex flex-column">
                                <div class="text-muted small mb-3">
                                    <i class="bi bi-calendar3 me-1"></i> ۵ مرداد ۱۴۰۴
                                    <span class="mx-2 text-light">|</span>
                                    <i class="bi bi-person me-1"></i> واحد کیفیت
                                </div>
                                <h5 class="card-primary fw-bold mb-3">نکات نگهداری مواد غذایی در انبار فروشگاهی</h5>
                                <p class="card-text text-muted mb-4">دما، رطوبت، چیدمان FIFO و کنترل تاریخ انقضا؛ اصولی که ضایعات را کم می‌کند.</p>
                                <a href="#" class="article-link">
                                    مطالعه مطلب
                                    <i class="bi bi-arrow-left"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="card article-card h-100">
                            <img src="assets/img/images.jfif" class="card-img-top article-img" alt="مقاله">
                            <div class="card-body d-flex flex-column">
                                <div class="text-muted small mb-3">
                                    <i class="bi bi-calendar3 me-1"></i> ۵ مرداد ۱۴۰۴
                                    <span class="mx-2 text-light">|</span>
                                    <i class="bi bi-person me-1"></i> واحد کیفیت
                                </div>
                                <h5 class="card-primary fw-bold mb-3">نکات نگهداری مواد غذایی در انبار فروشگاهی</h5>
                                <p class="card-text text-muted mb-4">دما، رطوبت، چیدمان FIFO و کنترل تاریخ انقضا؛ اصولی که ضایعات را کم می‌کند.</p>
                                <a href="#" class="article-link">
                                    مطالعه مطلب
                                    <i class="bi bi-arrow-left"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="card article-card h-100">
                            <img src="assets/img/images.jfif" class="card-img-top article-img" alt="مقاله">

                            <div class="card-body d-flex flex-column">
                                <div class="text-muted small mb-3">
                                    <i class="bi bi-calendar3 me-1"></i> ۲۸ تیر ۱۴۰۴
                                    <span class="mx-2 text-light">|</span>
                                    <i class="bi bi-person me-1"></i> واحد فروش
                                </div>
                                <h5 class="card-primary fw-bold mb-3">تفاوت قیمت خرده‌فروشی و عمده در بازار</h5>
                                <p class="card-text text-muted mb-4">چرا خرید عمده به‌صرفه‌تر است و چه زمانی سراغ قراردادهای بلندمدت برویم؟</p>
                                <a href="#" class="article-link">
                                    مطالعه مطلب
                                    <i class="bi bi-arrow-left"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>
    </section>

    <!-- About / Features -->
    <section id="about" class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold text-primary">چرا بازرگانی بنازاده؟</h2>
                <p class="text-muted mt-2">تأمین‌کننده مطمئن مواد غذایی برای کسب‌وکارهای شما</p>
            </div>

            <div class="row g-4 mb-5">

                <div class="col-md-6 col-lg-3">
                    <div class="feature-card text-center">
                        <div class="feature-icon bg-primary-subtle">
                            <i class="bi bi-tag-fill text-primary"></i>
                        </div>
                        <h5>قیمت عمده واقعی</h5>
                        <p>خرید مستقیم از کارخانه بدون واسطه</p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="feature-card text-center">
                        <div class="feature-icon bg-success-subtle">
                            <i class="bi bi-truck text-success"></i>
                        </div>
                        <h5>ارسال سریع</h5>
                        <p>پوشش سراسری با ناوگان اختصاصی</p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="feature-card text-center">
                        <div class="feature-icon bg-info-subtle">
                            <i class="bi bi-shield-check text-info"></i>
                        </div>
                        <h5>کیفیت تضمینی</h5>
                        <p>ضمانت اصالت و تاریخ انقضای معتبر</p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="feature-card text-center">
                        <div class="feature-icon bg-warning-subtle">
                            <i class="bi bi-headset text-warning"></i>
                        </div>
                        <h5>پشتیبانی اختصاصی</h5>
                        <p>کارشناس فروش ویژه مشتریان عمده</p>
                    </div>
                </div>

            </div>
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <h3 class="fw-bold mb-4">درباره بازرگانی بنازاده</h3>
                    <p class="text-muted lh-lg">بازرگانی بنازاده با بیش از ۱۵ سال سابقه، تأمین‌کننده تخصصی مواد غذایی برای فروشگاه‌ها، رستوران‌ها، کترینگ‌ها و پخش‌های محلی است. تمرکز ما روی قیمت رقابتی، موجودی پایدار و ارسال منظم است.</p>
                    <ul class="list-unstyled mt-4">
                        <li class="mb-3 d-flex align-items-center"><i class="bi bi-check-circle-fill text-success fs-5 me-3"></i>تنوع بالا در اقلام پرمصرف فروشگاهی</li>
                        <li class="mb-3 d-flex align-items-center"><i class="bi bi-check-circle-fill text-success fs-5 me-3"></i>امکان قرارداد ماهانه و فصلی</li>
                        <li class="mb-3 d-flex align-items-center"><i class="bi bi-check-circle-fill text-success fs-5 me-3"></i>فاکتور رسمی و پشتیبانی پس از فروش</li>
                    </ul>
                </div>
                <div class="col-lg-6">
                    <div class="position-relative d-flex align-items-center">

                        <!-- حذف position-absolute و z-index منفی -->
                        <video autoplay loop muted playsinline preload="auto"
                               class="w-100 object-fit-cover rounded-4 shadow-sm"
                               style="min-height: 400px;">
                            <source src="assets/video/video.mp4" type="video/mp4">
                            <source src="assets/video/video.webm" type="video/webm">
                            <!-- فالبک عکس -->
                            <img src="assets/img/store.jpg" alt="store" class="w-100 object-fit-cover rounded-4 shadow-sm">
                        </video>

                        <!-- باکس شناور اعتماد -->
                        <div class="position-absolute bottom-0 end-0 bg-white p-3 m-3 m-md-4 rounded-4 shadow d-flex align-items-center">
                            <i class="bi bi-patch-check-fill text-primary fs-1 ms-3"></i>
                            <div>
                                <h5 class="fw-bold text-dark mb-0">۱۵ سال</h5>
                                <small class="text-muted">تأمین مستمر و مطمئن</small>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection
