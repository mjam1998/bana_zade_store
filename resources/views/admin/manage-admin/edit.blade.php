@extends('admin.layout.master')

@section('content')

    <div class="profile-content">
        <div class="profile-section active">
            <h3 class="section-title mb-4">
                <i class="bi bi-pencil-square"></i>ویرایش ادمین
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
            @if(session()->has('error'))
                <p class="alert alert-danger">{{session('error')}}</p>
            @endif
            <form method="post" action="{{route('admin.update', $user->id)}}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label required">نام</label>
                            <input type="text" class="form-control mt-2" name="name" value="{{old('name', $user->name)}}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label required">موبایل</label>
                            <input type="number" class="form-control mt-2" name="mobile" value="{{old('mobile', $user->mobile)}}" required placeholder="09--------">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label ">رمز عبور جدید</label>
                            <input type="text" class="form-control mt-2" name="password" placeholder="در صورت عدم تغییر خالی بگذارید" >
                            <small class="text-muted">برای تغییر رمز عبور، رمز جدید را وارد کنید</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label ">تکرار رمز عبور جدید</label>
                            <input type="text" class="form-control mt-2" name="repassword" placeholder="در صورت عدم تغییر خالی بگذارید" >
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label required"> گیرنده پیامک</label>
                            <select class="form-select mt-2" name="type" required>
                                <option value="">انتخاب کنید..</option>
                                @foreach($userTypes as $userType)
                                    <option value="{{$userType->value}}" {{old('type', $user->type->value) == $userType->value ? 'selected' : ''}}>
                                        {{$userType->label()}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row text-center mt-3">
                    <div class="col-md-3 text-center mt-2">
                        <button type="submit" class="btn btn-primary waves-effect waves-light m-b-5"
                                style="text-align: center; display: flex; align-items: center; justify-content: center; width: 100%;">
                            ویرایش
                        </button>
                    </div>

                    <div class="col-md-3 mt-2"></div>
                </div>

            </form>
        </div>
    </div>
@endsection

