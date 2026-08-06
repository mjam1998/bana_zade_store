@extends('admin.layout.master')

@section('content')

    <div class="profile-content">
        <div class="profile-section active">
            <h3 class="section-title mb-4">
                <i class="bi bi-house"></i> داشبورد
            </h3>

            <div class="row g-3 mb-4">

                {{-- محصولات --}}
                <div class="col-6 col-md-4">
                    <div class="card border-0 shadow-sm rounded-3">
                        <div class="card-body d-flex align-items-center gap-3">
                            <div class="bg-primary bg-opacity-10 p-3 rounded-3">
                                <svg class="text-primary" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-muted small mb-0">محصولات</p>
                                <p class="fs-4 fw-black mb-0">{{ $stats['products'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- دسته‌بندی‌ها --}}
                <div class="col-6 col-md-4">
                    <div class="card border-0 shadow-sm rounded-3">
                        <div class="card-body d-flex align-items-center gap-3">
                            <div class="bg-purple bg-opacity-10 p-3 rounded-3" style="background-color: #f3e8ff;">
                                <svg style="color: #9333ea;" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-muted small mb-0">دسته‌بندی‌ها</p>
                                <p class="fs-4 fw-black mb-0">{{ $stats['categories'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- کل سفارشات --}}
                <div class="col-6 col-md-4">
                    <div class="card border-0 shadow-sm rounded-3">
                        <div class="card-body d-flex align-items-center gap-3">
                            <div class="bg-success bg-opacity-10 p-3 rounded-3">
                                <svg class="text-success" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-muted small mb-0">کل سفارشات</p>
                                <p class="fs-4 fw-black mb-0">{{ $stats['orders'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- منتظر ارسال --}}
                <div class="col-6 col-md-4">
                    <div class="card border-0 shadow-sm rounded-3">
                        <div class="card-body d-flex align-items-center gap-3">
                            <div class="bg-warning bg-opacity-10 p-3 rounded-3">
                                <svg class="text-warning" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-muted small mb-0">منتظر ارسال</p>
                                <p class="fs-4 fw-black mb-0">{{ $stats['waiting_send'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ارسال شده --}}
                <div class="col-6 col-md-4">
                    <div class="card border-0 shadow-sm rounded-3">
                        <div class="card-body d-flex align-items-center gap-3">
                            <div class="bg-info bg-opacity-10 p-3 rounded-3">
                                <svg class="text-info" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-muted small mb-0">ارسال شده</p>
                                <p class="fs-4 fw-black mb-0">{{ $stats['sent'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>



        </div>
    </div>


{{--    <style>--}}
{{--        .quick-access-card {--}}
{{--            border-radius: 12px;--}}
{{--            background: linear-gradient(135deg, #f8f9ff 0%, #ffffff 100%);--}}
{{--            border: 1px solid #e8ecff !important;--}}
{{--        }--}}

{{--        .quick-btn {--}}
{{--            border-radius: 8px;--}}
{{--            font-size: 0.85rem;--}}
{{--            padding: 7px 14px;--}}
{{--            transition: all 0.2s ease;--}}
{{--            display: inline-flex;--}}
{{--            align-items: center;--}}
{{--            white-space: nowrap;--}}
{{--        }--}}

{{--        .quick-btn:hover {--}}
{{--            transform: translateY(-2px);--}}
{{--            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);--}}
{{--        }--}}
{{--        .status-card {--}}
{{--            transition: all 0.3s ease;--}}
{{--            border-radius: 12px;--}}
{{--        }--}}

{{--        .status-card:hover {--}}
{{--            transform: translateY(-5px);--}}
{{--            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;--}}
{{--        }--}}

{{--        .total-card {--}}
{{--            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);--}}
{{--            color: white;--}}
{{--        }--}}

{{--        .total-card .text-muted {--}}
{{--            color: rgba(255, 255, 255, 0.9) !important;--}}
{{--        }--}}

{{--        .success-card {--}}
{{--            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);--}}
{{--            color: white;--}}
{{--        }--}}

{{--        .success-card .text-muted {--}}
{{--            color: rgba(255, 255, 255, 0.9) !important;--}}
{{--        }--}}

{{--        .warning-card {--}}
{{--            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);--}}
{{--            color: white;--}}
{{--        }--}}

{{--        .warning-card .text-muted {--}}
{{--            color: rgba(255, 255, 255, 0.9) !important;--}}
{{--        }--}}

{{--        .danger-card {--}}
{{--            background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);--}}
{{--            color: white;--}}
{{--        }--}}

{{--        .danger-card .text-muted {--}}
{{--            color: rgba(255, 255, 255, 0.9) !important;--}}
{{--        }--}}

{{--        .status-icon {--}}
{{--            opacity: 0.9;--}}
{{--        }--}}

{{--        .hover-card {--}}
{{--            transition: all 0.3s ease;--}}
{{--            border-radius: 8px;--}}
{{--        }--}}

{{--        .hover-card:hover {--}}
{{--            transform: translateX(-5px);--}}
{{--            box-shadow: 0 0.25rem 0.75rem rgba(0, 0, 0, 0.1) !important;--}}
{{--        }--}}

{{--        .section-title {--}}
{{--            color: #2d3748;--}}
{{--            font-weight: 600;--}}
{{--        }--}}
{{--    </style>--}}

@endsection
