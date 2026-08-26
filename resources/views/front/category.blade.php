@extends('front.layout.master')

@section('content')
    <section class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold text-primary">همه دسته‌بندی‌ها</h2>
            </div>

            <div class="row g-4">
                @forelse($categories as $category)
                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="card category-card text-center h-100 shadow-sm">
                            <div class="card-body py-4">
                                <img src="{{ asset('category/'.$category->image) }}"
                                     alt="{{ $category->image_alt }}"
                                     title="{{ $category->image_title }}"
                                     class="category-img mb-3 mx-auto d-block"
                                     style="width: 90px; height: 90px; object-fit: contain;">
                                <h6 class="mb-0 fw-bold">{{ $category->name }}</h6>
                            </div>
                        </div>
                    </div>

                @empty

                    <div class="col-12 text-center text-muted">
                        دسته‌بندی‌ای برای نمایش وجود ندارد.
                    </div>
                @endforelse
            </div>
        </div>
    </section>
@endsection
