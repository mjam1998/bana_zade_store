@extends('front.layout.master')

@section('content')
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-6 col-lg-5">

                    @if($errors->any())
                        <div class="alert alert-danger shadow-sm rounded-4 mb-4">
                            <ul class="list-unstyled small mb-0">
                                @foreach($errors->all() as $error)
                                    <li class="text-danger mb-1"><span class="me-1">•</span>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="card shadow-lg border-0 rounded-4">
                        <div class="card-body p-4 p-sm-5">
                            <div class="text-center mb-4">
                                <div class="mx-auto mb-3 d-flex align-items-center justify-content-center rounded-circle bg-info bg-opacity-10"
                                     style="width:70px;height:70px;">
                                    <svg width="32" height="32" fill="none" stroke="#0dcaf0" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h13a2 2 0 012 2v10a2 2 0 01-2 2H9l-4 4V5z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 9h8M8 13h5"/>
                                    </svg>
                                </div>
                                <h2 class="fw-bold h4">کد تایید</h2>
                                <p class="text-muted small mt-2">کد ۵ رقمی ارسال شده به موبایل {{ session('register_data.mobile') }} را وارد کنید</p>
                            </div>

                            <form action="{{ route('register.verify') }}" method="POST">
                                @csrf

                                <div class="mb-4">
                                    <label class="form-label fw-bold small">کد تایید</label>
                                    <input type="text" name="code" inputmode="numeric" maxlength="5" placeholder="•••••"
                                           class="form-control form-control-lg text-center rounded-3 letter-spacing" required>
                                </div>

                                <button type="submit" class="btn btn-success btn-lg w-100 rounded-3 fw-bold">
                                    تایید و تکمیل ثبت نام
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .letter-spacing { letter-spacing: 0.5rem; }
    </style>
@endsection
