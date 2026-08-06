@extends('admin.layout.master')

@section('content')

    <div class="profile-content">
        <div class="profile-section active">
            <h3 class="section-title mb-4">
                <i class="bi bi-truck"></i>افزودن روش ارسال جدید
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

            <form action="{{ route('admin.send-method.update',['send_method'=>$sendMethod]) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label required">نام </label>
                    <input type="text" name="name" class="form-control"
                           value="{{ old('name',$sendMethod->name) }}">

                </div>

                <div class="mb-3">
                    <label class="form-label required">توضیحات </label>
                    <textarea name="description" rows="4" class="form-control">{{ old('description',$sendMethod->description) }}</textarea>

                </div>
                <button type="submit" class="btn btn-primary">ذخیره</button>
            </form>
        </div>
    </div>
@endsection

