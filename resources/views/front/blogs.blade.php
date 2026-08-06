@extends('front.layout.master')

@section('content')
    <!-- BLOGS SECTION -->
    <section class="relative overflow-hidden py-16 transition-colors duration-700">
        <div class="container relative z-10">
            <!-- Header -->
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
                        <h2 class="text-3xl font-black text-gray-900 dark:text-white tracking-tight">بلاگ</h2>
                        <p class="text-[10px] font-black text-blue-500 uppercase tracking-[0.4em] mt-2 flex items-center gap-2">
                            <span class="w-8 h-[2px] bg-blue-500/30"></span>
                            Blogs
                        </p>
                    </div>
                </div>
            </div>

            <!-- Search Box -->
            <form method="GET" action="{{ route('blogs') }}" class="mb-10">
                <div class="relative max-w-2xl mx-auto">
                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="جستجو در مقالات..."
                           class="w-full px-6 py-4 pr-14 rounded-2xl bg-white dark:bg-gray-800/80 border border-gray-200 dark:border-gray-700 text-sm font-bold text-gray-700 dark:text-gray-200 focus:border-blue-500 dark:focus:border-blue-400 focus:ring-2 focus:ring-blue-500/20 outline-none transition-all shadow-lg hover:shadow-xl backdrop-blur-xl">
                    <button type="submit" class="absolute right-5 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-500 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </button>
                </div>
            </form>

            @if($latestBlog || $featuredBlogs->count() > 0 || $blogs->count() > 0)
                <!-- Featured Section -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-10">
                    <!-- Latest Blog (Large) -->
                    @if($latestBlog)
                        <a href="{{ route('front.blog.show', $latestBlog->slug) }}" class="group relative lg:row-span-2 h-full min-h-[500px]">
                            <div class="absolute inset-0 bg-white/80 dark:bg-[#0a0a0a]/40 backdrop-blur-3xl rounded-[2.8rem] border border-gray-100 dark:border-white/5 shadow-xl transition-all duration-500 group-hover:border-blue-400/40 group-hover:shadow-blue-500/20"></div>
                            <div class="relative p-6 flex flex-col h-full z-10 transition-transform duration-500 group-hover:-translate-y-2">
                                <!-- Badge -->
                                <div class="absolute top-8 right-8 z-20 bg-blue-600 text-white px-4 py-2 rounded-xl text-xs font-black shadow-lg">
                                    جدیدترین
                                </div>

                                <!-- Image -->
                                <div class="relative mb-6 overflow-hidden rounded-[2rem] h-64 shadow-lg">
                                    <img src="{{ asset('blog/'.$latestBlog->image) }}"
                                         class="w-full h-full object-cover transition-all duration-1000 group-hover:scale-110"
                                         alt="{{ $latestBlog->image_alt }}"
                                         title="{{ $latestBlog->image_title }}">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                </div>

                                <!-- Date -->
                                <div class="flex items-center gap-4 mb-4 text-xs font-bold text-gray-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <span class="tabular-nums">{{ \Morilog\Jalali\Jalalian::fromDateTime($latestBlog->created_at)->format('Y/m/d') }}</span>
                                </div>

                                <!-- Title -->
                                <h3 class="text-2xl font-black text-gray-800 dark:text-gray-100 mb-4 leading-9 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                                    {{ $latestBlog->title }}
                                </h3>



                                <!-- Read More Button -->
                                <div class="flex items-center justify-between mt-auto pt-6 border-t border-gray-100 dark:border-white/5">
                                    <span class="text-sm font-bold text-gray-700 dark:text-gray-300"> مشاهده</span>
                                    <div class="w-12 h-12 bg-blue-600 dark:bg-blue-500 text-white rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-all">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endif

                    <!-- Featured Blogs (2 Medium Cards) -->
                    <div class="flex flex-col gap-6">
                        @foreach($featuredBlogs as $blog)
                            <a href="{{ route('front.blog.show', $blog->slug) }}" class="group relative h-full min-h-[240px]">
                                <div class="absolute inset-0 bg-white/80 dark:bg-[#0a0a0a]/40 backdrop-blur-3xl rounded-[2.8rem] border border-gray-100 dark:border-white/5 shadow-sm transition-all duration-500 group-hover:border-blue-400/40 group-hover:shadow-blue-500/15"></div>
                                <div class="relative p-5 flex gap-5 h-full z-10 transition-transform duration-500 group-hover:-translate-y-2">
                                    <!-- Image -->
                                    <div class="relative overflow-hidden rounded-[1.5rem] w-40 h-full shadow-lg flex-shrink-0">
                                        <img src="{{ asset('blog/'.$blog->image) }}"
                                             class="w-full h-full object-cover transition-all duration-1000 group-hover:scale-110"
                                             alt="{{ $blog->image_alt }}"
                                             title="{{ $blog->image_title }}">
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                    </div>

                                    <!-- Content -->
                                    <div class="flex flex-col flex-1">
                                        <!-- Date -->
                                        <div class="flex items-center gap-2 mb-3 text-[11px] font-bold text-gray-400">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                            <span class="tabular-nums">{{ \Morilog\Jalali\Jalalian::fromDateTime($blog->created_at)->format('Y/m/d') }}</span>
                                        </div>

                                        <!-- Title -->
                                        <h3 class="text-base font-black text-gray-800 dark:text-gray-100 mb-3 line-clamp-2 leading-6 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                                            {{ $blog->title }}
                                        </h3>



                                        <!-- Read More -->
                                        <div class="flex items-center justify-between mt-auto pt-4 border-t border-gray-100 dark:border-white/5">
                                            <span class="text-xs font-bold text-gray-700 dark:text-gray-300"> مشاهده</span>
                                            <div class="w-9 h-9 bg-blue-600 dark:bg-blue-500 text-white rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-all">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"/>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- Regular Blog Grid -->
                @if($blogs->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @foreach($blogs as $blog)
                            <a href="{{ route('front.blog.show', $blog->slug) }}" class="group relative h-full">
                                <div class="absolute inset-0 bg-white/80 dark:bg-[#0a0a0a]/40 backdrop-blur-3xl rounded-[2.8rem] border border-gray-100 dark:border-white/5 shadow-sm transition-all duration-500 group-hover:border-blue-400/40 group-hover:shadow-blue-500/15"></div>
                                <div class="relative p-5 flex flex-col h-full z-10 transition-transform duration-500 group-hover:-translate-y-2">
                                    <!-- Image -->
                                    <div class="relative mb-6 overflow-hidden rounded-[2rem] h-48 shadow-lg">
                                        <img src="{{ asset('blog/'.$blog->image) }}"
                                             class="w-full h-full object-cover transition-all duration-1000 group-hover:scale-110"
                                             alt="{{ $blog->image_alt }}"
                                             title="{{ $blog->image_title }}">
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                    </div>

                                    <!-- Date -->
                                    <div class="flex items-center gap-4 mb-4 text-[11px] font-bold text-gray-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <span class="tabular-nums">{{ \Morilog\Jalali\Jalalian::fromDateTime($blog->created_at)->format('Y/m/d') }}</span>
                                    </div>

                                    <!-- Title -->
                                    <h3 class="text-[16px] font-black text-gray-800 dark:text-gray-100 mb-4 line-clamp-2 leading-7 h-14 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                                        {{ $blog->title }}
                                    </h3>



                                    <!-- Read More Button -->
                                    <div class="flex items-center justify-between mt-auto pt-5 border-t border-gray-100 dark:border-white/5">
                                        <span class="text-xs font-bold text-gray-700 dark:text-gray-300">مشاهده</span>
                                        <div class="w-10 h-10 bg-blue-600 dark:bg-blue-500 text-white rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-all">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
            @else
                <!-- Empty State -->
                <div class="flex flex-col items-center justify-center py-20">
                    <div class="relative w-32 h-32 mb-6">
                        <div class="absolute inset-0 bg-gradient-to-br from-blue-500/20 to-purple-500/20 dark:from-blue-500/10 dark:to-purple-500/10 rounded-full blur-2xl"></div>
                        <div class="relative w-full h-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-full flex items-center justify-center shadow-xl">
                            <svg class="w-16 h-16 text-gray-400 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l4 4v10a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-2xl font-black text-gray-800 dark:text-gray-200 mb-2">مقاله‌ای یافت نشد</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">در حال حاضر مقاله‌ای برای نمایش وجود ندارد</p>
                </div>
            @endif

            <!-- Pagination -->
            @if($blogs->hasPages())
                <div class="mt-12 flex justify-center">
                    {{ $blogs->appends(['search' => request('search')])->links() }}
                </div>
            @endif
        </div>
    </section>
    <!-- END BLOGS SECTION -->
@endsection

