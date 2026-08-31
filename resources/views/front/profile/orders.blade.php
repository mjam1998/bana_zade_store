@extends('front.layout.master')


@section('content')
    <div class="container py-5 mt-5" >
        <div class="row" >
            <div class="col-md-3 mb-4" >
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="list-group list-group-flush rounded-4">
                        <a href="{{ route('profile.index') }}" class="list-group-item list-group-item-action py-3">ویرایش مشخصات</a>
                        <a href="{{ route('profile.orders') }}" class="list-group-item list-group-item-action active py-3">سفارشات من</a>
                        <a href="#" class="list-group-item list-group-item-action py-3 text-danger">خروج از حساب کاربری</a>
                    </div>
                </div>
            </div>

            <div class="col-md-9">
                <h4 class="mb-4">تاریخچه سفارشات من</h4>
                <livewire:user-order-table/>
            </div>
        </div>
    </div>
@endsection

