@extends('admin.layout.master')

@section('content')

    <div class="profile-content">
        <div class="profile-section active">
            <h3 class="section-title mb-4">
                <i class="bi bi-people"></i>لیست ادمین ها
            </h3>
            @if(session()->has('success'))
                <p class="alert alert-success">{{session('success')}}</p>
            @endif
            @if(session()->has('error'))
                <p class="alert alert-danger">{{session('error')}}</p>
            @endif
            <livewire:admin-table />

        </div>
    </div>
@endsection




