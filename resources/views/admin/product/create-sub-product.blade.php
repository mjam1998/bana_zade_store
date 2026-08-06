@extends('admin.layout.master')

@section('content')
    <div class="profile-content">
        <div class="profile-section active">
            <h3 class="section-title mb-4">
                <i class="bi bi-box-seam"></i> افرودن زیر محصول
            </h3>
            <form action="{{ route('admin.subproduct.store',['product'=>$product]) }}" method="POST">
                @csrf


                <div class="mb-3">
                    <label class="required">نام</label>
                    <input type="text" name="name" class="form-control "
                           value="{{ old('name') }}" required>
                </div>
                <div class="mb-3">
                    <label class="required">قیمت</label>
                    <input type="number" name="price" class="form-control "
                           value="{{ old('price') }}" required>
                </div>

                <div class="mb-3">
                    <label>میزان تخفیف</label>
                    <input type="number" name="discount" class="form-control"
                           value="{{ old('discount') }}">
                </div>

                <button class="btn btn-primary">ذخیره</button>
            </form>
        </div>
    </div>
@endsection



