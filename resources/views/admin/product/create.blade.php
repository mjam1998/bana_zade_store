@extends('admin.layout.master')

@section('content')



    <div class="profile-content">
        <div class="profile-section active">
            <h3 class="section-title mb-4">
                <i class="bi bi-box-seam"></i>افزودن محصول
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
            <form method="post" action="{{route('admin.product.store')}}" enctype="multipart/form-data" >
                @csrf


                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label required">نام محصول</label>
                            <input type="text" class="form-control mt-2" name="name" value="{{old('name')}}" required>
                        </div>
                    </div>
                    <div class="col-md-6">

                        <div class="form-group">

                            <label class="control-label required">
                                انتخاب دسته بندی
                            </label>

                            <select id="category_id"
                                    class="form-control"
                                    name="category_id">

                                <option value="">تایپ کنید...</option>

                                @foreach($categories as $category)

                                    <option
                                        value="{{$category->id}}"

                                    >
                                        {{$category->name}}
                                    </option>

                                @endforeach

                            </select>


                        </div>

                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label required">اسلاگ </label>
                            <input type="text" class="form-control mt-2" name="slug" value="{{old('slug')}}" placeholder="آدرس  محصول در سایت" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label required"> واحد اندازه گیری فروش </label>
                            <input type="text" class="form-control mt-2" name="unit_name" value="{{old('unit_name')}}" placeholder="مثلا لیتر، کیسه 10 کیلویی،کارتن 6 عددی" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label required "> تعداد حداقل خرید</label>
                            <input type="number" class="form-control mt-2" name="min_shop_count" value="{{old('min_shop_count')}}" required >
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label required">موجودی</label>
                            <input type="number" class="form-control mt-2" name="count" value="{{old('count')}}" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label required">قیمت پایه(تومان)</label>
                            <input type="number" class="form-control mt-2" name="base_price" value="{{old('base_price')}}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label ">درصد تخفیف</label>
                            <input type="number" class="form-control mt-2" name="discount" placeholder="درصد تخفیف برای قیمت پایه" value="{{old('discount')}}" max="100">
                        </div>
                    </div>
                    <div class="col-md-6" >
                        <div class="form-group">
                            <label class="control-label">عنوان متا  صفحه (title)</label>
                            <input type="text" class="form-control mt-2" name="meta_title" value="{{old('meta_title')}}" maxlength="300">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">توضیحات متا  (meta description)</label>
                            <input type="text" class="form-control mt-2" name="meta_description" value="{{old('meta_description')}}" maxlength="300">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">نمایش محصول در بنر محصولات ویژه  </label>
                            <select class="form-select mt-2" name="is_special">
                                <option value="0" >خیر</option>
                                <option value="1" >بلی</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label">کلمات کلیدی (keywords)</label>
                            <input type="text" class="form-control mt-2" id="keywords-input" name="keywords" value="{{old('keywords')}}" placeholder="کلمه را تایپ کنید و Enter بزنید">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                             <label class="control-label "> تصویر محصول</label>
                             <input type="file" class="form-control mt-2" name="image" accept="image/*">
                            <span style="font-size: small;color: grey">در صورت وارد نکردن، عکس دسته بندی برای عکس محصول استفاده میشود.</span>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Alt تصویر</label>
                            <input type="text" class="form-control mt-2" name="image_alt" value="{{old('image_alt')}}" maxlength="400">
                        </div>
                     </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Title تصویر</label>
                            <input type="text" class="form-control mt-2" name="image_title" value="{{old('image_title')}}" maxlength="400">
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group">
                            <label class="form-label mt-3">توضیحات محصول</label>
                            @include('partial.editor',['value'=>''])
                        </div>
                     </div>

                </div>
                <div class="col-12 mt-4">
                    <label class="control-label mb-2">پله‌های قیمتی بر اساس تعداد خرید(با افزاش تعداد خرید کاربر قیمت نسبت به قیمت پایه کاهش میابد)</label>
                    <table class="table table-bordered" id="price-tiers-table">
                        <thead>
                        <tr>
                            <th>از تعداد</th>
                            <th>تا تعداد (خالی = بی‌نهایت)</th>
                            <th>قیمت واحد (تومان)</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <!-- ردیف‌ها اینجا اضافه می‌شن -->
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-outline-primary btn-sm" id="add-tier-row">
                        <i class="bi bi-plus"></i> افزودن پله قیمتی
                    </button>
                </div>

                <div class="row text-center mt-4">
                    <div class="col-md-3 text-center mt-2">
                        <button type="submit" class="btn btn-success waves-effect waves-light m-b-5"
                                style="text-align: center; display: flex; align-items: center; justify-content: center; width: 100%;">
                            افزودن
                        </button>
                    </div>
                    <div class="col-md-3 mt-2"></div>
                     <div class="col-md-3 mt-2"></div>
                </div>

            </form>
        </div>
    </div>




@endsection
@push('scripts')
    <script>
        var input = document.querySelector('#keywords-input');
        var tagify = new Tagify(input, {
            delimiters: ",",
            maxTags: 50,
            placeholder: "کلمه را تایپ کنید و Enter بزنید",
            dropdown: {
                enabled: 0
            }
        });

        // تبدیل tags به رشته با کاما قبل از ارسال فرم
        document.querySelector('form').addEventListener('submit', function() {
            var tags = tagify.value.map(tag => tag.value).join(',');
            input.value = tags;
        });
    </script>
    <script>

        document.addEventListener('DOMContentLoaded', function () {

            const element = document.getElementById('category_id');

            new Choices(element, {

                searchEnabled: true,
                removeItemButton: true,
                shouldSort: false,
                rtl: true,
                placeholderValue: 'جستجوی دسته بندی...',
                noResultsText: 'نتیجه‌ای یافت نشد',
                noChoicesText: 'دسته بندی وجود ندارد',
                itemSelectText: '',
            });

        });

    </script>
    <script>
        let tierIndex = 0;
        const tbody = document.querySelector('#price-tiers-table tbody');

        function addTierRow() {
            const row = document.createElement('tr');
            row.innerHTML = `
            <td>
                <input type="number" min="1" class="form-control"
                       name="tiers[${tierIndex}][min_qty]" required>
            </td>
            <td>
                <input type="number" min="1" class="form-control"
                       name="tiers[${tierIndex}][max_qty]">
            </td>
            <td>
                <input type="number" min="0" class="form-control"
                       name="tiers[${tierIndex}][unit_price]" required>
            </td>
            <td>
                <button type="button" class="btn btn-danger btn-sm remove-tier-row">
                    <i class="bi bi-trash"></i>
                </button>
            </td>
        `;
            tbody.appendChild(row);
            tierIndex++;
        }

        document.getElementById('add-tier-row').addEventListener('click', addTierRow);

        tbody.addEventListener('click', function (e) {
            if (e.target.closest('.remove-tier-row')) {
                e.target.closest('tr').remove();
            }
        });

        // یک ردیف پیش‌فرض
        addTierRow();

        document.querySelector('form').addEventListener('submit', function (e) {
            const rows = tbody.querySelectorAll('tr');
            const tiers = [];

            for (const row of rows) {
                const min = row.querySelector('[name*="[min_qty]"]').value;
                const maxInput = row.querySelector('[name*="[max_qty]"]');
                const max = maxInput.value;

                if (!min) continue; // ردیف خالی

                tiers.push({
                    min: parseInt(min),
                    max: max ? parseInt(max) : null, // null یعنی بی‌نهایت
                });
            }

            // مرتب‌سازی بر اساس min برای بررسی راحت‌تر
            tiers.sort((a, b) => a.min - b.min);

            for (let i = 0; i < tiers.length; i++) {
                const current = tiers[i];

                // ۱) چک min <= max (اگر max خالی نبود)
                if (current.max !== null && current.max < current.min) {
                    alert(`خطا: در پله با شروع ${current.min}، مقدار "تا تعداد" نباید کمتر از "از تعداد" باشد.`);
                    e.preventDefault();
                    return;
                }

                // ۲) اگر این ردیف بی‌نهایت است (max === null) نباید ردیف بعدی وجود داشته باشد
                if (current.max === null && i < tiers.length - 1) {
                    alert(`خطا: پله‌ای که "تا تعداد" آن خالی (بی‌نهایت) است باید آخرین پله باشد.`);
                    e.preventDefault();
                    return;
                }

                // ۳) چک همپوشانی با پله بعدی
                const next = tiers[i + 1];
                if (next && current.max !== null && current.max >= next.min) {
                    alert(`خطا: بازه ${current.min} تا ${current.max} با بازه بعدی (شروع از ${next.min}) هم‌پوشانی دارد.`);
                    e.preventDefault();
                    return;
                }
            }
        });

    </script>

@endpush

