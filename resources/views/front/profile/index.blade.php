@extends('front.layout.master')
@section('title', 'پروفایل کاربری')

@section('content')
    <div class="container py-5 mt-5">
        <div class="row">

            <div class="col-md-3 mb-4">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="list-group list-group-flush rounded-4">
                        <a href="{{ route('profile.index') }}" class="list-group-item list-group-item-action active py-3">ویرایش مشخصات</a>
                        <a href="{{ route('profile.orders') }}" class="list-group-item list-group-item-action py-3">سفارشات من</a>
                        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="list-group-item list-group-item-action py-3 text-danger">خروج از حساب کاربری</a>


                        <form id="logout-form" action="{{ route('profile.logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-9">
                <div class="card border-0 shadow-sm rounded-4 p-4">
                    <h4 class="mb-4">ویرایش مشخصات</h4>

                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">نام و نام خانوادگی</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">شماره موبایل (غیرقابل ویرایش)</label>
                                <input type="text" class="form-control" value="{{ $user->mobile }}" disabled>
                            </div>
                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-primary px-4">ذخیره تغییرات</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

