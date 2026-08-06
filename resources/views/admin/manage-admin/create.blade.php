@extends('admin.layout.master')

@section('content')

    <div class="profile-content">
        <div class="profile-section active">
            <h3 class="section-title mb-4">
                <i class="bi bi-people"></i>افزودن ادمین
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
            <form method="post" action="{{route('admin.store')}}" enctype="multipart/form-data" >
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label  class="control-label required" >نام </label>
                            <input type="text" class="form-control mt-2" name="name"  required >

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label  class="control-label required" >موبایل </label>
                            <input type="number" class="form-control mt-2" name="mobile"  required placeholder="09--------" >

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label  class="control-label required" >رمز عبور </label>
                            <input type="text" class="form-control mt-2" name="password"  required  >

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label  class="control-label required" >تکرار رمز عبور </label>
                            <input type="text" class="form-control mt-2" name="repassword"  required >

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label  class="control-label required" >گیرنده پیامک </label>
                            <select  class="form-select mt-2" name="type">
                                <option value="">انتخاب کنید..</option>
                                @foreach($userTypes as $userType)
                                    <option value="{{$userType->value}}">{{$userType->label()}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>


                </div>





                <div class="row text-center mt-3">
                    <div class="col-md-3  text-center mt-2"> <button type="submit" class="btn btn-success waves-effect waves-light m-b-5 "
                                                                     style=" text-align: center;
                              display: flex;
                              align-items: center;
                              justify-content: center;
                              width: 100%;" >افزودن</button></div>

                    <div class="col-md-3 mt-2"></div>
                    <div class="col-md-3 mt-2"></div>
                </div>



            </form>
        </div>
    </div>
@endsection

