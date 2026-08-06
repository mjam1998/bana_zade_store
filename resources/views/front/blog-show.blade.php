@extends('front.layout.master')

@section('meta_title', $blog->meta_title ?? $blog->title . ' | بلاگ آقای صفر تا صد')
@section('meta_description', $blog->meta_description ?? Str::limit(strip_tags($blog->description), 160))
@section('meta_keywords', $blog->keywords ?? '')
@section('og_type', 'article')
@section('og_image', $blog->image ? asset('blog/' . $blog->image) : asset('front/assets/images/logo.png'))

@push('canonical')
    <link rel="canonical" href="{{ route('front.blog.show', $blog->slug) }}">
@endpush

@section('content')
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
        <div class="container mx-auto px-4">
            <!-- بازگشت به لیست بلاگ‌ها -->
            <div class="mb-6">
                <a href="{{ route('blogs') }}" class="inline-flex items-center text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 transition-colors">
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    بازگشت به بلاگ‌ها
                </a>
            </div>

            <!-- محتوای اصلی -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- محتوای بلاگ -->
                <div class="lg:col-span-2">
                    <article class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden">
                        <!-- تصویر اصلی -->
                        @if($blog->image)
                            <div class="w-full h-96 overflow-hidden">
                                <img src="{{ asset('blog/' . $blog->image) }}"
                                     alt="{{ $blog->image_alt }}"
                                     title="{{ $blog->image_title }}"
                                     class="w-full h-full object-cover">
                            </div>
                        @endif

                        <!-- محتوای متنی -->
                        <div class="p-8">
                            <!-- عنوان -->
                            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                                {{ $blog->title }}
                            </h1>

                            <!-- متا اطلاعات -->
                            <div class="flex items-center gap-4 text-sm text-gray-600 dark:text-gray-400 mb-8 pb-8 border-b border-gray-200 dark:border-gray-700">
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <span>{{ \Morilog\Jalali\Jalalian::fromDateTime($blog->created_at)->format('d F Y') }}</span>
                                </div>
                            </div>

                            <!-- کلمات کلیدی -->
                            @if($blog->keywords)
                                @php
                                    $keywords = json_decode($blog->keywords, true);
                                @endphp
                                @if(is_array($keywords) && count($keywords) > 0)
                                    <div class="mb-8 pb-8 border-b border-gray-200 dark:border-gray-700">
                                        <div class="flex items-center gap-2 flex-wrap">
                                            <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                            </svg>
                                            @foreach($keywords as $keyword)
                                                @if(isset($keyword['value']))
                                                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-blue-100 text-blue-800 dark:bg-blue-500/20 dark:text-blue-300 border border-blue-200 dark:border-blue-500/30">
                                                        {{ $keyword['value'] }}
                                                    </span>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            @endif

                            <!-- محتوای HTML -->
                            <div class="prose prose-lg dark:prose-invert max-w-none blog-content">
                                {!! $blog->description !!}
                            </div>
                        </div>
                    </article>
                </div>

                <!-- سایدبار -->
                <div class="lg:col-span-1">
                    <!-- مقالات مرتبط -->
                    @if($relatedBlogs->count() > 0)
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 sticky top-8">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6">
                                مقالات مرتبط
                            </h3>
                            <div class="space-y-4">
                                @foreach($relatedBlogs as $related)
                                    <a href="{{ route('front.blog.show', $related->slug) }}"
                                       class="group block">
                                        <div class="flex gap-4">
                                            @if($related->image)
                                                <div class="w-20 h-20 rounded-lg overflow-hidden flex-shrink-0">
                                                    <img src="{{ asset('blog/' . $related->image) }}"
                                                         alt="{{ $related->image_alt }}"
                                                         title="{{ $related->image_title }}"
                                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                                </div>
                                            @endif
                                            <div class="flex-1 min-w-0">
                                                <h4 class="text-sm font-semibold text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors line-clamp-2 mb-2">
                                                    {{ $related->title }}
                                                </h4>
                                                <p class="text-xs text-gray-600 dark:text-gray-400">
                                                    {{ \Morilog\Jalali\Jalalian::fromDateTime($related->created_at)->format('d F Y') }}
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                    @if(!$loop->last)
                                        <div class="border-b border-gray-200 dark:border-gray-700"></div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <style>
        /* استایل‌های محتوای بلاگ - با !important برای override کردن inline styles */
        .blog-content {
            color: #374151;
        }

        .dark .blog-content {
            color: #e5e7eb !important;
        }

        .blog-content p {
            margin-bottom: 1.5rem;
            line-height: 1.8;
            color: #374151;
        }

        .dark .blog-content p {
            color: #e5e7eb !important;
        }

        .blog-content span {
            color: inherit !important;
        }

        .dark .blog-content span {
            color: #e5e7eb !important;
        }

        .blog-content strong {
            font-weight: 700;
            color: #111827;
        }

        .dark .blog-content strong {
            color: #f3f4f6 !important;
        }

        .blog-content div {
            color: #374151;
        }

        .dark .blog-content div {
            color: #e5e7eb !important;
        }

        .blog-content img {
            max-width: 100%;
            height: auto;
            border-radius: 0.75rem;
            margin: 2rem auto;
            display: block;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        .dark .blog-content img {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3);
        }

        .blog-content table {
            width: 100%;
            border-collapse: collapse;
            margin: 2rem 0;
            background: white;
            border-radius: 0.75rem;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .dark .blog-content table {
            background: #1f2937;
        }

        .blog-content th,
        .blog-content td {
            padding: 1rem;
            text-align: right;
            border-bottom: 1px solid #e5e7eb;
            color: #374151;
        }

        .dark .blog-content th,
        .dark .blog-content td {
            border-bottom-color: #374151;
            color: #e5e7eb !important;
        }

        .blog-content th {
            background: #f9fafb;
            font-weight: 700;
            color: #111827;
        }

        .dark .blog-content th {
            background: #111827;
            color: #f3f4f6 !important;
        }

        .blog-content ul,
        .blog-content ol {
            margin: 1.5rem 0;
            padding-right: 2rem;
        }

        .blog-content li {
            margin-bottom: 0.75rem;
            line-height: 1.8;
            color: #374151;
        }

        .dark .blog-content li {
            color: #e5e7eb !important;
        }

        .blog-content a {
            color: #2563eb;
            text-decoration: underline;
        }

        .dark .blog-content a {
            color: #60a5fa !important;
        }

        .blog-content blockquote {
            border-right: 4px solid #2563eb;
            padding: 1rem 1.5rem;
            margin: 2rem 0;
            background: #f9fafb;
            border-radius: 0.5rem;
            font-style: italic;
            color: #374151;
        }

        .dark .blog-content blockquote {
            background: #1f2937;
            border-right-color: #60a5fa;
            color: #e5e7eb !important;
        }

        .blog-content h1,
        .blog-content h2,
        .blog-content h3,
        .blog-content h4,
        .blog-content h5,
        .blog-content h6 {
            font-weight: 700;
            margin-top: 2rem;
            margin-bottom: 1rem;
            color: #111827;
        }

        .dark .blog-content h1,
        .dark .blog-content h2,
        .dark .blog-content h3,
        .dark .blog-content h4,
        .dark .blog-content h5,
        .dark .blog-content h6 {
            color: #f3f4f6 !important;
        }

        .blog-content h2 {
            font-size: 1.875rem;
        }

        .blog-content h3 {
            font-size: 1.5rem;
        }

        .blog-content code {
            background: #f3f4f6;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-family: 'Courier New', monospace;
            font-size: 0.875rem;
            color: #111827;
        }

        .dark .blog-content code {
            background: #374151;
            color: #e5e7eb !important;
        }

        .blog-content pre {
            background: #1f2937;
            color: #f9fafb;
            padding: 1.5rem;
            border-radius: 0.75rem;
            overflow-x: auto;
            margin: 2rem 0;
        }

        .blog-content pre code {
            background: transparent;
            padding: 0;
            color: #f9fafb !important;
        }
    </style>
@endsection
