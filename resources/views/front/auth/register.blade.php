@extends('front.layout.master')

@section('content')
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-6 col-lg-5">

                    @if($errors->any())
                        <div class="alert alert-danger shadow-sm rounded-4 mb-4" role="alert">
                            <div class="d-flex align-items-start gap-3">
                                <div class="flex-shrink-0">
                                    <div class="d-flex align-items-center justify-content-center rounded-circle bg-danger bg-opacity-25" style="width:40px;height:40px;">
                                        <svg class="text-danger" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="fw-bold text-danger mb-2">خطا در اطلاعات وارد شده</h6>
                                    <ul class="list-unstyled small mb-0">
                                        @foreach($errors->all() as $error)
                                            <li class="text-danger mb-1"><span class="me-1">•</span>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                    @endif

                    <div class="card shadow-lg border-0 rounded-4">
                        <div class="card-body p-4 p-sm-5">
                            <div class="text-center mb-4">
                                <h2 class="fw-bold h4">ثبت نام</h2>
                                <p class="text-muted small mt-2">اطلاعات خود را وارد کنید، کد تایید برایتان پیامک میشود</p>
                            </div>

                            <form action="{{ route('register') }}" method="POST">
                                @csrf

                                <div class="mb-3">
                                    <label class="form-label fw-bold small">نام و نام خانوادگی</label>
                                    <input type="text" name="name" value="{{ old('name') }}" placeholder="مثلاً علی محمدی"
                                           class="form-control form-control-lg rounded-3 @error('name') is-invalid @enderror" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold small">شماره موبایل</label>
                                    <input type="tel" name="mobile" value="{{ old('mobile') }}" placeholder="۰۹۱۲۰۰۰۰۰۰۰"
                                           class="form-control form-control-lg rounded-3 @error('mobile') is-invalid @enderror" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold small">رمز عبور</label>
                                    <div class="input-group">
                                        <input type="password" name="password" placeholder="••••••••"
                                               class="form-control form-control-lg rounded-start-3 @error('password') is-invalid @enderror" required>
                                        <button type="button" class="btn btn-outline-secondary rounded-end-3" onclick="togglePassword(this, 'password')">
                                            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-bold small">تکرار رمز عبور</label>
                                    <input type="password" name="password_confirmation" placeholder="••••••••"
                                           class="form-control form-control-lg rounded-3" required>
                                </div>

                                <button type="submit" class="btn btn-primary btn-lg w-100 rounded-3 fw-bold">
                                    دریافت کد تایید
                                </button>
                            </form>

                            <div class="text-center mt-4">
                                <span class="small text-muted">حساب کاربری دارید؟</span>
                                <a href="{{ route('login') }}" class="small fw-bold text-decoration-none">ورود</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        function togglePassword(btn, id) {
            const input = document.getElementById(id);
            const svg = btn.querySelector('svg');
            input.type = input.type === 'password' ? 'text' : 'password';
            svg.setAttribute('viewBox', input.type === 'password'
                ? 'M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z'
                : 'M3 6l18 18M7.5 8.121A9.953 9.953 0 0 1 12 6.5c4.478 0 8.268 2.943 9.543 7a9.97 9.97 0 0 1-1.414 2.52M9.878 9.878a3 3 0 1 0 4.243 4.243');
        }
    </script>
@endsection

