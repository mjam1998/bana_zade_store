@extends('front.layout.master')

@section('content')
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 70vh;">
        <div class="col-12 col-sm-8 col-md-5">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4 text-center">
                    <h5 class="mb-1 fw-semibold">خوش آمدید، {{ auth()->user()->name }}</h5>
                    <p class="text-muted small mb-4">کدام بخش را می‌خواهید وارد شوید؟</p>

                    <div class="d-grid gap-3">
                        <a href="{{ route('admin.index') }}" class="btn btn-dark btn-lg">
                            پنل مدیریت
                        </a>
                        <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-lg">
                            ناحیه کاربری
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
