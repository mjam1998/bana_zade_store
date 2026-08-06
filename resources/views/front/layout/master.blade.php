<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('meta_title', 'آقای صفر تا صد | فروش و اجرای تاسیسات ساختمانی')</title>

    {{-- Meta Description --}}
    <meta name="description" content="@yield('meta_description', 'خرید آنلاین تجهیزات تاسیسات با بهترین قیمت از فروشگاه آقای صفر تا صد')">

    {{-- Keywords --}}
    <meta name="keywords" content="@yield('meta_keywords', 'تاسیسات، لوله، شیرآلات، خرید آنلاین')">

    {{-- Canonical --}}
    @stack('canonical')

    {{-- Open Graph --}}
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:title" content="@yield('meta_title', 'فروشگاه آقای صفر تا صد')">
    <meta property="og:description" content="@yield('meta_description', 'خرید آنلاین تجهیزات تاسیسات')">
    <meta property="og:image" content="@yield('og_image', asset('front/assets/images/logo.png'))">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="آقای صفر تا صد">
    <meta property="og:locale" content="fa_IR">

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('meta_title', 'فروشگاه آقای صفر تا صد')">
    <meta name="twitter:description" content="@yield('meta_description', '')">
    <meta name="twitter:image" content="@yield('og_image', asset('front/assets/images/logo.png'))">

    {{-- Robots --}}
    @yield('robots', '')


    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{asset('front/assets/images/logo.png')}}">
    <link rel="icon" type="image/png" href="{{asset('front/assets/images/logo.pn')}}">

    <!-- برای دستگاه‌های اپل -->
    <link rel="apple-touch-icon" href="{{asset('front/assets/images/logo.pn')}}">



    <link rel="stylesheet" href="{{asset('front/assets/js/plugin/story-player/styles.css')}}">
    <link rel="stylesheet" href="{{asset('front/assets/js/plugin/swiper/swiper-bundle.min.css')}}">
    <link rel="stylesheet" href="{{asset('front/assets/css/app.css')}}">
    <link rel="stylesheet" href="{{asset('choices/choices.min.css')}}">
    <style>/* استایل گالری تصاویر ویرایشگر */
        .image-gallery {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
            margin: 2rem 0;
        }

        .image-gallery img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            aspect-ratio: 1 / 1; /* تصاویر را به صورت مربع و یکدست در می‌آورد */
            border-radius: 0.75rem; /* گوشه‌های گرد (معادل rounded-xl) */
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .image-gallery img:hover {
            transform: scale(1.05); /* افکت بزرگ‌نمایی ملایم در هاور */
        }

        /* Custom Choices.js styling */
        .choices {
            margin-bottom: 0;
        }

        .choices__inner {
            background: transparent !important;
            border: none !important;
            padding: 0 !important;
            min-height: auto !important;
            font-size: 0.875rem !important;
            font-weight: 700 !important;
        }

        .choices__list--single {
            padding: 0 !important;
        }

        .choices[data-type*=select-one] .choices__input {
            background: transparent !important;
            border: none !important;
            padding: 0.5rem 1rem !important;
            margin: 0 !important;
            font-size: 0.875rem !important;
            font-weight: 700 !important;
        }

        .choices__list--dropdown {
            background: white !important;
            border: 1px solid #e5e7eb !important;
            border-radius: 1rem !important;
            margin-top: 0.5rem !important;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1) !important;
            z-index: 50 !important;
        }

        .dark .choices__list--dropdown {
            background: rgb(31 41 55) !important;
            border-color: rgb(55 65 81) !important;
        }

        .choices__list--dropdown .choices__item {
            padding: 0.75rem 1rem !important;
            font-size: 0.875rem !important;
            font-weight: 700 !important;
            color: #374151 !important;
        }

        .dark .choices__list--dropdown .choices__item {
            color: #e5e7eb !important;
        }

        .choices__list--dropdown .choices__item--selectable.is-highlighted {
            background: #eff6ff !important;
            color: #2563eb !important;
        }

        .dark .choices__list--dropdown .choices__item--selectable.is-highlighted {
            background: rgba(37, 99, 235, 0.2) !important;
            color: #60a5fa !important;
        }

        .choices[data-type*=select-one]:after {
            display: none !important;
        }

        .choices__input {
            background: transparent !important;
            color: #374151 !important;
            font-weight: 700 !important;
        }

        .dark .choices__input {
            color: #e5e7eb !important;
        }

        .choices__input::placeholder {
            color: #9ca3af !important;
        }

        .dark .choices__input::placeholder {
            color: #6b7280 !important;
        }

        /* Hide original icon when Choices is active */
        .choices.is-open ~ .category-icon {
            display: none;
        }
        .sr-only {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            border: 0;
        }
    </style>
</head>
<body class="bg-[#fcfdfe] dark:bg-[#050505] min-h-screen transition-colors duration-700 selection:bg-blue-500/30 selection:text-blue-600 ">
<!-- NEON LIGHT -->
<div class="fixed  inset-0 pointer-events-none -z-[60] overflow-hidden bg-[#fafbfc] dark:bg-[#030303]">
    <div class="absolute -top-[15%] -left-[10%] w-[70%] h-[70%] bg-indigo-500/10 dark:bg-indigo-600/[0.15] blur-[150px] rounded-full animate-pulse" style="animation-duration: 8s;"></div>
    <div class="absolute -bottom-[15%] -right-[10%] w-[70%] h-[70%] bg-blue-500/10 dark:bg-blue-600/[0.18] blur-[150px] rounded-full animate-pulse" style="animation-duration: 10s;"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[50%] h-[50%] bg-blue-400/[0.03] dark:bg-blue-500/[0.05] blur-[120px] rounded-full"></div>
    <div class="absolute inset-0 opacity-[0.03] dark:opacity-[0.06] pointer-events-none mix-blend-multiply dark:mix-blend-soft-light" style="background-image: url('data:image/svg+xml,%3Csvg viewBox=\'0 0 200 200\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cfilter id=\'n\'%3E%3CfeTurbulence type=\'fractalNoise\' baseFrequency=\'0.8\' numOctaves=\'4\' stitchTiles=\'stitch\'/%3E%3C/filter%3E%3Crect width=\'100%25\' height=\'100%25\' filter=\'url(%23n)\'/%3E%3C/svg%3E');"></div>
</div>
<!-- END NEON LIGHT -->
<!-- HEADER -->

<header class="glass-header sticky top-0 z-50 border-b drop-shadow border-gray-200/50 dark:border-gray-800/50 bg-white/80 dark:bg-gray-950/80 backdrop-blur-xl transition-all duration-300">

    <div class="container">
        <div class="flex items-center justify-between h-20 gap-8">
            <div class="flex items-center gap-4">
                <button id="resMenu" class="lg:hidden p-2 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-full transition-colors">
                    <svg class="w-6 h-6 text-gray-700 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16m-7 6h7"/>
                    </svg>
                </button>
                <a href="{{route('search')}}" id="mobile-search-toggle" class="md:hidden p-2.5 rounded-xl border border-gray-200/50 dark:border-white/10 bg-white/40 dark:bg-white/5 text-gray-600 dark:text-gray-400 transition-all shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </a>
                <a href="{{route('home')}}" class="flex items-center gap-2 group">
                    <img src="{{asset('front/assets/images/logo.png')}}" class="w-30" alt="">
                </a>
            </div>

            <!-- Search -->
            <div id="search-wrapper" class="hidden md:flex flex-1 max-w-4xl relative group/search mx-auto" style="z-index: 100000; position: relative;">

                     <div class="relative w-full z-[10000]">
                         <form method="get" action="{{route('search')}}">
                         <input type="text" name="search" id="main-search-input" class="w-full bg-gray-200/60 dark:bg-[var(--color-primary-950)]/60 backdrop-blur-md border border-gray-300/30 dark:border-white/5 rounded-2xl py-4 pr-12 pl-40 text-sm font-bold text-right outline-none focus:bg-white dark:focus:bg-[var(--color-primary-950)] focus:ring-4 ring-[var(--color-primary-500)]/40 transition-all placeholder:text-gray-500 shadow-sm" placeholder="جستجوی سراسری در محصولات ...">

                         <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-gray-500">
                             <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-width="2.5"></path></svg>
                         </div>

                         <div class="absolute left-2 top-1/2 -translate-y-1/2 flex items-center h-[75%] gap-2">
                             <div class="h-full w-px bg-gray-300/40 dark:bg-white/10 ml-1"></div>
                             <button type="submit" class="h-full px-4 flex items-center gap-3 rounded-xl transition-all duration-300 group/archive
                                   bg-white border border-gray-200 text-gray-700 shadow-sm hover:border-[var(--color-primary-500)]
                                   dark:bg-[var(--color-primary-800)]/60 dark:border-white/10 dark:text-gray-200 dark:hover:bg-[var(--color-primary-500)]/10">
                                 <div class="flex items-center justify-center w-6 h-6 rounded-lg bg-gray-100 dark:bg-white/10 group-hover/archive:bg-[var(--color-primary-500)] group-hover/archive:text-white transition-all duration-300">
                                     <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"></path>
                                     </svg>
                                 </div>
                                 <span class="text-[11px] font-black whitespace-nowrap">آرشیو محصولات</span>
                             </button>
                         </div>
                         </form>
                      </div>




            </div>
            <!-- Register and action button-->
            <div class="flex items-center gap-3">
                <button id="dark-mode-toggle" class="p-2.5 rounded-xl border border-gray-200/50 dark:border-white/10 bg-white/40 dark:bg-white/5 backdrop-blur-md hover:border-primary-500/50 hover:bg-white/80 dark:hover:bg-white/10 text-gray-600 dark:text-gray-400 hover:text-primary-500 transition-all duration-300 shadow-sm">
                    <svg class="w-5 h-5 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 9H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z"/>
                    </svg>
                    <svg class="w-5 h-5 block dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                    </svg>
                </button>

                <a href="{{route('cart.view')}}" id="cart-btn-mobile" class="relative p-2.5 rounded-xl border border-secondary-500/20 bg-secondary-500/10 dark:bg-secondary-500/20 backdrop-blur-md hover:bg-secondary-500 hover:text-white transition-all duration-300 group shadow-lg shadow-secondary-500/10">
                    <svg class="w-6 h-6 text-secondary-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                    <span id="cart-count-mobile" class="absolute cart-badge -top-1.5 -right-1.5 bg-primary-600 text-white text-[10px] font-black w-5 h-5 flex items-center justify-center rounded-lg border-2 border-white dark:border-gray-950 shadow-sm">
        {{ session()->has('cart') ? array_sum(array_column(session('cart'), 'quantity')) : 0 }}
    </span>
                </a>

            </div>
        </div>
    </div>
    <nav class="hidden lg:block bg-white/50 dark:bg-gray-950/50 border-t border-gray-100 dark:border-gray-800">
        <div class="container mx-auto px-8">
            <ul class="flex items-center gap-8 py-3">
                <li class="group/main static">
                    <a href="#" class="flex items-center gap-2 py-4 text-[13px] font-bold text-gray-800 dark:text-gray-200 group-hover/main:text-[var(--color-primary-500)] transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
                        </svg>
                      دسته بندی ها

                    </a>
                    <div class="absolute top-full right-0 left-0 w-full bg-white dark:bg-[var(--color-primary-950)] border-t border-gray-100 dark:border-[var(--color-primary-900)] shadow-2xl opacity-0 invisible group-hover/main:opacity-100 group-hover/main:visible transition-all duration-200 z-50 flex h-[580px]">
                        <div class="container mx-auto flex h-full">
                            <div class="w-64 border-l border-gray-100 dark:border-[var(--color-primary-900)] py-2 overflow-y-auto bg-gray-50/80 dark:bg-[var(--color-primary-900)]/30">
                                <ul class="flex flex-col">
                                    <!--Digital goods-->
                                    @php
                                    $megaCategories=\App\Models\MegaCategory::all();
                                     @endphp
                                    @foreach($megaCategories as $index => $megaCategory)
                                        <li class="mega-tab-item {{ $index === 0 ? 'active' : '' }} group/tab"
                                            data-target="{{$megaCategory->id}}">
                                            <a href="#" class="flex items-center gap-3 px-6 py-4 text-[13px] font-bold text-gray-600 dark:text-gray-400 group-[.active]/tab:bg-white dark:group-[.active]/tab:bg-[var(--color-primary-950)] group-[.active]/tab:text-[var(--color-primary-600)] dark:group-[.active]/tab:text-[var(--color-primary-400)] transition-all">
                                                {{$megaCategory->name}}
                                            </a>
                                        </li>
                                    @endforeach


                                </ul>
                            </div>
                            <div class="flex-1 p-8 overflow-y-auto custom-scrollbar bg-white dark:bg-[var(--color-primary-950)]">
                                @foreach($megaCategories as $index => $megaCategory)
                                    <div id="{{$megaCategory->id}}"
                                         class="mega-tab-content {{ $index === 0 ? '' : 'hidden' }}">
                                        <div class="flex items-center justify-between mb-8">
                                            <a href="#" class="flex items-center gap-1 text-[14px] font-black text-gray-900 dark:text-white hover:text-[var(--color-primary-500)]">
                                                تمام محصولات {{$megaCategory->name}}
                                            </a>
                                        </div>
                                        <div class="grid grid-cols-4 gap-x-6 gap-y-10">
                                            @foreach($megaCategory->superCategories as $superCategory)
                                                <div class="space-y-4">
                                                    <a href="#" class="flex items-center gap-2 text-[14px] font-black text-gray-900 dark:text-white border-r-2 border-[var(--color-primary-500)] pr-3">
                                                        {{$superCategory->name}}
                                                    </a>
                                                    <ul class="space-y-3 pr-4 text-[12.5px] text-gray-500 dark:text-gray-400">
                                                        @foreach($superCategory->categories as $category)
                                                            <li>
                                                                <a href="{{route('category',['slug'=>$category->slug])}}" class="hover:text-[var(--color-primary-500)] transition-colors">{{$category->name}}</a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach



                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <a href="{{route('home')}}" class="text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">صفحه اصلی</a>
                </li>
                <li>
                    <a href="{{route('blogs')}}" class="text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">بلاگ</a>
                </li>
                <li>
                    <a href="{{route('order.track')}}" style="color: orangered" class="text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">پیگیری سفارش</a>
                </li>

                @php
                $pages=\App\Models\Page::all();
                @endphp
                @foreach($pages as $page)
                    <li>
                        <a href="{{route('page',$page->slug)}}" class="text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">{{$page->title}}</a>
                    </li>
                @endforeach


            </ul>
        </div>
    </nav>
</header>
<!-- END HEADER -->
<main>
    <h1 class="sr-only">@yield('h1', 'آقای صفر تا صد | فروش و اجرای تاسیسات ساختمانی')</h1>
    @yield('content')
</main>

<!-- FOOTER -->
<footer class="relative amazing-glass-footer pt-24 pb-12 overflow-hidden transition-colors duration-500">
    <div class="container relative z-10">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-24">
            <div class="contact-tile">
                <div class="icon-box bg-blue-500/10 text-blue-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" stroke-width="2"/>
                    </svg>
                </div>
                <div>
                    <h4 class="text-xs font-bold text-gray-400 mb-1">شماره تماس</h4>
                    <p class="text-sm font-black dark:text-white">09136437210</p>
                </div>
            </div>
            <div class="contact-tile">
                <div class="icon-box bg-indigo-500/10 text-indigo-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2"/>
                    </svg>
                </div>
                <div>
                    <h4 class="text-xs font-bold text-gray-400 mb-1">ساعات پاسخگویی</h4>
                    <p class="text-sm font-black dark:text-white">شنبه تا پنجشنبه، ۹ تا ۱۸</p>
                </div>
            </div>
            <div class="contact-tile">
                <div class="icon-box bg-purple-500/10 text-purple-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" stroke-width="2"/>
                        <path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" stroke-width="2"/>
                    </svg>
                </div>
                <div>
                    <h4 class="text-xs font-bold text-gray-400 mb-1">دفتر مرکزی</h4>
                    <p class="text-sm font-black dark:text-white">اصفهان، خیابان بابک نبش کوچه ۲۳</p>
                </div>
            </div>
            <div class="contact-tile">
                <div class="icon-box bg-emerald-500/10 text-emerald-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" stroke-width="2"/>
                    </svg>
                </div>
                <div>
                    <h4 class="text-xs font-bold text-gray-400 mb-1">پشتیبانی ایمیلی</h4>
                    <p class="text-sm font-black dark:text-white">info@aghaye0ta100.ir</p>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 gap-12 mb-24">
            <div class="xl:col-span-2 space-y-8">
                <div class="flex items-center gap-4">
                    <img src="{{asset('front/assets/images/logo.png')}}" class="w-30" alt="">
                    <span class="text-2xl font-black text-gray-900 dark:text-white uppercase">
                                   آقای<span class="text-orange-600"> صفر تا صد</span>
                            </span>
                </div>
                <p class="text-sm text-gray-500 dark:text-gray-400 leading-8 text-justify font-medium max-w-md">
                    آقای صفرتاصد با سال‌ها تجربه در زمینه فروش تجهیزات تاسیسات ساختمانی شامل پکیج، رادیاتور، پمپ اب، لوله و اتصالات پنج لایه و فاضلابی، شیرآلات صنعتی و بهداشتی، و همچنین اجرای تاسیسات مکانیکی (گرمایش، سرمایش، لوله‌کشی) و برقی ساختمان، آماده ارائه خدمات به پیمانکاران، مهندسان، سازندگان و مالکان محترم می‌باشد.
                    ما با دارا بودن تیم مجری ماهر، پروژه‌های خود را از مرحله طراحی تا تحویل نهایی با بالاترین استانداردهای فنی و کیفیت اجرا می‌کنیم.


                </p>
                <div class="flex gap-4">
                    <a href="https://wa.me/989136437210" class="w-12 h-12 rounded-2xl bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-800 flex items-center justify-center text-gray-400 hover:text-green-500 hover:border-green-500 transition-all group">
                        <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                        </svg>
                    </a>


                    <a href="https://t.me/989136437210" class="w-12 h-12 rounded-2xl bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-800 flex items-center justify-center text-gray-400 hover:text-blue-400 hover:border-blue-400 transition-all group">
                        <svg class="w-5 h-5 group-hover:scale-110 transition-transform" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 64 64">
                            <path fill="currentColor" d="m62.8 10.8l-9.4 44c-.7 3.1-2.5 3.8-5.1 2.4L34.2 46.8l-6.9 6.6c-.7.7-1.4 1.4-3 1.4l1.1-14.5l26.3-23.9c1.1-1.1-.3-1.5-1.7-.6L17.3 36.4L3.2 32.1c-3.1-1-3.1-3.1.7-4.5L58.7 6.3c2.7-.8 5 .6 4.1 4.5"/>
                        </svg>
                    </a>
                </div>
            </div>
            <div class="space-y-8">
                <h3 class="footer-title">دسترسی سریع</h3>
                <ul class="space-y-5">
                    <li>
                        <a href="{{route('blogs')}}" class="footer-link">بلاگ</a>
                    </li>
                    @php
                        $pages=\App\Models\Page::all();
                    @endphp
                    @foreach($pages as $page)
                        <li>
                            <a href="{{route('page',$page->slug)}}" class="footer-link">{{$page->title}}</a>
                        </li>
                    @endforeach

                </ul>
            </div>
            <div class="space-y-8">
                <h3 class="footer-title">راهنمای خرید</h3>
                <ul class="space-y-5">
                    <li>
                        <a href="{{route('order.track')}}" class="footer-link">پیگیری سفارش</a>
                    </li>
                    <li>
                        <a href="tel:09136437210" class="footer-link">تماس با پشتیبانی</a>
                    </li>
                </ul>
            </div>
            <div class="flex flex-col gap-6 items-center lg:items-end">
                <h3 class="footer-title">مجوزهای قانونی</h3>
                <div class="flex gap-4">
                    <div class="w-28 h-36 bg-white/30 dark:bg-white/[0.02] backdrop-blur-xl rounded-2xl border border-gray-200 dark:border-white/10 flex flex-col items-center justify-center p-4 transition-all duration-500 hover:shadow-2xl hover:border-blue-500/30 group">
                        <a referrerpolicy='origin' target='_blank' href='https://trustseal.enamad.ir/?id=523864&Code=zrxd628pd7IxaSUwAeiZHDk7msbhNqkR'><img referrerpolicy='origin' src='https://trustseal.enamad.ir/logo.aspx?id=523864&Code=zrxd628pd7IxaSUwAeiZHDk7msbhNqkR' alt='' style='cursor:pointer' code='zrxd628pd7IxaSUwAeiZHDk7msbhNqkR'></a>
                    </div>
                    <div class="w-28 h-36 bg-white/30 dark:bg-white/[0.02] backdrop-blur-xl rounded-2xl border border-gray-200 dark:border-white/10 flex flex-col items-center justify-center p-4 transition-all duration-500 hover:shadow-2xl hover:border-blue-500/30 group">
                        <script src="https://www.zarinpal.com/webservice/TrustCode" type="text/javascript"></script>
                    </div>
                </div>
            </div>
        </div>
        <div class="pt-10 border-t border-black/5 dark:border-white/5 flex flex-col md:flex-row justify-between items-center gap-8">
            <div class="flex items-center gap-4">
                <p class="text-[11px] text-gray-500 font-bold">
                    ۲۰۲۶ - ۱۴۰5 © تمامی حقوق مادی و معنوی وب سایت محفوظ و مربوط به سایت آقای صفر تا صد میباشد.
                </p>
            </div>
            <div class="flex flex-wrap justify-center gap-8">

            </div>
        </div>
    </div>
</footer>
<!-- END FOOTER -->
<!-- NAV MOBILE -->
<div class="fixed bottom-6 left-1/2 -translate-x-1/2 w-[92%] max-w-[400px] z-[100] md:hidden">
    <div class="relative bg-white/70 dark:bg-black/60 backdrop-blur-2xl border border-white/40 dark:border-white/10 rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.3)] px-2 py-3">
        <ul class="flex items-center justify-around relative">
            <li class="relative">
                <a href="{{route('home')}}" class="flex flex-col items-center gap-1 group relative px-4 py-1">
                    <div class="absolute -top-3 left-1/2 -translate-x-1/2 w-8 h-1 bg-blue-600 rounded-full shadow-[0_0_15px_rgba(37,99,235,0.8)]"></div>
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400 transition-transform group-active:scale-90" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
                    </svg>
                    <span class="text-[10px] font-black text-blue-600 dark:text-blue-400">خانه</span>
                </a>
            </li>
            <li>
                <a href="#" class="flex flex-col items-center gap-1 group px-4 py-1 text-gray-400 dark:text-gray-500">
                    <svg class="w-6 h-6 transition-transform group-active:scale-90" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16m-7 6h7"/>
                    </svg>
                    <span class="text-[10px] font-black">دسته‌ها</span>
                </a>
            </li>
            <li class="-mt-12">
                <button onclick="openCartDrawer()" id="cart-btn" class="relative flex items-center justify-center w-16 h-16 bg-blue-600 rounded-[1.8rem] text-white shadow-[0_10px_25px_rgba(37,99,235,0.5)] border-4 border-[#fafbfc] dark:border-[#050505] group transition-transform hover:scale-110 active:scale-95">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                    <span id="cart-count" class="absolute cart-badge -top-1 -right-1 bg-red-500 text-[9px] font-black w-5 h-5 rounded-full flex items-center justify-center border-2 border-blue-600">   {{ session()->has('cart') ? array_sum(array_column(session('cart'), 'quantity')) : 0 }}</span>
                </button>
            </li>
            <li>
                <a href="{{route('search')}}" class="flex flex-col items-center gap-1 group px-4 py-1 text-gray-400 dark:text-gray-500">
                    <svg class="w-6 h-6 transition-transform group-active:scale-90" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="11" cy="11" r="8"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35"/>
                    </svg>
                    <span class="text-[10px] font-black">جست‌وجو</span>
                </a>

            </li>
            <li>
                <a href="{{route('order.track')}}" class="flex flex-col items-center gap-1 group px-4 py-1 text-gray-400 dark:text-gray-500">
                    <svg class="w-6 h-6 transition-transform group-active:scale-90" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                    </svg>
                    <span class="text-[10px] font-black">پیگیری</span>
                </a>

            </li>
        </ul>
    </div>
</div>
<!-- END NAV MOBILE -->

<!-- END SEARCH MODAL -->


<!--Mobile Menu-->
<div id="mobile-menu" class="fixed inset-0 z-[1100] pointer-events-none">
    <div class="absolute inset-0 bg-black/40 dark:bg-black/70 opacity-0 transition-opacity duration-500 backdrop-blur-sm menu-overlay cursor-pointer"></div>
    <div class="absolute right-0 top-0 h-full w-[320px] bg-white/70 dark:bg-gray-950/80 backdrop-blur-2xl shadow-[-15px_0_50px_rgba(0,0,0,0.2)] transform translate-x-full transition-transform duration-500 pointer-events-auto flex flex-col border-l border-white/40 dark:border-white/10">
        <div class="p-5 border-b border-white/40 dark:border-gray-800 flex justify-between items-center bg-white/30 dark:bg-gray-900/30">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center shadow-lg shadow-blue-500/40">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M4 6h16M4 12h16m-7 6h7" stroke-width="2.5" stroke-linecap="round"/>
                    </svg>
                </div>
                <span class="font-black text-xl dark:text-white">منوی اصلی</span>
            </div>
            <button class="close-menu p-2 hover:bg-red-50 dark:hover:bg-red-900/20 text-gray-400 hover:text-red-500 rounded-xl transition-all border border-transparent hover:border-red-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M6 18L18 6M6 6l12 12" stroke-width="2.5" stroke-linecap="round"/>
                </svg>
            </button>
        </div>

            <nav class="px-3 pb-20 mt-3">
                <!--Product classification-->
                <div class="flex items-center gap-2 px-3 mb-3">
                    <span class="w-1 h-4 bg-blue-600 rounded-full"></span>
                    <span class="text-[11px] font-black text-gray-400 uppercase tracking-widest">دسته‌بندی کالاها</span>
                </div>
                <ul class="space-y-3">
                    <!--Digital goods-->
                    @foreach($megaCategories as $megaCategory)
                        <li class="menu-item">
                            <button class="layer-btn w-full flex items-center justify-between p-4 rounded-2xl bg-white/40 dark:bg-white/5 border border-white/60 dark:border-white/10 shadow-sm transition-all hover:bg-white/60">
                                <div class="flex items-center gap-3 text-gray-800 dark:text-gray-200">

                                    <span class="font-black text-sm">{{$megaCategory->name}}</span>
                                </div>

                            </button>
                            <ul class="hidden submenu mt-2 mr-2 space-y-2 border-r-2 border-blue-500/20 pr-2 overflow-hidden transition-all duration-300">
                             @foreach($megaCategory->superCategories as $superCategory)
                                    <li>
                                        <button class="layer-btn w-full flex items-center justify-between p-3 rounded-xl bg-white/30 dark:bg-white/5 border border-white/40 hover:bg-blue-50/50">
                                            <span class="font-bold text-xs text-gray-700 dark:text-gray-300">{{$superCategory->name}}</span>
                                            <svg class="w-3 h-3 text-gray-400 arrow-icon transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path d="M19 9l-7 7-7-7" stroke-width="3"/>
                                            </svg>
                                        </button>
                                        <ul class="hidden submenu mt-2 mr-2 space-y-2 border-r-2 border-gray-400/20 pr-2">


                                           @foreach($superCategory->categories as $category)
                                                <li>
                                                    <a href="{{route('category',['slug'=>$category->slug])}}" class="block p-2 pl-4 text-[10px] text-gray-500 dark:text-gray-400 hover:text-blue-600 transition-colors"> {{$category->name}}</a>
                                                </li>
                                           @endforeach


                                        </ul>
                                    </li>
                             @endforeach

                            </ul>
                        </li>
                    @endforeach



                </ul>

                <!--Contact information-->
                <div class="mt-8 pt-6 border-t border-white/40 dark:border-gray-800 space-y-6">
                    <div class="flex flex-col gap-3 px-3">
                        <a href="tel:09136437210" class="flex items-center gap-3 text-xs font-bold text-gray-500 dark:text-gray-400">
                            <svg class="w-5 h-5 p-1 bg-white dark:bg-gray-800 rounded-lg shadow-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" stroke-width="1.5"/>
                            </svg>
                            پشتیبانی: 09136437210

                        </a>

                    </div>
                    <!-- شبکه‌های اجتماعی -->
                    <div class="flex gap-4">
                        <a href="https://wa.me/989136437210" class="w-12 h-12 rounded-2xl bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-800 flex items-center justify-center text-gray-400 hover:text-green-500 hover:border-green-500 transition-all group">
                            <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                            </svg>
                        </a>


                        <a href="https://t.me/989136437210" class="w-12 h-12 rounded-2xl bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-800 flex items-center justify-center text-gray-400 hover:text-blue-400 hover:border-blue-400 transition-all group">
                            <svg class="w-5 h-5 group-hover:scale-110 transition-transform" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 64 64">
                                <path fill="currentColor" d="m62.8 10.8l-9.4 44c-.7 3.1-2.5 3.8-5.1 2.4L34.2 46.8l-6.9 6.6c-.7.7-1.4 1.4-3 1.4l1.1-14.5l26.3-23.9c1.1-1.1-.3-1.5-1.7-.6L17.3 36.4L3.2 32.1c-3.1-1-3.1-3.1.7-4.5L58.7 6.3c2.7-.8 5 .6 4.1 4.5"/>
                            </svg>
                        </a>

                    </div>
                </div>
            </nav>
        </div>
    </div>
</div>
<!-- Mobile Cart Drawer -->
<div id="cart-drawer" class="fixed inset-0 z-[200] pointer-events-none lg:hidden">
    <!-- Overlay -->
    <div id="cart-drawer-overlay"
         onclick="closeCartDrawer()"
         class="absolute inset-0 bg-black/50 backdrop-blur-sm opacity-0 transition-opacity duration-300"></div>

    <!-- Drawer -->
    <div id="cart-drawer-panel"
         class="absolute bottom-0 left-0 right-0 max-h-[85vh] bg-white dark:bg-gray-950 rounded-t-3xl shadow-2xl transform translate-y-full transition-transform duration-300 pointer-events-auto flex flex-col">

        <!-- Handle -->
        <div class="flex justify-center pt-3 pb-1">
            <div class="w-12 h-1.5 bg-gray-200 dark:bg-gray-700 rounded-full"></div>
        </div>

        <!-- Header -->
        <div class="flex items-center justify-between px-5 py-3 border-b border-gray-100 dark:border-gray-800">
            <h3 class="font-black text-lg dark:text-white">سبد خرید</h3>
            <button onclick="closeCartDrawer()" class="p-2 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- Cart Content -->
        <div class="overflow-y-auto flex-1 p-4" id="mobile-cart-content">
            @include('front.partials.cart-sidebar')
        </div>
    </div>
</div>
<!--END Mobile Menu-->
<script src="{{asset('front/assets/js/plugin/story-player/story-player.js')}}"></script>
<script src="{{asset('front/assets/js/plugin/swiper/swiper-bundle.min.js')}}"></script>
<script src="{{asset('front/assets/js/dependencies/swiper-script.js')}}"></script>
<script src="{{asset('front/assets/js/dependencies/app.js')}}"></script>
<script src="{{asset('choices/choices.min.js')}}"></script>
<script>
    function openCartDrawer() {
        const drawer = document.getElementById('cart-drawer');
        const panel = document.getElementById('cart-drawer-panel');
        const overlay = document.getElementById('cart-drawer-overlay');

        drawer.classList.remove('pointer-events-none');
        overlay.classList.remove('opacity-0');
        overlay.classList.add('opacity-100');
        panel.classList.remove('translate-y-full');
        document.body.style.overflow = 'hidden';
    }

    function closeCartDrawer() {
        const drawer = document.getElementById('cart-drawer');
        const panel = document.getElementById('cart-drawer-panel');
        const overlay = document.getElementById('cart-drawer-overlay');

        overlay.classList.remove('opacity-100');
        overlay.classList.add('opacity-0');
        panel.classList.add('translate-y-full');
        document.body.style.overflow = '';

        setTimeout(() => drawer.classList.add('pointer-events-none'), 300);
    }

</script>
<script>
    function refreshMobileCartDrawer(openDrawer = false) {
        fetch('{{ route("cart.mobile.drawer") }}', {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
            .then(response => response.text())
            .then(html => {
                const mobileCart = document.getElementById('mobile-cart-content');

                if (mobileCart) {
                    mobileCart.innerHTML = html;
                }

                if (openDrawer) {
                    openCartDrawer();
                }
            })
            .catch(error => {
                console.error('خطا در بروزرسانی سبد موبایل:', error);
            });
    }
</script>
<script>
    document.addEventListener('click', function (e) {
        if (!e.target.closest('.sidebar-remove-item')) return;

        const btn = e.target.closest('.sidebar-remove-item');
        const cartKey = btn.dataset.cartKey;

        fetch('{{ route("cart.remove") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ cart_key: cartKey })
        })
            .then(res => res.json())
            .then(data => {

                // آپدیت تعداد سبد بالا
                document.querySelectorAll('.cart-badge').forEach(el => {
                    el.textContent = data.cart_count;
                });
                if (window.innerWidth < 1024) {
                    refreshMobileCartDrawer(true);
                }
                // اگر سبد خالی شد → کل سایدبار را مجدد لود کن
                if (data.cart_empty) {
                    fetch('{{ route("cart.sidebar") }}')
                        .then(r => r.text())
                        .then(html => {
                            document.getElementById('cart-sidebar-content').innerHTML = html;
                        });

                    return;
                }

                // اگر سبد خالی نشد → رندر جدید
                fetch('{{ route("cart.sidebar") }}')
                    .then(r => r.text())
                    .then(html => {
                        document.getElementById('cart-sidebar-content').innerHTML = html;
                    });
            })
    });

</script>
<!-- INITIAL STORY SECTION -->
@stack('scripts')

</body>
</html>

