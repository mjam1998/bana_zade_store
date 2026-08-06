@extends('admin.layout.master')

@section('content')

    <div class="profile-content">
        <div class="profile-section active">
            <h3 class="section-title mb-4">
                <i class="bi bi-file-earmark-excel"></i> ایجاد محصولات با زیرمحصول از طریق اکسل
            </h3>

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    <strong>خطا!</strong>
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    {{session('success')}}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    {{session('error')}}
                </div>
            @endif

            <div class="row">
                <div class="col-12">
                    <div class="">
                        <div class="card-body">
                            <h5 class="card-title mb-3">راهنمای استفاده</h5>
                            <div class="alert alert-info">
                                <p class="mb-2"><strong>این صفحه برای محصولاتی است که چند مدل با قیمت‌های مختلف دارند</strong></p>
                                <p class="mb-2"><strong>فرمت فایل اکسل:</strong></p>
                                <ul class="mb-2">
                                    <li><strong>ستون‌های محصول اصلی:</strong> <code>code, name, category_id, description, meta_title, meta_description, keywords, image, image_alt, image_title</code></li>
                                    <li><strong>ستون‌های زیرمحصول (الزامی):</strong> <code>sub_product_name, sub_product_price, sub_product_discount</code></li>
                                    <li>برای هر محصول، <strong>اولین ردیف</strong> باید تمام اطلاعات محصول اصلی + اولین زیرمحصول را داشته باشد</li>
                                    <li>ردیف‌های بعدی با <strong>همان code</strong> فقط ستون‌های زیرمحصول را پر کنید (بقیه خالی بماند)</li>
                                    <li>فیلد <code>category_slug</code> باید شناسه اسلاگ دسته‌بندی باشد</li>
                                    <li>کلمات کلیدی را با کاما (,) جدا کنید</li>
                                    <li>عکس باید قبلاً آپلود شده باشد</li>
                                    <li>قیمت اصلی محصول صفر می‌شود و قیمت‌ها از زیرمحصولات گرفته می‌شود</li>
                                </ul>

                                <div class="alert alert-warning mt-3">
                                    <strong>مثال ساختار فایل:</strong>
                                    <pre class="mb-0" style="font-size: 12px;">
code     | name          | category_slug | sub_product_name | sub_product_price | sub_product_discount
---------|---------------|-------------|------------------|-------------------|---------------------
PROD001  | محصول اول     | 1           | مدل A            | 100000            | 10
PROD001  |               |             | مدل B            | 150000            | 15
PROD001  |               |             | مدل C            | 200000            | 0
PROD002  | محصول دوم     | 2           | مدل X            | 300000            | 20
PROD002  |               |             | مدل Y            | 350000            | 5
                                </pre>
                                </div>

                                <a href="{{route('products.download-sub-product-template')}}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-download"></i> دانلود فایل نمونه
                                </a>
                            </div>

                            <form method="post" action="{{route('products.import-sub-products')}}" enctype="multipart/form-data">
                                @csrf

                                <div class="mb-3">
                                    <label for="file" class="form-label">فایل اکسل <span class="text-danger">*</span></label>
                                    <input type="file" class="form-control" id="file" name="file" accept=".xlsx,.xls,.csv" required>
                                    <small class="text-muted">فرمت‌های مجاز: xlsx, xls, csv - حداکثر حجم: 10 مگابایت</small>
                                </div>

                                <div class="mb-3">
                                    <div class="alert alert-light border">
                                        <h6 class="mb-2"><i class="bi bi-info-circle"></i> نکات مهم:</h6>
                                        <ul class="mb-0 small">
                                            <li>اگر <code>code</code> محصول از قبل وجود داشته باشد، اطلاعات آن <strong>به‌روزرسانی</strong> می‌شود</li>
                                            <li>اگر زیرمحصولی با همان نام وجود داشته باشد، قیمت و تخفیف آن <strong>به‌روزرسانی</strong> می‌شود</li>
                                            <li>محصولات ایجاد شده به صورت خودکار <code>has_sub_product = true</code> تنظیم می‌شوند</li>
                                            <li>در صورت بروز خطا در هر ردیف، آن ردیف رد می‌شود و عملیات ادامه می‌یابد</li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-success waves-effect waves-light">
                                        <i class="bi bi-upload"></i> آپلود و ایجاد محصولات با زیرمحصول
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

