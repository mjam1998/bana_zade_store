
@extends('admin.layout.master')

@section('content')



    <div class="profile-content">
        <div class="profile-section active">
            <h3 class="section-title mb-4">
                <i class="bi bi-chat"></i>افزودن کامنت به محصول {{$product->name}}
            </h3>
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <form action="{{ route('admin.product.comment.store', $product) }}" method="POST">
    @csrf

    <div class="row g-3">
        <div class="col-md-4">
            <label class="form-label required">نام نظر دهنده</label>
            <input type="text" name="name" class="form-control" required placeholder="مثلاً علی احمدی">
        </div>
        <div class="col-md-6">
            <label class="form-label required">متن نظر</label>
            <textarea name="comment" class="form-control" rows="3" required></textarea>
        </div>
        <div class="col-md-5">
            <label class="form-label required">وضعیت</label>
            <select name="status" class="form-control">
                <option value="1">فعال</option>
                <option value="2" selected>در انتظار تایید</option>
            </select>
        </div>
        <div class=" col-md-5 ">
            <label class="form-label required"> تاریخ نظر</label>
            <input class="form-control text-dark " name="created_at" id="persianDate" type="text" required>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-12">
            <label class="form-label">پاسخ ادمین (اختیاری)</label>
            <textarea name="admin_response" class="form-control" rows="3" placeholder="پاسخ شما..."></textarea>
        </div>
    </div>
    <div class="text-end mt-3">
        <button type="submit" class="btn btn-success">افزودن کامنت</button>
    </div>
</form>
        </div>
    </div>
@endsection
