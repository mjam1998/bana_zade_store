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
                                <h2 class="fw-bold h4">کد بازیابی رمز</h2>
                                <p class="text-muted small mt-2">کد ۵ رقمی ارسالشده به {{ session('reset_data.mobile') }} را وارد کنید</p>
                            </div>

                            <form action="{{ route('password.forgot.verify') }}" method="POST">
                                @csrf

                                <div class="mb-4">
                                    <label class="form-label fw-bold small">کد تایید</label>
                                    <input type="text" name="code" inputmode="numeric" maxlength="5" placeholder="•••••"
                                           class="form-control form-control-lg text-center rounded-3" required>
                                </div>

                                <button type="submit" class="btn btn-success btn-lg w-100 rounded-3 fw-bold">
                                    تایید کد
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
