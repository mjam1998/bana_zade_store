@extends('admin.layout.master')

@section('content')

    <div class="profile-content">
        <div class="profile-section active">
            <h3 class="section-title mb-4">
                <i class="bi bi-list-ul"></i>افزودن دسته بندی {{$megaCategory->name}}
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
            <form method="post" action="{{route('admin.super-category.store')}}" enctype="multipart/form-data" >
                @csrf
                <input type="hidden" name="mega_category_id" value="{{$megaCategory->id}}">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label  class="control-label required" >نام دسته بندی</label>
                            <input type="text" class="form-control mt-2" name="name"  required >

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

