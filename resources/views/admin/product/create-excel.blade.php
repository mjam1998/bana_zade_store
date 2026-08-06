@extends('admin.layout.master')

@section('content')

        <div class="profile-content">
            <div class="profile-section active">
                <h3 class="section-title mb-4">
                    <i class="bi bi-file-earmark-excel"></i> ایجاد محصولات ثابت از طریق اکسل
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

        <div class="row">
            <div class="col-12">
                <div class="">
                    <div class="card-body">
                        <h5 class="card-title mb-3">راهنمای استفاده</h5>
                        <div class="alert alert-info">
                            <p class="mb-2"><strong>فرمت فایل اکسل:</strong></p>
                            <ul class="mb-2">
                                <li>ستون‌های مورد نیاز: <code>name, slug, code, price, category_slug, keywords</code></li>
                                <li>ستون‌های اختیاری: <code>size, count, discount, meta_title, meta_description,image, image_alt, image_title,description</code></li>
                                <li>کلمات کلیدی را با کاما (,) جدا کنید</li>
                                <li>اسلاگ دسته‌بندی باید از قبل در سیستم موجود باشد</li>
                                <li>عکس باید قبلا اپلود شده باشد، اسم عکس با پسوند نوشته شود</li>
                                <li>اگر <code>code</code> محصول از قبل وجود داشته باشد، اطلاعات آن <strong>به‌روزرسانی</strong> می‌شود</li>
                            </ul>
                            <a href="{{route('admin.product.excel.template')}}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-download"></i> دانلود فایل نمونه
                            </a>
                        </div>

                        <form method="post" action="{{route('admin.product.excel.import')}}" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label for="excel_file" class="form-label">فایل اکسل <span class="text-danger">*</span></label>
                                <input type="file" class="form-control" id="excel_file" name="excel_file" accept=".xlsx,.xls,.csv" required>
                                <small class="text-muted">فرمت‌های مجاز: xlsx, xls, csv</small>
                            </div>

                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="skip_errors" name="skip_errors" value="1">
                                    <label class="form-check-label" for="skip_errors">
                                        رد شدن از ردیف‌های دارای خطا و ادامه عملیات
                                    </label>
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-success waves-effect waves-light">
                                    <i class="bi bi-upload"></i> آپلود و ایجاد محصولات
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

