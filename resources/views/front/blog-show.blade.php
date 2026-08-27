@extends('front.layout.master')

@section('content')
    <style>
        .blog-description img {
            max-width: 100% !important;
            height: auto !important;
            display: block;
            margin: 1.5rem auto;
            border-radius: 12px;
        }
        .blog-description table {
            max-width: 100%;
            display: block;
            overflow-x: auto;
            white-space: nowrap;
        }
        .blog-description iframe,
        .blog-description video {
            max-width: 100%;
        }
        .blog-description {
            line-height: 2;
            font-size: 1.05rem;
        }
    </style>

    <section class="py-5 mt-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <nav class="text-muted small mb-3">
                        <a href="{{ route('blogs') }}" class="text-decoration-none">بلاگ</a>
                        <i class="bi bi-chevron-left mx-1"></i>
                        {{ $blog->title }}
                    </nav>

                    <h1 class="fw-bold mb-3">{{ $blog->title }}</h1>

                    <div class="text-muted small mb-4">
                        <i class="bi bi-calendar3 me-1"></i>
                        {{ \Morilog\Jalali\Jalalian::fromDateTime($blog->created_at)->format('Y/m/d') }}
                    </div>

                    <img src="{{ asset('blog/'.$blog->image) }}"
                         alt="{{ $blog->image_alt }}"
                         title="{{ $blog->image_title }}"
                         class="w-100 rounded-4 shadow-sm mb-4"
                         style="max-height: 450px; object-fit: cover;">

                    <div class="blog-description">
                        {!! $blog->description !!}
                    </div>

                    @if(!empty($blog->keywords_array))
                        <div class="mt-2">
                            @foreach($blog->keywords_array as $keyword)
                                <span class="badge bg-secondary-subtle text-dark border me-1">{{ $keyword }}</span>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            @if($relatedBlogs->isNotEmpty())
                <div class="mt-5">
                    <h4 class="fw-bold mb-4 text-primary">مطالب مرتبط</h4>
                    <div class="row g-4">
                        @foreach($relatedBlogs as $related)
                            <div class="col-12 col-sm-6 col-lg-4">
                                <div class="card article-card h-100">
                                    <a href="{{ route('blog.show', $related->slug) }}" class="text-decoration-none text-reset">
                                        <img src="{{ asset('blog/'.$related->image) }}"
                                             class="card-img-top article-img"
                                             alt="{{ $related->image_alt }}"
                                             title="{{ $related->image_title }}"
                                             loading="lazy">
                                        <div class="card-body">
                                            <h6 class="card-primary fw-bold mb-0">{{ $related->title }}</h6>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection
