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
                            <label class="control-label required">کد فنی محصول </label>
                            <input type="text" class="form-control mt-2" name="code" value="{{old('code')}}" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label ">سایز</label>
                            <input type="text" class="form-control mt-2" name="size" value="{{old('size')}}" >
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label ">موجودی</label>
                            <input type="number" class="form-control mt-2" name="count" value="{{old('count')}}" >
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label ">میزان تخفیف</label>
                            <input type="number" class="form-control mt-2" name="discount" value="{{old('discount')}}" >
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label required">قیمت(تومان)</label>
                            <input type="number" class="form-control mt-2" name="price" value="{{old('price')}}" required>
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
@endpush

