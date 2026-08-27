@extends('front.layout.master')
@section('content')
    <section class="py-5 mt-4">
        <div class="container">
            <div class="text-center mb-4">
                <h1 class="fw-bold text-primary">بلاگ بازرگانی بنازاده</h1>
                <p class="text-muted mt-2">آخرین مطالب و اخبار حوزه مواد غذایی</p>
            </div>

            <div class="row justify-content-center mb-5">
                <div class="col-12 col-md-6">
                    <form action="{{ route('blogs') }}" method="GET" class="d-flex gap-2">
                        <input type="text"
                               name="search"
                               value="{{ $search }}"
                               class="form-control rounded-pill px-4"
                               placeholder="جست‌وجو در عنوان مقالات...">
                        <button type="submit" class="btn btn-primary rounded-pill px-4">
                            <i class="bi bi-search"></i>
                        </button>
                        @if($search)
                            <a href="{{ route('blogs') }}" class="btn btn-outline-secondary rounded-pill px-3">
                                <i class="bi bi-x-lg"></i>
                            </a>
                        @endif
                    </form>
                </div>
            </div>

            <div class="row g-4">
                @forelse($blogs as $blog)
                    <div class="col-12 col-sm-6 col-lg-4">
                        <div class="card article-card h-100">
                            <a href="{{ route('blog.show', $blog->slug) }}" class="text-decoration-none text-reset">
                                <img src="{{ asset('blog/'.$blog->image) }}"
                                     class="card-img-top article-img"
                                     alt="{{ $blog->image_alt }}"
                                     title="{{ $blog->image_title }}"
                                     loading="lazy">
                                <div class="card-body d-flex flex-column">
                                    <div class="text-muted small mb-3">
                                        <i class="bi bi-calendar3 me-1"></i>
                                        {{ \Morilog\Jalali\Jalalian::fromDateTime($blog->created_at)->format('Y/m/d') }}
                                    </div>
                                    <h5 class="card-primary fw-bold mb-3">{{ $blog->title }}</h5>
                                    <span class="article-link mt-auto">
                                        مطالعه مطلب
                                        <i class="bi bi-arrow-left"></i>
                                    </span>
                                </div>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center text-muted py-5">
                        @if($search)
                            نتیجه‌ای برای «{{ $search }}» یافت نشد.
                        @else
                            هنوز مطلبی ثبت نشده است.
                        @endif
                    </div>
                @endforelse
            </div>

            @if($blogs->hasPages())
                <div class="d-flex justify-content-center mt-5">
                    {{ $blogs->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </section>
@endsection
