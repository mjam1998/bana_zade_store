@extends('admin.layout.master')

@section('content')
    <div class="profile-content">
        <div class="profile-section active">
            <h3 class="section-title mb-4">
                <i class="bi bi-box-seam"></i> ویرایش زیر محصول {{$subproduct->name}}
            </h3>
    <form action="{{ route('admin.subproduct.update',$subproduct->id) }}" method="POST">
        @csrf
        @method('PUT')




        <div class="mb-3">
            <label class="required">نام</label>
            <input type="text" name="name" class="form-control "
                   value="{{ old('name',$subproduct->name) }}" required>
        </div>
        <div class="mb-3">
            <label class="required">کد</label>
            <input type="text" name="code" class="form-control "
                   value="{{ old('code',$subproduct->code) }}" required>
        </div>
        <div class="mb-3">
            <label class="required">قیمت</label>
            <input type="number" name="price" class="form-control "
                   value="{{ old('price',$subproduct->price) }}" required>
        </div>

        <div class="mb-3">
            <label>میزان تخفیف</label>
            <input type="number" name="discount" class="form-control"
                   value="{{ old('discount',$subproduct->discount) }}">
        </div>

        <button class="btn btn-primary">ذخیره</button>
    </form>
        </div>
    </div>
@endsection


