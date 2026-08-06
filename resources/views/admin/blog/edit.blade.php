@extends('admin.layout.master')

@section('content')
    <div class="profile-content">
        <div class="profile-section active">
            <h3 class="section-title mb-4">
                <i class="bi bi-pencil-square"></i> ویرایش بلاگ
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

            <form method="post" action="{{route('admin.blog.update', $blog->id)}}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label required">عنوان بلاگ</label>
                            <input type="text" class="form-control mt-2" name="title"
                                   value="{{old('title', $blog->title)}}" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label required">اسلاگ</label>
                            <input type="text" class="form-control mt-2" name="slug"
                                   value="{{old('slug', $blog->slug)}}" placeholder="آدرس بلاگ در سایت" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">عنوان متا صفحه (title)</label>
                            <input type="text" class="form-control mt-2" name="meta_title"
                                   value="{{old('meta_title', $blog->meta_title)}}" maxlength="400">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">توضیحات متا (meta description)</label>
                            <input type="text" class="form-control mt-2" name="meta_description"
                                   value="{{old('meta_description', $blog->meta_description)}}" maxlength="400">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label">کلمات کلیدی (keywords)</label>
                            <input type="text" class="form-control mt-2" id="keywords-input" name="keywords" value="{{old('keywords', $blog->keywords)}}" placeholder="کلمه را تایپ کنید و Enter بزنید">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">تصویر بلاگ</label>
                            <input type="file" class="form-control mt-2" name="image" accept="image/*">
                            <span style="font-size: small;color: grey">در صورت وارد نکردن، تصویر قبلی حفظ می‌شود.</span>
                            @if($blog->image)
                                <div class="mt-3">
                                    <img src="{{asset('blog/'.$blog->image)}}"
                                         alt="{{$blog->image_alt}}"
                                         class="img-thumbnail"
                                         style="max-width: 200px; max-height: 200px;">
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Alt تصویر</label>
                            <input type="text" class="form-control mt-2" name="image_alt"
                                   value="{{old('image_alt', $blog->image_alt)}}" maxlength="400">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Title تصویر</label>
                            <input type="text" class="form-control mt-2" name="image_title"
                                   value="{{old('image_title', $blog->image_title)}}" maxlength="400">
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group">
                            <label class="form-label mt-3 required">توضیحات بلاگ</label>
                            @include('partial.editor',['value'=>$blog->description ?? ''])
                        </div>
                    </div>
                </div>

                <div class="row text-center mt-4">
                    <div class="col-md-3 text-center mt-2">
                        <button type="submit" class="btn btn-primary waves-effect waves-light m-b-5"
                                style="text-align: center; display: flex; align-items: center; justify-content: center; width: 100%;">
                            بروزرسانی
                        </button>
                    </div>
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
@endpush
