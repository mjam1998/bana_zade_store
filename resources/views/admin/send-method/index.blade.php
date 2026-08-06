@extends('admin.layout.master')

@section('content')

    <div class="profile-content">
        <div class="profile-section active">
            <h3 class="section-title mb-4">
                <i class="bi bi-truck"></i> لیست روش های ارسال
            </h3>
            @if(session()->has('success'))
                <p class="alert alert-success">{{session('success')}}</p>
            @endif
            <livewire:admin-send-method-table/>

        </div>
    </div>
@endsection


