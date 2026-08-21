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
                                    <div class="d-flex align-items-center justify-content-center rounded-circle bg-danger bg-opacity-25"
                                         style="width:40px;height:40px;">
                                        <svg class="text-danger" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                </div>

                                <div class="flex-grow-1">
                                    <h6 class="fw-bold text-danger mb-2">خطا در اطلاعات وارد شده</h6>
                                    <ul class="list-unstyled small mb-0">
                                        @foreach($errors->all() as $error)
                                            <li class="text-danger mb-1">
                                                <span class="me-1">•</span>{{ $error }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>

                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                    @endif
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                    <div class="card shadow-lg border-0 rounded-4">
                        <div class="card-body p-4 p-sm-5">

                            <div class="text-center mb-4">
                                <h2 class="fw-bold h4">ورود به حساب کاربری</h2>
                                <p class="text-muted small mt-2">خوش آمدید، لطفا اطلاعات خود را وارد کنید</p>
                            </div>

                            <form action="{{ route('login.submit') }}" method="POST">
                                @csrf

                                <!-- Phone Number -->
                                <div class="mb-3">
                                    <label class="form-label fw-bold small">شماره موبایل</label>
                                    <input type="tel" name="mobile" placeholder="۰۹۱۲۰۰۰۰۰۰۰"
                                           class="form-control form-control-lg rounded-3" required>
                                </div>

                                <!-- Password -->
                                <div class="mb-2">
                                    <label class="form-label fw-bold small">رمز عبور</label>
                                    <div class="input-group">
                                        <input type="password" id="password" name="password" placeholder="••••••••"
                                               class="form-control form-control-lg rounded-start-3" required>
                                        <button type="button" class="btn btn-outline-secondary rounded-end-3" onclick="togglePassword()">
                                            <svg id="eye-icon" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            <svg id="eye-slash-icon" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="d-none">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <!-- Forgot Password -->
                                <div class="text-end mb-4">
                                    <a href="{{route('password.forgot')}}" class="small text-decoration-none">
                                        رمز عبور خود را فراموش کرده‌اید؟
                                    </a>
                                </div>

                                <button type="submit" class="btn btn-primary btn-lg w-100 rounded-3 fw-bold">
                                    ورود به سایت
                                </button>
                            </form>

                            <!-- Register Link -->
                            <div class="text-center mt-4">
                                <span class="small text-muted">حساب کاربری ندارید؟</span>
                                <a href="{{route('register')}}" class="small fw-bold text-decoration-none">
                                    ثبت‌نام کنید
                                </a>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            const eyeSlashIcon = document.getElementById('eye-slash-icon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.add('d-none');
                eyeSlashIcon.classList.remove('d-none');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('d-none');
                eyeSlashIcon.classList.add('d-none');
            }
        }
    </script>
@endsection
