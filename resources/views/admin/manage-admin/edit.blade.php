@extends('admin.layout.master')

@section('content')

    <div class="profile-content">
        <div class="profile-section active">

            <h3 class="section-title mb-4">
                <i class="bi bi-people"></i>
                ویرایش کاربر
            </h3>

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show">
                    <strong>خطا در اطلاعات وارد شده:</strong>

                    <ul class="mt-2 mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="alert">
                    </button>
                </div>
            @endif

            @php
                $roleTranslations = [
                    'super-admin' => 'سوپر ادمین',
                    'user' => 'کاربر عادی',

                    'manage-category' => 'مدیریت دسته‌بندی‌ها',
                    'manage-product' => 'مدیریت محصولات',
                    'manage-order' => 'مدیریت سفارشات',
                    'manage-blog' => 'مدیریت بلاگ',
                    'manage-banner' => 'مدیریت بنرها',
                    'manage-extra-page' => 'مدیریت صفحات جانبی',
                    'manage-payment-gateway' => 'مدیریت درگاه پرداخت',
                ];
            @endphp

            <form method="POST"
                  action="{{ route('admin.update', $user->id) }}">

                @csrf
                @method('PUT')

                <div class="row g-3">

                    {{-- نام --}}
                    <div class="col-md-6">
                        <div class="form-group">

                            <label class="control-label required">
                                نام
                            </label>

                            <input type="text"
                                   class="form-control mt-2 @error('name') is-invalid @enderror"
                                   name="name"
                                   value="{{ old('name', $user->name) }}"
                                   required>

                        </div>
                    </div>


                    {{-- موبایل --}}
                    <div class="col-md-6">
                        <div class="form-group">

                            <label class="control-label required">
                                موبایل
                            </label>

                            <input type="text"
                                   class="form-control mt-2 @error('mobile') is-invalid @enderror"
                                   name="mobile"
                                   value="{{ old('mobile', $user->mobile) }}"
                                   placeholder="09123456789"
                                   required>

                        </div>
                    </div>


                    {{-- رمز عبور --}}
                    <div class="col-md-6">
                        <div class="form-group">

                            <label class="control-label">
                                رمز عبور جدید
                            </label>

                            <input type="password"
                                   class="form-control mt-2 @error('password') is-invalid @enderror"
                                   name="password"
                                   placeholder="در صورت عدم تغییر خالی بگذارید">

                        </div>
                    </div>


                    {{-- تکرار رمز --}}
                    <div class="col-md-6">
                        <div class="form-group">

                            <label class="control-label">
                                تکرار رمز عبور جدید
                            </label>

                            <input type="password"
                                   class="form-control mt-2"
                                   name="repassword"
                                   placeholder="در صورت عدم تغییر خالی بگذارید">

                        </div>
                    </div>


                    {{-- نقش‌ها --}}
                    <div class="col-md-6">

                        <div class="form-group">

                            <label class="control-label required">
                                نقش‌های دسترسی
                            </label>

                            <select name="roles[]"
                                    id="roles-select"
                                    class="form-control mt-2"
                                    multiple
                                    required>

                                @foreach($roles as $role)

                                    <option value="{{ $role->name }}"
                                        {{ in_array($role->name, old('roles', $userRoles)) ? 'selected' : '' }}>

                                        {{ $roleTranslations[$role->name] ?? $role->name }}

                                    </option>

                                @endforeach

                            </select>

                        </div>

                    </div>

                </div>


                <div class="row text-center mt-3">

                    <div class="col-md-3 text-center mt-2">

                        <button type="submit"
                                class="btn btn-success waves-effect waves-light m-b-5"
                                style="text-align: center;
                                       display: flex;
                                       align-items: center;
                                       justify-content: center;
                                       width: 100%;">

                            ذخیره تغییرات

                        </button>

                    </div>

                    <div class="col-md-3 text-center mt-2">

                        <a href="{{ route('admin.list') }}"
                           class="btn btn-secondary"
                           style="width: 100%;">

                            انصراف

                        </a>

                    </div>

                </div>

            </form>

        </div>
    </div>

@endsection


@push('scripts')

    <script>

        document.addEventListener('DOMContentLoaded', function () {

            const element = document.getElementById('roles-select');

            const choices = new Choices(element, {

                removeItemButton: true,

                searchEnabled: true,

                searchPlaceholderValue: 'جستجوی نقش...',

                placeholderValue: 'نقش‌های مورد نظر را انتخاب کنید',

                noResultsText: 'نتیجه‌ای یافت نشد',

                itemSelectText: 'برای انتخاب کلیک کنید',

            });

        });

    </script>

@endpush
