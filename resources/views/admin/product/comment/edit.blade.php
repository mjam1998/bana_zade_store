@extends('admin.layout.master')

@section('content')
    <div class="profile-content">
        <div class="profile-section active">
            <h3 class="section-title mb-4">
                <i class="bi bi-pencil"></i> ویرایش کامنت محصول {{$product->name}}
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

            <form action="{{ route('admin.product.comment.update', ['product' => $product, 'comment' => $comment]) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label required">نام نظر دهنده</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $comment->name) }}" required placeholder="مثلاً علی احمدی">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label required">متن نظر</label>
                        <textarea name="comment" class="form-control" rows="3" required>{{ old('comment', $comment->comment) }}</textarea>
                    </div>

                    <div class="col-md-5">
                        <label class="form-label required">وضعیت</label>
                        <select name="status" class="form-control">
                            <option value="1" {{ old('status', $comment->status->value) == 1 ? 'selected' : '' }}>تایید شده</option>
                            <option value="2" {{ old('status', $comment->status->value) == 2 ? 'selected' : '' }}>درحال بررسی</option>
                            <option value="3" {{ old('status', $comment->status->value) == 3 ? 'selected' : '' }}>تایید نشده</option>
                        </select>
                    </div>

                    <div class="col-md-5">
                        <label class="form-label required">تاریخ نظر</label>
                        <input class="form-control text-dark" name="created_at" id="persianDate" type="text"
                               value="{{ old('created_at', \Morilog\Jalali\Jalalian::fromCarbon($comment->created_at)->format('Y/n/j')) }}" required>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-12">
                        <label class="form-label">پاسخ ادمین (اختیاری)</label>
                        <textarea name="admin_response" class="form-control" rows="3" placeholder="پاسخ شما...">{{ old('admin_response', $comment->admin_response) }}</textarea>
                    </div>
                </div>

                <div class="text-end mt-3">
                    <a href="{{ route('admin.product.comment.list', $product) }}" class="btn btn-secondary">بازگشت</a>
                    <button type="submit" class="btn btn-primary">بروزرسانی کامنت</button>
                </div>
            </form>
        </div>
    </div>
@endsection

