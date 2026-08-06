@extends('front.layout.master')


@section('meta_title', $page->meta_title ?? $page->title . ' | بلاگ آقای صفر تا صد')
@section('meta_description', $page->meta_description ?? Str::limit(strip_tags($page->description), 160))

@section('og_type', 'article')


@push('canonical')
    <link rel="canonical" href="{{ route('page', $page->slug) }}">
@endpush

@section('content')
    <section class="py-20 px-4">
        <div class="container max-w-4xl">

            <!-- Main Card -->
            <div class="relative bg-white/60 dark:bg-gray-900/90 backdrop-blur-2xl p-8 sm:p-10 rounded-[2.5rem] border border-white/50 dark:border-gray-700/50 shadow-2xl">

                <!-- Title -->
                <div class="text-center mb-8">
                    <h2 class="text-2xl font-black text-gray-900 dark:text-white">{{ $page->title }}</h2>
                </div>

                <!-- Divider -->
                <div class="w-16 h-1 bg-blue-500/40 rounded-full mx-auto mb-8"></div>

                <!-- Dynamic Content -->
                <div class="prose prose-lg dark:prose-invert max-w-none text-right
                            prose-p:text-gray-700 dark:prose-p:text-gray-300
                            prose-headings:font-black prose-headings:text-gray-900 dark:prose-headings:text-white
                            prose-strong:text-gray-900 dark:prose-strong:text-white
                            prose-a:text-blue-600 dark:prose-a:text-blue-400 prose-a:no-underline hover:prose-a:underline
                            prose-img:rounded-2xl prose-img:shadow-lg prose-img:mx-auto prose-img:border prose-img:border-white/50 dark:prose-img:border-gray-700/50
                            prose-table:w-full prose-table:rounded-2xl prose-table:overflow-hidden
                            prose-thead:bg-gray-100/80 dark:prose-thead:bg-gray-800/80
                            prose-th:text-gray-700 dark:prose-th:text-gray-300 prose-th:font-black prose-th:p-3
                            prose-td:text-gray-600 dark:prose-td:text-gray-400 prose-td:p-3
                            prose-tr:border-gray-200 dark:prose-tr:border-gray-700
                            prose-blockquote:border-blue-500 prose-blockquote:bg-blue-50/50 dark:prose-blockquote:bg-blue-900/20 prose-blockquote:rounded-2xl prose-blockquote:px-6
                            prose-code:bg-gray-100 dark:prose-code:bg-gray-800 prose-code:rounded-lg prose-code:px-2 prose-code:text-blue-600 dark:prose-code:text-blue-400
                            leading-8">
                    {!! $page->description !!}
                </div>

            </div>
        </div>
    </section>
@endsection
