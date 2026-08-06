@extends('admin.layout.master')

@section('content')
    <div class="profile-content">
        <div class="profile-section active">
            <h3 class="section-title mb-4">
                <i class="bi bi-images"></i> آپلود دسته‌جمعی تصاویر محصولات
            </h3>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="alert alert-info">
                <i class="bi bi-info-circle"></i>
                نام هر فایل باید <strong>کد فنی محصول</strong> باشد. مثلاً: <code>ABC123.jpg</code>
            </div>

            <form method="post" action="{{ route('admin.product.bulk-upload.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">انتخاب تصاویر (چندتایی)</label>
                            <input type="file" class="form-control mt-2" name="images[]" accept="image/*" multiple required>
                        </div>
                    </div>

                    <div class="col-12 mt-3">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-upload"></i> آپلود
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

