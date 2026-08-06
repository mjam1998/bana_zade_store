@extends('admin.layout.master')

@section('content')

    <div class="profile-content">
        <div class="profile-section active">
            <h3 class="section-title mb-4">
                <i class="bi bi-list-ul"></i> لیست دسته بندی های {{$superCategory->name}} زیر شاخه سوم
            </h3>
            @if(session()->has('success'))
                <p class="alert alert-success">{{session('success')}}</p>
            @endif
            <livewire:admin-category-table :superCategoryId="$superCategory->id"/>

        </div>
    </div>
@endsection


