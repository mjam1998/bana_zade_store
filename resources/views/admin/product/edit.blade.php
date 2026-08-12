@extends('admin.layout.master')

@section('content')

    <div class="profile-content">
        <div class="profile-section active">
            <h3 class="section-title mb-4">
                <i class="bi bi-pencil-square"></i>ویرایش محصول
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
            @if(session()->has('success'))
                <p class="alert alert-success">{{session('success')}}</p>
            @endif
            <form method="post" action="{{route('admin.product.update', $product->id)}}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label required">نام محصول</label>
                            <input type="text" class="form-control mt-2" name="name" value="{{old('name', $product->name)}}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label required">انتخاب دسته بندی</label>
                            <select id="category_id" class="form-control" name="category_id">
                                <option value="">تایپ کنید...</option>
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}"
                                        {{old('category_id', $product->category_id) == $category->id ? 'selected' : ''}}>
                                        {{$category->name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label required">اسلاگ</label>
                            <input type="text" class="form-control mt-2" name="slug" value="{{old('slug', $product->slug)}}" placeholder="آدرس محصول در سایت" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label required"> واحد اندازه گیری فروش </label>
                            <input type="text" class="form-control mt-2" name="unit_name" value="{{old('unit_name', $product->unit_name)}}" placeholder="مثلا لیتر، کیسه 10 کیلویی، کارتن 6 عددی" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label required"> تعداد حداقل خرید</label>
                            <input type="number" class="form-control mt-2" name="min_shop_count" value="{{old('min_shop_count', $product->min_shop_count)}}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label required">موجودی</label>
                            <input type="number" class="form-control mt-2" name="count" value="{{old('count', $product->count)}}" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label required">قیمت پایه(تومان)</label>
                            <input type="number" class="form-control mt-2" name="base_price" value="{{old('base_price', $product->base_price)}}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">درصد تخفیف</label>
                            <input type="number" class="form-control mt-2" name="discount" placeholder="درصد تخفیف برای قیمت پایه" value="{{old('discount', $product->discount)}}" max="100">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">عنوان متا صفحه (title)</label>
                            <input type="text" class="form-control mt-2" name="meta_title" value="{{old('meta_title', $product->meta_title)}}" maxlength="300">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">توضیحات متا (meta description)</label>
                            <input type="text" class="form-control mt-2" name="meta_description" value="{{old('meta_description', $product->meta_description)}}" maxlength="300">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">نمایش محصول در بنر محصولات ویژه</label>
                            <select class="form-select mt-2" name="is_special">
                                <option value="0" {{old('is_special', $product->is_special) == 0 ? 'selected' : ''}}>خیر</option>
                                <option value="1" {{old('is_special', $product->is_special) == 1 ? 'selected' : ''}}>بلی</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label">کلمات کلیدی (keywords)</label>
                            <input type="text" class="form-control mt-2" id="keywords-input" name="keywords" value="{{old('keywords', $product->keywords)}}" placeholder="کلمه را تایپ کنید و Enter بزنید">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label"> تصویر محصول</label>
                            <input type="file" class="form-control mt-2" name="image" accept="image/*">
                            <span style="font-size: small;color: grey">در صورت وارد نکردن، تصویر قبلی حفظ می‌شود.</span>
                            @if($product->image)
                                <div class="mt-3">
                                    <img src="{{asset('product/'.$product->image)}}" alt="{{$product->image_alt}}" class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Alt تصویر</label>
                            <input type="text" class="form-control mt-2" name="image_alt" value="{{old('image_alt', $product->image_alt)}}" maxlength="400">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Title تصویر</label>
                            <input type="text" class="form-control mt-2" name="image_title" value="{{old('image_title', $product->image_title)}}" maxlength="400">
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group">
                            <label class="form-label mt-3">توضیحات محصول</label>
                            @include('partial.editor',['value'=>$product->description ?? ''])
                        </div>
                    </div>

                </div>

                <div class="col-12 mt-4">
                    <label class="control-label mb-2">پله‌های قیمتی بر اساس تعداد خرید (با افزایش تعداد خرید کاربر قیمت نسبت به قیمت پایه کاهش می‌یابد)</label>
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
                        <!-- ردیف‌ها با جاوااسکریپت پر می‌شن -->
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-outline-primary btn-sm" id="add-tier-row">
                        <i class="bi bi-plus"></i> افزودن پله قیمتی
                    </button>
                </div>

                <div class="row text-center mt-4">
                    <div class="col-md-3 text-center mt-2">
                        <button type="submit" class="btn btn-primary waves-effect waves-light m-b-5"
                                style="text-align: center; display: flex; align-items: center; justify-content: center; width: 100%;">
                            بروزرسانی
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
    @php
        $existingTiersForJs = $product->productPriceTiers->map(function ($t) {
            return [
                'min_qty' => $t->min_qty,
                'max_qty' => $t->max_qty,
                'unit_price' => $t->unit_price,
            ];
        });
    @endphp

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

        // پله‌های موجود از سرور (برای پر کردن اولیه جدول)
        const existingTiers = @json($existingTiersForJs);

        function addTierRow(tier = null) {
            const row = document.createElement('tr');
            const min = tier?.min_qty ?? '';
            const max = tier?.max_qty ?? '';
            const price = tier?.unit_price ?? '';

            row.innerHTML = `
            <td>
                <input type="number" min="1" class="form-control"
                       name="tiers[${tierIndex}][min_qty]" value="${min}" required>
            </td>
            <td>
                <input type="number" min="1" class="form-control"
                       name="tiers[${tierIndex}][max_qty]" value="${max}">
            </td>
            <td>
                <input type="number" min="0" class="form-control"
                       name="tiers[${tierIndex}][unit_price]" value="${price}" required>
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

        document.getElementById('add-tier-row').addEventListener('click', () => addTierRow());

        tbody.addEventListener('click', function (e) {
            if (e.target.closest('.remove-tier-row')) {
                e.target.closest('tr').remove();
            }
        });

        // پر کردن جدول با پله‌های موجود، در غیر این صورت یک ردیف خالی
        if (existingTiers.length > 0) {
            existingTiers.forEach(t => addTierRow(t));
        } else {
            addTierRow();
        }

        document.querySelector('form').addEventListener('submit', function (e) {
            const rows = tbody.querySelectorAll('tr');
            const tiers = [];

            for (const row of rows) {
                const min = row.querySelector('[name*="[min_qty]"]').value;
                const maxInput = row.querySelector('[name*="[max_qty]"]');
                const max = maxInput.value;

                if (!min) continue;

                tiers.push({
                    min: parseInt(min),
                    max: max ? parseInt(max) : null,
                });
            }

            tiers.sort((a, b) => a.min - b.min);

            for (let i = 0; i < tiers.length; i++) {
                const current = tiers[i];

                if (current.max !== null && current.max < current.min) {
                    alert(`خطا: در پله با شروع ${current.min}، مقدار "تا تعداد" نباید کمتر از "از تعداد" باشد.`);
                    e.preventDefault();
                    return;
                }

                if (current.max === null && i < tiers.length - 1) {
                    alert(`خطا: پله‌ای که "تا تعداد" آن خالی (بی‌نهایت) است باید آخرین پله باشد.`);
                    e.preventDefault();
                    return;
                }

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

