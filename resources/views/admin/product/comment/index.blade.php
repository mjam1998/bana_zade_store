@extends('admin.layout.master')

@section('content')

    <div class="profile-content">
        <div class="profile-section active">
            <h3 class="section-title mb-4">
                <i class="bi bi-chat"></i> لیست کامنت های {{$product->name}}
            </h3>
            @if(session()->has('success'))
                <p class="alert alert-success">{{session('success')}}</p>
            @endif
            <livewire:admin-product-comment-table :productId="$product->id"/>

        </div>
    </div>
@endsection

