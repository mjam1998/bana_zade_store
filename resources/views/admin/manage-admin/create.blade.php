@extends('admin.layout.master')


@section('content')

    <div class="profile-content">
        <div class="profile-section active">
            <h3 class="section-title mb-4">
                <i class="bi bi-people"></i>افزودن کاربر
            </h3>

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show">
                    <strong>خطا در اطلاعات وارد شده:</strong>
                    <ul class="mt-2 mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @php
                // آرایه ترجمه نقش‌ها
                $roleTranslations = [
                       'super-admin' => 'سوپر ادمین‌',
                    'user' => ' کاربر عادی',

                    'manage-category' => 'مدیریت دسته‌بندی‌ها',
                    'manage-product' => 'مدیریت محصولات',
                    'manage-order' => 'مدیریت سفارشات',
                    'manage-blog' => 'مدیریت بلاگ',
                    'manage-banner' => 'مدیریت بنرها',
                    'manage-extra-page' => 'مدیریت صفحات جانبی',
                    'manage-payment-gateway' => 'مدیریت درگاه پرداخت',
                ];
            @endphp

            <form method="post" action="{{route('admin.store')}}" enctype="multipart/form-data" >
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label required" >نام </label>
                            <input type="text" class="form-control mt-2" name="name" value="{{ old('name') }}" required >
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label required" >موبایل </label>
                            <input type="number" class="form-control mt-2" name="mobile" value="{{ old('mobile') }}" required placeholder="09--------" >
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label required" >رمز عبور </label>
                            <input type="text" class="form-control mt-2" name="password" required >
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label required" >تکرار رمز عبور </label>
                            <input type="text" class="form-control mt-2" name="repassword" required >
                        </div>
                    </div>


                    {{-- فیلد انتخاب نقش‌ها با Choices.js --}}
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label required">نقش‌های دسترسی</label>
                            <select name="roles[]" id="roles-select" class="form-control mt-2" multiple>
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}" {{ (is_array(old('roles')) && in_array($role->name, old('roles'))) ? 'selected' : '' }}>
                                        {{ $roleTranslations[$role->name] ?? $role->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row text-center mt-3">
                    <div class="col-md-3 text-center mt-2">
                        <button type="submit" class="btn btn-success waves-effect waves-light m-b-5"
                                style="text-align: center; display: flex; align-items: center; justify-content: center; width: 100%;">
                            افزودن
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
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
