@extends('front.layout.master')

@section('content')
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-6 col-lg-5">

                    @if(session('status'))
                        <div class="alert alert-success shadow-sm rounded-4 mb-4">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="card shadow-lg border-0 rounded-4">
                        <div class="card-body p-4 p-sm-5">
                            <div class="text-center mb-4">
                                <h2 class="fw-bold h4">فراموشی رمز عبور</h2>
                                <p class="text-muted small mt-2">شماره موبایل خود را وارد کنید تا کد بازیابی برایتان ارسال شود</p>
                            </div>

                            <form action="{{ route('password.forgot') }}" method="POST">
                                @csrf

                                <div class="mb-4">
                                    <label class="form-label fw-bold small">شماره موبایل</label>
                                    <input type="tel" name="mobile" value="{{ old('mobile') }}" placeholder="۰۹۱۲۰۰۰۰۰۰۰"
                                           class="form-control form-control-lg rounded-3 @error('mobile') is-invalid @enderror" required>
                                    @error('mobile')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary btn-lg w-100 rounded-3 fw-bold">
                                    ارسال کد بازیابی
                                </button>
                            </form>

                            <div class="text-center mt-4">
                                <a href="{{ route('login') }}" class="small fw-bold text-decoration-none">بازگشت به ورود</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
