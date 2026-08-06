@extends('front.layout.master')


@section('meta_title', 'فروشگاه آقای صفر تا صد | تجهیزات تاسیسات')
@section('meta_description', 'خرید آنلاین تجهیزات تاسیسات، لوله، شیرآلات و اتصالات با بهترین قیمت و ارسال سریع از فروشگاه آقای صفر تا صد')
@section('meta_keywords', 'تجهیزات تاسیسات، خرید لوله، شیرآلات، اتصالات، فروشگاه تاسیسات اصفهان')

@push('canonical')
    <link rel="canonical" href="{{ route('home') }}">
@endpush




@section('content')
    <!-- SLIDER SECTION -->
    <section class="w-full transition-colors duration-500" >
        <div class="w-full px-4 sm:px-6 lg:px-8">
            <!--Slider-->
            <div class="relative group overflow-hidden rounded-2xl sm:rounded-3xl lg:rounded-[2.5rem]">

                <div class="swiper mainHeroSwiper h-full min-h-[300px] sm:min-h-[400px] lg:min-h-[500px]" >
                    <div class="swiper-wrapper" >
                        @foreach($sliders as $slider)
                            <div class="swiper-slide relative">
                                <!-- اضافه شدن pointer-events-none -->
                                <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent pointer-events-none z-10"></div>

                                <!-- اضافه شدن کلاس‌ها برای پر کردن کل فضای اسلاید -->
                                <a href="{{$slider->url}}" class="block w-full h-full relative z-20">
                                    <img src="{{asset('banners/'.$slider->image)}}" alt="{{$slider->image_alt}}" title="{{$slider->image_title}}" class="w-full h-full object-cover">
                                </a>
                            </div>
                        @endforeach



                    </div>
                    <div class="absolute bottom-4 left-4 sm:bottom-8 sm:left-8 flex gap-2 sm:gap-3 z-10">
                        <div class="swiper-button-prev-custom w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-white/20 backdrop-blur-md border border-white/30 text-white flex items-center justify-center cursor-pointer hover:bg-white hover:text-blue-600 transition-all">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                        <div class="swiper-button-next-custom w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-white/20 backdrop-blur-md border border-white/30 text-white flex items-center justify-center cursor-pointer hover:bg-white hover:text-blue-600 transition-all">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </div>
                    <div class="swiper-pagination !bottom-4 sm:!bottom-8 !right-4 sm:!right-8 !left-auto !w-auto"></div>
                </div>
            </div>
        </div>
    </section>


    <!-- END SLIDER SECTION -->
    <!-- CATEGORY SECTION -->
    <section class="relative overflow-hidden py-16 transition-colors duration-700">
        <div class="container relative z-10">
            <!-- Header -->
            <div class="flex items-end justify-between mb-10 gap-4 flex-wrap">
                <div class="flex items-center gap-6">
                    <div class="relative group">
                        <div class="relative w-16 h-16 bg-white dark:bg-black border border-gray-100 dark:border-blue-500/40 rounded-[1.8rem] flex items-center justify-center text-blue-600 shadow-2xl">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <h2 class="text-3xl font-black text-gray-900 dark:text-white tracking-tight">دسته‌بندی‌ها</h2>
                        <p class="text-[10px] font-black text-blue-500 uppercase tracking-[0.4em] mt-2 flex items-center gap-2">
                            <span class="w-8 h-[2px] bg-blue-500/30"></span>
                            Categories
                        </p>
                    </div>
                </div>
                <a href="{{route('search')}}" class="group/link relative overflow-hidden px-8 py-3.5 rounded-2xl transition-all duration-500 flex items-center gap-3 bg-white/40 backdrop-blur-md border border-gray-200 text-gray-800 hover:border-blue-500/50 hover:text-white dark:bg-white/[0.03] dark:border-white/10 dark:text-gray-300 dark:hover:text-white">
                    <span class="absolute inset-0 bg-blue-600 translate-y-full group-hover/link:translate-y-0 transition-transform duration-500 ease-out"></span>
                    <span class="relative z-10 text-[13px] font-black tracking-tight">مشاهده تمامی محصولات</span>
                    <div class="relative z-10 w-5 h-5 flex items-center justify-center bg-blue-600/10 dark:bg-white/5 rounded-lg group-hover/link:bg-white/20 transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </div>
                </a>
            </div>
            <!-- Filter Buttons -->
            <div class="flex gap-3 mb-6 overflow-x-auto pb-2">
                @foreach($superCategories as $index=>$superCategory)
                    <button
                        class="category-filter-btn px-4 py-2 rounded-lg whitespace-nowrap
    {{ $index === 0 ? 'active bg-blue-600 text-white' : 'bg-gray-200 text-gray-700' }}"
                        data-category="{{$superCategory->id}}">
                        {{$superCategory->name}}
                    </button>

                @endforeach

            </div>
            <!-- Category Slider -->

                <div class="swiper categorySwiper !overflow-visible">
                    <div class="swiper-wrapper">
                        <!-- Slide 1 - گوشی موبایل -->
                        @foreach($superCategories as $superCategory)
                            @foreach($superCategory->categories as $category)
                                <div class="swiper-slide h-auto p-2" data-category="{{$superCategory->id}}">
                                    <a href="{{route('category',['slug'=>$category->slug])}}">
                                        <div class="group relative h-full pt-10">
                                            <div class="absolute inset-0 bg-white/80 dark:bg-[#0a0a0a]/40 backdrop-blur-3xl rounded-[2.8rem] border border-gray-100 dark:border-white/5 shadow-sm transition-all duration-500 group-hover:border-blue-400/40 group-hover:shadow-blue-500/15"></div>
                                            <div class="relative p-5 flex flex-col h-full z-10 transition-transform duration-500 group-hover:-translate-y-4">

                                                <div class="relative mb-6 overflow-hidden rounded-[2rem] h-48 shadow-lg">
                                                    <img src="{{asset('category/'.$category->image)}}" class="w-full h-full object-cover transition-all duration-1000 group-hover:scale-110" alt="{{$category->image_alt}}" title="{{$category->image_title}}">
                                                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                                </div>
                                                <h3 class="text-[18px] font-black text-gray-800 dark:text-gray-100 mb-6 leading-7"> {{$category->name}}</h3>
                                                <div class="flex items-center justify-between mt-auto pt-5 border-t border-gray-100 dark:border-white/5">

                                                    <div class="w-10 h-10 bg-primary-500 dark:bg-primary-600 text-white rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-all">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"/>
                                                        </svg>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach

                        @endforeach

                    </div>
                </div>



            <!-- Navigation Buttons -->
            <div class="flex justify-center gap-6 mt-12">
                <div class="swiper-cat-prev w-14 h-14 rounded-2xl bg-white/50 dark:bg-white/5 dark:text-white border border-white dark:border-white/10 flex items-center justify-center cursor-pointer hover:bg-blue-600 hover:text-white transition-all shadow-lg group">
                    <svg class="w-6 h-6 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
                <div class="swiper-cat-next w-14 h-14 rounded-2xl bg-white/50 dark:bg-white/5 dark:text-white border border-white dark:border-white/10 flex items-center justify-center cursor-pointer hover:bg-blue-600 hover:text-white transition-all shadow-lg group">
                    <svg class="w-6 h-6 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                    </svg>
                </div>
            </div>
        </div>
    </section>
    <!-- END CATEGORY SECTION -->



    <!-- AMAZING SECTION -->
    <section class="amazing-deals-section relative overflow-hidden transition-colors duration-500">
        <div class="container pb-4 relative z-10">

            <!-- Header -->
            <div class="flex flex-col lg:flex-row items-center justify-between mb-8 gap-8 bg-white/30 dark:bg-white/[0.02] backdrop-blur-md p-8 rounded-[3rem] border border-white/50 dark:border-white/10 shadow-xl">

                <div class="flex items-center gap-5">
                    <div class="relative">
                        <div class="absolute inset-0 bg-secondary-500 blur-lg opacity-40 animate-ping"></div>
                        <div class="relative w-4 h-12 bg-secondary-500 rounded-full"></div>
                    </div>
                    <div>
                        <h2 class="text-4xl font-black text-gray-900 dark:text-white tracking-tight">
                            پیشنهاد <span class="text-secondary-600">شگفت‌انگیز</span>
                        </h2>
                        <p class="text-gray-500 dark:text-gray-400 font-medium mt-1">تخفیف‌های ویژه فقط برای امروز</p>
                    </div>
                </div>

                <div class="flex items-center gap-4 bg-black/5 dark:bg-white/5 p-3 rounded-2xl border border-black/5 dark:border-white/5">
                    <div class="flex gap-3 text-2xl font-black dark:text-white" id="special-timer-unique">
                        <div class="timer-box flex flex-col items-center">
                            <span class="bg-secondary-500 text-white px-3 py-1 rounded-xl shadow-lg shadow-red-500/30">۰۰</span>
                            <span class="text-[10px] mt-1 opacity-50">ثانیه</span>
                        </div>
                        <span class="mt-1 text-secondary-600">:</span>
                        <div class="timer-box flex flex-col items-center">
                            <span>۰۰</span>
                            <span class="text-[10px] mt-1 opacity-50">دقیقه</span>
                        </div>
                        <span class="mt-1 opacity-20">:</span>
                        <div class="timer-box flex flex-col items-center">
                            <span>۰۰</span>
                            <span class="text-[10px] mt-1 opacity-50">ساعت</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Replace slider with banner -->
            <a href="{{$discountBanner->url}}" class="block rounded-[3rem] overflow-hidden shadow-2xl border border-white/40 dark:border-white/10 transition-transform duration-300 hover:scale-[1.02]">
                <img src="{{asset('banners/'.$discountBanner->image)}}" class="w-full h-64 md:h-80 lg:h-96 object-cover" alt="{{$discountBanner->image_alt}}" title="{{$discountBanner->image_title}}">
            </a>



        </div>
    </section>
    <!-- END AMAZING SECTION -->



    <!-- MAG -->
    <section class="magazine-section relative overflow-hidden py-16 transition-colors duration-700">
        <div class="container relative z-10">
            <div class="flex items-end justify-between mb-10 gap-4 flex-wrap">
                <div class="flex items-center gap-6">
                    <div class="relative group">
                        <div class="relative w-16 h-16 bg-white dark:bg-black border border-gray-100 dark:border-blue-500/40 rounded-[1.8rem] flex items-center justify-center text-blue-600 shadow-2xl">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l4 4v10a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <h2 class="text-3xl font-black text-gray-900 dark:text-white tracking-tight"> بلاگ</h2>
                        <p class="text-[10px] font-black text-blue-500 uppercase tracking-[0.4em] mt-2 flex items-center gap-2">
                            <span class="w-8 h-[2px] bg-blue-500/30"></span>
                           Blogs

                        </p>
                    </div>
                </div>
                <a href="{{route('blogs')}}" class="group/link relative overflow-hidden px-8 py-3.5 rounded-2xl transition-all duration-500 flex items-center gap-3 bg-white/40 backdrop-blur-md border border-gray-200 text-gray-800 hover:border-blue-500/50 hover:text-white dark:bg-white/[0.03] dark:border-white/10 dark:text-gray-300 dark:hover:text-white">
                    <span class="absolute inset-0 bg-blue-600 translate-y-full group-hover/link:translate-y-0 transition-transform duration-500 ease-out"></span>
                    <span class="relative z-10 text-[13px] font-black tracking-tight">مشاهده همه مطالب</span>
                    <div class="relative z-10 w-5 h-5 flex items-center justify-center bg-blue-600/10 dark:bg-white/5 rounded-lg group-hover/link:bg-white/20 transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </div>
                </a>
            </div>
            <div class="swiper magazineSwiper !overflow-visible">
                <div class="swiper-wrapper">
                    @foreach($blogs as $blog)
                        <div class="swiper-slide h-auto p-4">
                            <a href="{{route('front.blog.show',['slug'=>$blog->slug])}}">
                                <div class="group relative h-full pt-10">
                                    <div class="absolute inset-0 bg-white/80 dark:bg-[#0a0a0a]/40 backdrop-blur-3xl rounded-[2.8rem] border border-gray-100 dark:border-white/5 shadow-sm transition-all duration-500 group-hover:border-blue-400/40 group-hover:shadow-blue-500/15"></div>
                                    <div class="relative p-5 flex flex-col h-full z-10 transition-transform duration-500 group-hover:-translate-y-4">

                                        <div class="relative mb-6 overflow-hidden rounded-[2rem] h-48 shadow-lg">
                                            <img src="{{'blog/'.$blog->image}}" class="w-full h-full object-cover transition-all duration-1000 group-hover:scale-110" alt="{{$blog->image_alt}}" title="{{$blog->image_title}}">
                                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                        </div>
                                        <div class="flex items-center gap-4 mb-4 text-[11px] font-bold text-gray-400">

                                            <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                                            <span class="tabular-nums">{{ \Morilog\Jalali\Jalalian::fromDateTime($blog->created_at)->format('Y/m/d') }}</span>
                                        </div>
                                        <h3 class="text-[16px] font-black text-gray-800 dark:text-gray-100 mb-6 line-clamp-2 leading-7 h-14 group-hover:text-blue-600 transition-colors">{{$blog->title}}
                                        </h3>
                                        <div class="flex items-center justify-between mt-auto pt-5 border-t border-gray-100 dark:border-white/5">

                                            <div class="w-10 h-10 bg-primary-500 dark:bg-primary-600 text-white rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-all">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"/>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach


                </div>
            </div>
            <div class="flex justify-center gap-6 mt-12">
                <div class="swiper-nav-prev w-14 h-14 rounded-2xl bg-white/50 dark:bg-white/5 dark:text-white border border-white dark:border-white/10 flex items-center justify-center cursor-pointer hover:bg-blue-600 hover:text-white transition-all shadow-lg group">
                    <svg class="w-6 h-6 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
                <div class="swiper-nav-next w-14 h-14 rounded-2xl bg-white/50 dark:bg-white/5 dark:text-white border border-white dark:border-white/10 flex items-center justify-center cursor-pointer hover:bg-blue-600 hover:text-white transition-all shadow-lg group">
                    <svg class="w-6 h-6 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                    </svg>
                </div>
            </div>
        </div>
    </section>
    <!-- END MAG -->

    <!-- 4 BANNERS SECTION -->
    <section class="banners-section py-16">
        <div class="container relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Banner 1 -->
                <a href="{{$banner1->url}}" class="group relative overflow-hidden rounded-[2rem] h-64 md:h-80 shadow-lg block">
                    <img src="{{'banners/'.$banner1->image}}"
                         class="w-full h-full object-cover transition-all duration-700 group-hover:scale-110"
                         alt="{{$banner1->image_alt}}"
                         title="{{$banner1->image_title}}">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent"></div>
                </a>

                <!-- Banner 2 -->
                <a href="{{$banner2->url}}" class="group relative overflow-hidden rounded-[2rem] h-64 md:h-80 shadow-lg block">
                    <img src="{{'banners/'.$banner2->image}}"
                         class="w-full h-full object-cover transition-all duration-700 group-hover:scale-110"
                         alt="{{$banner2->image_alt}}"
                         title="{{$banner2->image_title}}">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent"></div>
                </a>

                <!-- Banner 3 -->
                <a href="{{$banner3->url}}" class="group relative overflow-hidden rounded-[2rem] h-64 md:h-80 shadow-lg block">
                    <img src="{{'banners/'.$banner3->image}}"
                         class="w-full h-full object-cover transition-all duration-700 group-hover:scale-110"
                         alt="{{$banner3->image_alt}}"
                         title="{{$banner3->image_title}}">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent"></div>
                </a>

                <!-- Banner 4 -->
                <a href="{{$banner4->url}}" class="group relative overflow-hidden rounded-[2rem] h-64 md:h-80 shadow-lg block">
                    <img src="{{'banners/'.$banner4->image}}"
                         class="w-full h-full object-cover transition-all duration-700 group-hover:scale-110"
                         alt="{{$banner4->image_alt}}"
                         title="{{$banner4->image_title}}">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent"></div>
                </a>
            </div>
        </div>
    </section>


    <!-- SHOP FEATURE -->
    <section class="relative overflow-hidden transition-colors duration-500">
        <div class="container pt-5">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-12 lg:gap-8">
                <div class="flex flex-col items-center text-center group">
                    <div class="relative w-20 h-20 mb-6 flex items-center justify-center">
                        <div class="absolute inset-0 bg-blue-500/10 dark:bg-blue-500/20 blur-2xl rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        <div class="relative z-10 w-full h-full bg-white dark:bg-gray-900 rounded-[2rem] border border-gray-100 dark:border-gray-800 shadow-sm transition-all duration-500 group-hover:-translate-y-2 group-hover:border-blue-500/50 group-hover:shadow-xl group-hover:shadow-blue-500/10 flex items-center justify-center">
                            <svg class="w-9 h-9 text-gray-700 dark:text-gray-300 group-hover:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-sm font-black text-gray-900 dark:text-white mb-2 transition-colors group-hover:text-blue-600 dark:group-hover:text-blue-400">ارسال فوق سریع</h3>
                    <p class="text-[11px] text-gray-500 dark:text-gray-400 leading-6 max-w-[150px]">تحویل کالا در  سراسر کشور</p>
                </div>
                <div class="flex flex-col items-center text-center group">
                    <div class="relative w-20 h-20 mb-6 flex items-center justify-center">
                        <div class="absolute inset-0 bg-secondary-500/10 dark:bg-secondary-500/20 blur-2xl rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        <div class="relative z-10 w-full h-full bg-white dark:bg-gray-900 rounded-[2rem] border border-gray-100 dark:border-gray-800 shadow-sm transition-all duration-500 group-hover:-translate-y-2 group-hover:border-secondary-500/50 group-hover:shadow-xl group-hover:shadow-secondary-500/10 flex items-center justify-center">
                            <svg class="w-9 h-9 text-gray-700 dark:text-gray-300 group-hover:text-secondary-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 15v-1a4 4 0 00-4-4H8m0 0l3 3m-3-3l3-3m9 14V5a2 2 0 00-2-2H6a2 2 0 00-2 2v16l4-2 4 2 4-2 4 2z"/>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-sm font-black text-gray-900 dark:text-white mb-2 transition-colors group-hover:text-secondary-600 dark:group-hover:text-secondary-500">قیمت مناسب</h3>
                    <p class="text-[11px] text-gray-500 dark:text-gray-400 leading-6 max-w-[150px]">کیفت بالا کالاهای ساختمانی</p>
                </div>
                <div class="flex flex-col items-center text-center group">
                    <div class="relative w-20 h-20 mb-6 flex items-center justify-center">
                        <div class="absolute inset-0 bg-emerald-500/10 dark:bg-emerald-500/20 blur-2xl rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        <div class="relative z-10 w-full h-full bg-white dark:bg-gray-900 rounded-[2rem] border border-gray-100 dark:border-gray-800 shadow-sm transition-all duration-500 group-hover:-translate-y-2 group-hover:border-emerald-500/50 group-hover:shadow-xl group-hover:shadow-emerald-500/10 flex items-center justify-center">
                            <svg class="w-9 h-9 text-gray-700 dark:text-gray-300 group-hover:text-emerald-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-sm font-black text-gray-900 dark:text-white mb-2 transition-colors group-hover:text-emerald-600 dark:group-hover:text-emerald-500">پرداخت امن</h3>
                    <p class="text-[11px] text-gray-500 dark:text-gray-400 leading-6 max-w-[150px]">استفاده از پروتکل‌های امن و درگاه‌های معتبر</p>
                </div>
                <div class="flex flex-col items-center text-center group">
                    <div class="relative w-20 h-20 mb-6 flex items-center justify-center">
                        <div class="absolute inset-0 bg-indigo-500/10 dark:bg-indigo-500/20 blur-2xl rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        <div class="relative z-10 w-full h-full bg-white dark:bg-gray-900 rounded-[2rem] border border-gray-100 dark:border-gray-800 shadow-sm transition-all duration-500 group-hover:-translate-y-2 group-hover:border-indigo-500/50 group-hover:shadow-xl group-hover:shadow-indigo-500/10 flex items-center justify-center">
                            <svg class="w-9 h-9 text-gray-700 dark:text-gray-300 group-hover:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-sm font-black text-gray-900 dark:text-white mb-2 transition-colors group-hover:text-indigo-600 dark:group-hover:text-indigo-400">ضمانت اصالت</h3>
                    <p class="text-[11px] text-gray-500 dark:text-gray-400 leading-6 max-w-[150px]">تضمین ۱۰۰٪ کالاها با گارانتی معتبر</p>
                </div>
            </div>
        </div>
    </section>



@endsection
