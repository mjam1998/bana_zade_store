<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>بازرگانی بنازاده</title>

    <link rel="stylesheet" href="{{asset('front/assets/css/bootstrap.rtl.min.css')}}">

    <link rel="stylesheet" href="{{asset('bootstrap/bootstrap-icons.css')}}">

    <link href="{{asset('front/assets/fonts/vazirmatn-font-face.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('front/assets/css/swiper-bundle.min.css')}}" />

    <link  rel="stylesheet" href="{{asset('front/assets/css/style.css')}}">
    <link href="{{asset('admin/choises/choices.min.css')}}" rel="stylesheet" />

    @livewireStyles
</head>
<body>

@php
    $activePages=App\Models\Page::query()->where('is_active',true)->get();
@endphp

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white bg-opacity-75 fixed-top" style="backdrop-filter: blur(10px); z-index: 1030;">


    <div class="container">
        <a class="navbar-brand fw-bold text-primary d-flex align-items-center" href="{{route('home')}}">
            <i class="bi bi-shop-window me-2 fs-3"></i>
            بازرگانی بنازاده
        </a>

        <div class="d-flex align-items-center gap-2 d-lg-none ms-auto">
            <!-- آیکون جستجو - فقط موبایل -->
            <a href="{{ route('products') }}" class="btn btn-light border-0 shadow-sm text-primary px-2">
                <i class="bi bi-search fs-5"></i>
            </a>

            <!-- دکمه همبرگر -->
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ps-3">
                <li class="nav-item"><a class="nav-link active" href="{{route('home')}}">خانه</a></li>
                <li class="nav-item"><a class="nav-link" href="{{route('categories')}}">دسته‌بندی‌ها</a></li>
                <li class="nav-item"><a class="nav-link" href="{{route('products')}}">محصولات</a></li>
                @foreach($activePages as $activePage)
                    <li class="nav-item"><a class="nav-link" href="{{route('dynomic.page.show',$activePage->slug)}}"> {{$activePage->title}}</a></li>
                @endforeach

            </ul>

            <div class="d-flex align-items-center gap-3">
                <form action="{{ route('products') }}" method="GET" class="input-group d-none d-md-flex" style="max-width: 300px;">
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control bg-light border-0" placeholder="جستجوی محصول...">
                    <button type="submit" class="btn btn-light bg-light border-0 text-primary"><i class="bi bi-search"></i></button>
                </form>
                <a href="{{ route('cart.index') }}" class="btn btn-light position-relative border-0 shadow-sm text-primary">
                    <i class="bi bi-cart3 fs-5"></i>
                    <span id="cart-badge-count" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-2 border-white">
        {{ count(session('cart', [])) }}
    </span>
                </a>
                @if(auth()->check() && auth()->user()->hasRole('user'))
                    <a href="{{ route('profile.index') }}" class="btn btn-primary">پروفایل کاربری</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary">ورود / ثبت‌نام</a>
                @endif

            </div>

        </div>
    </div>
</nav>


@yield('content')


<!-- Footer -->
<footer  id="contact" class="footer pt-5 pb-3">
    <div class="container pt-4">
        <div class="row g-5">
            <div class="col-lg-5 col-md-6">
                <h5 class="mb-4 d-flex align-items-center">
                    <i class="bi bi-shop-window me-2 text-primary"></i>
                    بازرگانی بنازاده
                </h5>
                <p class="opacity-75 lh-lg pe-lg-5">عمده‌فروشی تخصصی مواد غذایی با بیش از ۱۵ سال سابقه در تأمین نیازهای فروشگاه‌ها، رستوران‌ها و سازمان‌ها با تضمین بهترین قیمت و کیفیت.</p>
            </div>

            <div class="col-lg-3 col-md-6">
                <h5 class="mb-4">دسترسی سریع</h5>
                <ul class="list-unstyled">
                    <li class="mb-3"><a href="{{route('products')}}" class="text-decoration-none text-secondary custom-link">محصولات</a></li>
                    <li class="mb-3"><a href="{{route('categories')}}" class="text-decoration-none text-secondary custom-link">دسته‌بندی‌ها</a></li>
                    @foreach($activePages as $activePage)
                        <li class="mb-3"><a href="{{route('dynomic.page.show',$activePage->slug)}}" class="text-decoration-none text-secondary custom-link">{{$activePage->title}}</a></li>
                    @endforeach


                </ul>
            </div>
            <div class="col-lg-4 col-md-12">
                <h5 class="mb-4">ارتباط با ما</h5>
                <p class="mb-3 d-flex align-items-center opacity-75"><i class="bi bi-geo-alt me-3 fs-5 text-primary"></i>کرج ٫ بازار بزرگ خیام ٫ غرفه۱۳٫۱۴
                    بازرگانی بنازاده</p>
                <p class="mb-3 d-flex align-items-center opacity-75"><i class="bi bi-telephone me-3 fs-5 text-primary"></i> ۰۹۱۲۹۶۱۳۹۶۳</p>
                <p class="mb-3 d-flex align-items-center opacity-75"><i class="bi bi-telephone me-3 fs-5 text-primary"></i> ۰۹۰۴۶۸۶۳۸۹۵</p>

{{--                <div class="d-flex gap-3 mt-4">--}}
{{--                    <a href="#" class="btn btn-outline-secondary rounded-circle px-2 py-1"><i class="bi bi-instagram"></i></a>--}}
{{--                    <a href="#" class="btn btn-outline-secondary rounded-circle px-2 py-1"><i class="bi bi-telegram"></i></a>--}}
{{--                </div>--}}
            </div>
        </div>
        <hr class="border-secondary my-5 opacity-25">
        <div class="text-center small opacity-50 pb-2">
            © 1405-1406 بازرگانی بنازاده. تمامی حقوق محفوظ است.
        </div>
    </div>
</footer>


<script  src="{{asset('front/assets/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('front/assets/js/swiper-bundle.min.js')}}"></script>
<script src="{{asset('admin/choises/choices.min.js')}}"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var swipers = document.querySelectorAll('.productSwiper');

        swipers.forEach(function(slider) {
            new Swiper(slider, {
                slidesPerView: 1,
                spaceBetween: 20,

                navigation: {
                    nextEl: slider.querySelector('.swiper-button-next'),
                    prevEl: slider.querySelector('.swiper-button-prev'),
                },
                breakpoints: {
                    576: {
                        slidesPerView: 2,
                    },
                    768: {
                        slidesPerView: 3,
                    },
                    1200: {
                        slidesPerView: 4,
                    }
                }
            });
        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {

        var productSwipers = document.querySelectorAll('.productSwiper');
        productSwipers.forEach(function(slider) {
            new Swiper(slider, {
                slidesPerView: 1,
                spaceBetween: 20,
                navigation: {
                    nextEl: slider.querySelector('.swiper-button-next'),
                    prevEl: slider.querySelector('.swiper-button-prev'),
                },
                breakpoints: {
                    576: { slidesPerView: 2 },
                    768: { slidesPerView: 3 },
                    1200: { slidesPerView: 4 }
                }
            });
        });


        var categorySwipers = document.querySelectorAll('.categorySwiper');
        categorySwipers.forEach(function(slider) {
            new Swiper(slider, {
                slidesPerView: 2,
                spaceBetween: 15,
                navigation: {
                    nextEl: slider.querySelector('.swiper-button-next'),
                    prevEl: slider.querySelector('.swiper-button-prev'),
                },
                breakpoints: {
                    576: { slidesPerView: 3 },
                    768: { slidesPerView: 4 },
                    1024: { slidesPerView: 6 }
                }
            });
        });


        var articleSwipers = document.querySelectorAll('.articleSwiper');
        articleSwipers.forEach(function(slider) {
            new Swiper(slider, {
                slidesPerView: 1,
                spaceBetween: 24,
                navigation: {
                    nextEl: slider.querySelector('.swiper-button-next'),
                    prevEl: slider.querySelector('.swiper-button-prev'),
                },
                breakpoints: {
                    768: { slidesPerView: 2 },
                    992: { slidesPerView: 3 }
                }
            });
        });

    });
</script>
<script>
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eye-icon');
        const eyeSlashIcon = document.getElementById('eye-slash-icon');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.classList.add('d-none');
            eyeSlashIcon.classList.remove('d-none');
        } else {
            passwordInput.type = 'password';
            eyeIcon.classList.remove('d-none');
            eyeSlashIcon.classList.add('d-none');
        }
    }
</script>
<script>

    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    function updateCartBadge(count) {
        const badge = document.getElementById('cart-badge-count');
        if(badge) badge.innerText = count;
    }
</script>
@stack('scripts')
@livewireScripts
</body>
</html>
