@extends('admin.layout.master')

@section('content')
    <div class="profile-content">
        <div class="profile-section active">
            <h3 class="section-title mb-4">
                <i class="bi bi-image"></i> مدیریت بنرها
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
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 id="formTitle">افزودن بنر جدید</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data" id="bannerForm">
                            @csrf
                            <input type="hidden" name="id" id="bannerId">

                            <div class="mb-3">
                                <label class="form-label required">نوع بنر </label>
                                <select name="type" id="bannerType" class="form-control @error('type') is-invalid @enderror" required>
                                    <option value="">انتخاب کنید</option>
                                    <option value="1" {{ old('type') == 1 ? 'selected' : '' }}>اسلایدر (حداکثر 5)</option>
                                    <option value="2" {{ old('type') == 2 ? 'selected' : '' }}>بنر تخفیف</option>
                                    <option value="3" {{ old('type') == 3 ? 'selected' : '' }}>بنر یک</option>
                                    <option value="4" {{ old('type') == 4 ? 'selected' : '' }}>بنر دو</option>
                                    <option value="5" {{ old('type') == 5 ? 'selected' : '' }}>بنر سه</option>
                                    <option value="6" {{ old('type') == 6 ? 'selected' : '' }}>بنر چهار</option>
                                </select>
                                @error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-3" id="currentImageDiv" style="display: none;">
                                <label class="form-label">تصویر فعلی</label>
                                <div>
                                    <img id="currentImage" src="" alt="" style="max-width: 100%; height: auto; border-radius: 4px;">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label required" id="imageLabel">تصویر </label>
                                <input type="file" name="image" id="bannerImage" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                                @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Alt تصویر</label>
                                <input type="text" name="image_alt" id="imageAlt" class="form-control @error('image_alt') is-invalid @enderror" value="{{ old('image_alt') }}">
                                @error('image_alt')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Title تصویر</label>
                                <input type="text" name="image_title" id="imageTitle" class="form-control @error('image_title') is-invalid @enderror" value="{{ old('image_title') }}">
                                @error('image_title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">لینک</label>
                                <input type="url" name="url" id="bannerUrl" class="form-control @error('url') is-invalid @enderror" value="{{ old('url') }}" placeholder="https://example.com">
                                @error('url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">عنوان متا <small class="text-muted">(فقط برای صفحه اصلی)</small></label>
                                <input type="text" name="meta_title" id="metaTitle" class="form-control @error('meta_title') is-invalid @enderror" value="{{ old('meta_title') }}">
                                @error('meta_title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">توضیحات متا <small class="text-muted">(فقط برای صفحه اصلی)</small></label>
                                <textarea name="meta_description" id="metaDescription" class="form-control @error('meta_description') is-invalid @enderror" rows="3">{{ old('meta_description') }}</textarea>
                                @error('meta_description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">ذخیره</button>
                                <button type="button" class="btn btn-secondary" id="cancelBtn" style="display: none;" onclick="resetForm()">انصراف</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- لیست بنرها -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5>بنرهای موجود</h5>
                    </div>
                    <div class="card-body">
                        @php
                            $typeNames = [
                                1 => 'اسلایدرها',
                                2 => 'بنر تخفیف',
                                3 => 'بنر یک',
                                4 => 'بنر دو',
                                5 => 'بنر سه',
                                6 => 'بنر چهار',
                            ];
                        @endphp

                        @forelse($banners as $type => $typeBanners)
                            <div class="mb-4">
                                <h6 class="text-primary mb-3">{{ $typeNames[$type] ?? 'نامشخص' }}</h6>
                                <div class="row g-3">
                                    @foreach($typeBanners as $banner)
                                        <div class="col-md-6">
                                            <div class="card border">
                                                <img src="{{ asset('banners/' . $banner->image) }}" class="card-img-top" alt="{{ $banner->image_alt }}" style="height: 200px; object-fit: cover;">
                                                <div class="card-body">
                                                    @if($banner->url)
                                                        <p class="mb-2"><strong>لینک:</strong> <a href="{{ $banner->url }}" target="_blank" class="text-truncate d-inline-block" style="max-width: 200px;">{{ $banner->url }}</a></p>
                                                    @endif
                                                    @if($banner->meta_title)
                                                        <p class="mb-2"><strong>عنوان متا:</strong> {{ $banner->meta_title }}</p>
                                                    @endif
                                                    <div class="d-flex gap-2 mt-3">
                                                        <button type="button" class="btn btn-sm btn-warning" onclick="editBanner({{ $banner->id }}, {{ $banner->type->value }}, '{{ $banner->image }}', '{{ $banner->image_alt }}', '{{ $banner->image_title }}', '{{ $banner->url }}', '{{ $banner->meta_title }}', '{{ addslashes($banner->meta_description) }}')">ویرایش</button>
                                                        <form action="{{ route('admin.banners.destroy', $banner) }}" method="POST" class="d-inline" onsubmit="return confirm('آیا مطمئن هستید؟')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger">حذف</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @empty
                            <p class="text-center text-muted">هیچ بنری یافت نشد</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>

@endsection
@push('scripts')
    <script>
        function editBanner(id, type, image, imageAlt, imageTitle, url, metaTitle, metaDescription) {
            document.getElementById('formTitle').textContent = 'ویرایش بنر';
            document.getElementById('bannerId').value = id;
            document.getElementById('bannerType').value = type;
            document.getElementById('imageAlt').value = imageAlt || '';
            document.getElementById('imageTitle').value = imageTitle || '';
            document.getElementById('bannerUrl').value = url || '';
            document.getElementById('metaTitle').value = metaTitle || '';
            document.getElementById('metaDescription').value = metaDescription || '';

            document.getElementById('currentImage').src = '/banners/' + image;
            document.getElementById('currentImageDiv').style.display = 'block';
            document.getElementById('imageLabel').textContent = 'تصویر جدید (اختیاری)';
            document.getElementById('bannerImage').removeAttribute('required');
            document.getElementById('cancelBtn').style.display = 'inline-block';

            document.getElementById('bannerForm').scrollIntoView({ behavior: 'smooth' });
        }

        function resetForm() {
            document.getElementById('formTitle').textContent = 'افزودن بنر جدید';
            document.getElementById('bannerForm').reset();
            document.getElementById('bannerId').value = '';
            document.getElementById('currentImageDiv').style.display = 'none';
            document.getElementById('imageLabel').textContent = 'تصویر ';
            document.getElementById('bannerImage').setAttribute('required', 'required');
            document.getElementById('cancelBtn').style.display = 'none';
        }
    </script>
@endpush
