@extends('admin.layout.master')

@section('content')
    <div class="profile-content">
        <div class="profile-section active">
            <h3 class="section-title mb-4">
                <i class="bi bi-layout-text-sidebar"></i> ویرایش صفحه
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

            @if(session()->has('success'))
                <p class="alert alert-success">{{session('success')}}</p>
            @endif

            <form method="post" action="{{route('admin.extra.page.update', $page->id)}}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label required">عنوان صفحه</label>
                            <input type="text" class="form-control mt-2" name="title"
                                   value="{{old('title', $page->title)}}" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label required">اسلاگ</label>
                            <input type="text" class="form-control mt-2" name="slug"
                                   value="{{old('slug', $page->slug)}}" placeholder="آدرس بلاگ در سایت" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">عنوان متا صفحه (title)</label>
                            <input type="text" class="form-control mt-2" name="meta_title"
                                   value="{{old('meta_title', $page->meta_title)}}" maxlength="400">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">توضیحات متا (meta description)</label>
                            <input type="text" class="form-control mt-2" name="meta_description"
                                   value="{{old('meta_description', $page->meta_description)}}" maxlength="400">
                        </div>
                    </div>




                    <div class="col-12">
                        <div class="form-group">
                            <label class="form-label mt-3 required">متن صفحه</label>
                            @include('partial.editor',['value'=>$page->description ?? ''])
                        </div>
                    </div>
                </div>

                <div class="row text-center mt-4">
                    <div class="col-md-3 text-center mt-2">
                        <button type="submit" class="btn btn-primary waves-effect waves-light m-b-5"
                                style="text-align: center; display: flex; align-items: center; justify-content: center; width: 100%;">
                            بروزرسانی
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection


