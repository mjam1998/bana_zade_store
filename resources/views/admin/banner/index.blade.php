@extends('admin.layout.master')

@section('content')
    <div class="profile-content">
        <div class="profile-section active">
            <h3 class="section-title mb-4">
                <i class="bi bi-play-btn"></i> مدیریت بنر ویدیویی صفحه اصلی
            </h3>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="row">
                <!-- فرم ایجاد/ویرایش -->
                <div class="col-md-5">
                    <div class="card">
                        <div class="card-header">
                            <h5 id="formTitle">افزودن / ویرایش اطلاعات</h5>
                        </div>
                        <div class="card-body">
                            <!-- مسیر route خود را جایگزین کنید -->
                            <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data" id="bannerForm">
                                @csrf
                                <input type="hidden" name="id" id="bannerId">

                                <div class="mb-3">
                                    <label class="form-label required">عنوان صفحه (Page Title)</label>
                                    <input type="text" name="page_title" id="pageTitle" class="form-control @error('page_title') is-invalid @enderror" value="{{ old('page_title') }}" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">توضیحات متا (Meta Description)</label>
                                    <textarea name="meta_description" id="metaDescription" class="form-control @error('meta_description') is-invalid @enderror" rows="3">{{ old('meta_description') }}</textarea>
                                </div>

                                <hr>
                                <h6>رسانه‌ها</h6>

                                <div class="mb-3" id="currentMediaDiv" style="display: none;">
                                    <label class="form-label text-info">کاور فعلی ویدیو</label>
                                    <div class="mb-2">
                                        <img id="currentImage" src="" alt="" style="width: 100%; height: 150px; object-fit: cover; border-radius: 4px;">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label required" id="imageLabel">تصویر کاور (پوستر - تبدیل به WebP می‌شود)</label>
                                    <input type="file" name="image" id="bannerImage" class="form-control" accept="image/*">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Alt تصویر</label>
                                    <input type="text" name="image_alt" id="imageAlt" class="form-control" value="{{ old('image_alt') }}">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">فایل ویدیویی MP4</label>
                                    <input type="file" name="video_mp4" id="videoMp4" class="form-control" accept="video/mp4">
                                    <small class="text-muted">فرمت استاندارد برای همه مرورگرها</small>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">فایل ویدیویی WebM</label>
                                    <input type="file" name="video_webm" id="videoWebm" class="form-control" accept="video/webm">
                                    <small class="text-muted">حجم کمتر و بهینه‌تر (اختیاری)</small>
                                </div>

                                <div class="d-flex gap-2 mt-4">
                                    <button type="submit" class="btn btn-primary">ذخیره تغییرات</button>
                                    <button type="button" class="btn btn-secondary" id="cancelBtn" style="display: none;" onclick="resetForm()">انصراف</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- نمایش بنر ویدیویی فعلی -->
                <div class="col-md-7">
                    <div class="card">
                        <div class="card-header">
                            <h5>بنر و متای فعلی صفحه اصلی</h5>
                        </div>
                        <div class="card-body">
                            @if(isset($banner) && $banner)
                                <div class="border rounded p-3 mb-3">
                                    <h6><strong>عنوان صفحه:</strong> {{ $banner->page_title }}</h6>
                                    <p class="text-muted mb-3"><small><strong>متا توضیحات:</strong> {{ $banner->meta_description }}</small></p>

                                    <div class="ratio ratio-16x9 mb-3 bg-dark rounded">
                                        <video controls preload="metadata" poster="{{ asset('banners/' . $banner->image) }}" class="rounded">
                                            @if($banner->video_mp4)
                                                <source src="{{ asset('banners/' . $banner->video_mp4) }}" type="video/mp4">
                                            @endif
                                            @if($banner->video_webm)
                                                <source src="{{ asset('banners/' . $banner->video_webm) }}" type="video/webm">
                                            @endif
                                            مرورگر شما از ویدیو پشتیبانی نمی‌کند.
                                        </video>
                                    </div>

                                    <div class="d-flex gap-2">
                                        <button type="button" class="btn btn-warning"
                                                onclick="editBanner({{ $banner->id }}, '{{ $banner->page_title }}', '{{ addslashes($banner->meta_description) }}', '{{asset('banners/'.$banner->image ) }}', '{{ $banner->image_alt }}')">
                                            ویرایش
                                        </button>

                                        <form action="{{ route('admin.banners.destroy', $banner->id) }}" method="POST" onsubmit="return confirm('آیا از حذف مطمئن هستید؟')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">حذف کامل</button>
                                        </form>
                                    </div>
                                </div>
                            @else
                                <div class="text-center text-muted p-5">
                                    <i class="bi bi-camera-video" style="font-size: 3rem;"></i>
                                    <p class="mt-3">هنوز بنر ویدیویی برای صفحه اصلی ثبت نشده است.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function editBanner(id, pageTitle, metaDescription, image, imageAlt) {
            document.getElementById('formTitle').textContent = 'ویرایش اطلاعات فعلی';
            document.getElementById('bannerId').value = id;
            document.getElementById('pageTitle').value = pageTitle || '';
            document.getElementById('metaDescription').value = metaDescription || '';
            document.getElementById('imageAlt').value = imageAlt || '';

            if(image) {
                document.getElementById('currentImage').src = image;
                document.getElementById('currentMediaDiv').style.display = 'block';
                document.getElementById('imageLabel').textContent = 'تصویر کاور جدید (اختیاری)';
            }

            document.getElementById('bannerImage').removeAttribute('required');
            document.getElementById('cancelBtn').style.display = 'inline-block';
            document.getElementById('bannerForm').scrollIntoView({ behavior: 'smooth' });
        }

        function resetForm() {
            document.getElementById('formTitle').textContent = 'افزودن اطلاعات جدید';
            document.getElementById('bannerForm').reset();
            document.getElementById('bannerId').value = '';
            document.getElementById('currentMediaDiv').style.display = 'none';
            document.getElementById('imageLabel').textContent = 'تصویر کاور (پوستر)';
            document.getElementById('bannerImage').setAttribute('required', 'required');
            document.getElementById('cancelBtn').style.display = 'none';
        }
    </script>
@endpush
