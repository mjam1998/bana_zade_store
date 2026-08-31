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
            {{-- بخش نمودار فروش --}}
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card border-0 shadow-sm rounded-3">
                        <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fw-bold">
                                <i class="bi bi-graph-up-arrow text-primary me-2"></i> گزارش مبالغ فروش
                            </h5>
                            <select id="chartFilter" class="form-select form-select-sm w-auto shadow-none">
                                <option value="monthly" selected>ماهانه (سال جاری)</option>
                                <option value="daily">روزانه (۳۰ روز اخیر)</option>
                                <option value="yearly">سالانه (۵ سال اخیر)</option>
                            </select>
                        </div>
                        <div class="card-body">
                            {{-- بوم نمودار --}}
                            <canvas id="salesChart" height="100"></canvas>
                        </div>
                    </div>
                </div>
            </div>



        </div>
    </div>




@endsection
@push('scripts')

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            // دریافت داده‌های پاس داده شده از PHP به صورت JSON
            const rawData = {
                daily: @json($dailySales),
                monthly: @json($monthlySales),
                yearly: @json($yearlySales)
            };

            const ctx = document.getElementById('salesChart').getContext('2d');
            let salesChart;

            // تنظیم فونت فارسی برای نمودار
            Chart.defaults.font.family = 'Vazirmatn, Tahoma, Arial';

            function renderChart(type) {
                const dataObj = rawData[type];
                const labels = Object.keys(dataObj);
                const values = Object.values(dataObj);

                if (salesChart) {
                    salesChart.destroy(); // پاک کردن نمودار قبلی
                }

                salesChart = new Chart(ctx, {
                    type: 'line', // می‌توانید به 'bar' تغییر دهید تا نمودار ستونی شود
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'مبلغ فروش (تومان)',
                            data: values,
                            borderColor: '#4e73df',
                            backgroundColor: 'rgba(78, 115, 223, 0.1)',
                            borderWidth: 2,
                            pointBackgroundColor: '#4e73df',
                            pointBorderColor: '#fff',
                            pointHoverBackgroundColor: '#fff',
                            pointHoverBorderColor: '#4e73df',
                            fill: true,
                            tension: 0.3 // انحنای خط نمودار
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        // فرمت کردن عدد با کاما
                                        let label = context.dataset.label || '';
                                        if (label) { label += ': '; }
                                        if (context.parsed.y !== null) {
                                            label += new Intl.NumberFormat('fa-IR').format(context.parsed.y) + ' تومان';
                                        }
                                        return label;
                                    }
                                },
                                titleFont: { family: 'Vazirmatn' },
                                bodyFont: { family: 'Vazirmatn' }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        // نمایش اعداد محور Y به صورت مخفف (مثلا 1M) یا با کاما
                                        if (value >= 1000000) {
                                            return new Intl.NumberFormat('fa-IR').format(value / 1000000) + ' میلیون';
                                        }
                                        return new Intl.NumberFormat('fa-IR').format(value);
                                    }
                                }
                            }
                        }
                    }
                });
            }

            // رندر اولیه (حالت ماهانه)
            renderChart('monthly');

            // تغییر نمودار با تغییر سلکت باکس
            document.getElementById('chartFilter').addEventListener('change', function(e) {
                renderChart(e.target.value);
            });
        });
    </script>
@endpush
