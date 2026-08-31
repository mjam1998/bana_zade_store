@extends('front.layout.master')
@section('title', 'جزئیات سفارش')

@section('content')
    <div class="container py-5 mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="h4 mb-0">جزئیات سفارش #{{ $order->code }}</h3>
            <div class="d-flex gap-2">
                <a href="{{ route('profile.orders') }}" class="btn btn-secondary">بازگشت به سفارشات</a>

            </div>
        </div>

        <!-- اطلاعات سفارش -->
        <div class="row mb-4 g-4">
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm rounded-4 h-100 p-3">
                    <h5 class="mb-3 text-primary">اطلاعات ارسال</h5>
                    <table class="table table-borderless table-sm mb-0">
                        <tbody>
                        <tr><th width="30%" class="text-muted">تحویل گیرنده:</th><td>{{ $order->name }}</td></tr>
                        <tr><th class="text-muted">موبایل:</th><td>{{ $order->mobile }}</td></tr>
                        <tr><th class="text-muted">آدرس:</th><td>{{ $order->state }}، {{ $order->city }}، {{ $order->address }}</td></tr>
                        <tr><th class="text-muted">کد پستی:</th><td>{{ $order->postal_code }}</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card border-0 shadow-sm rounded-4 h-100 p-3">
                    <h5 class="mb-3 text-primary">اطلاعات مالی</h5>
                    <table class="table table-borderless table-sm mb-0">
                        <tbody>
                        <tr><th width="30%" class="text-muted">مبلغ کل:</th><td>{{ number_format($order->total_amount) }} تومان</td></tr>
                        <tr><th class="text-muted">مبلغ پرداختی:</th><td><span class="fw-bold text-success">{{ number_format($order->pay_amount) }} تومان</span></td></tr>
                        <tr>
                            <th class="text-muted">وضعیت پرداخت:</th>
                            <td>
                                @if($order->is_paid)
                                    <span class="badge bg-success">پرداخت شده</span>
                                @else
                                    <span class="badge bg-danger">پرداخت نشده</span>
                                @endif
                            </td>
                        </tr>
                        @if($order->ref_id)
                            <tr><th class="text-muted">شناسه بانک:</th><td>{{ $order->ref_id }}</td></tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- وضعیت فعلی و پیگیری -->
        <div class="card border-0 shadow-sm rounded-4 mb-4 border-end border-5 border-{{ $order->status->color() }}">
            <div class="card-body p-4">
                <h5 class="mb-3">وضعیت و پیگیری سفارش</h5>
                <div class="d-flex flex-column flex-sm-row flex-wrap gap-4">
                    <div><strong class="text-muted d-block mb-1">وضعیت فعلی</strong> <span class="badge bg-{{ $order->status->color() }}">{{ $order->status->label() }}</span></div>



                    @if($order->send_at)
                        <div><strong class="text-muted d-block mb-1">تاریخ ارسال</strong> <span>{{ \Morilog\Jalali\Jalalian::fromDateTime($order->send_at)->format('Y/m/d') }}</span></div>
                    @endif
                </div>

                @if($order->description)
                    <hr>
                    <strong class="text-muted d-block mb-2">توضیحات مدیریت برای شما:</strong>
                    <p class="mb-0 bg-light p-3 rounded-3 text-dark">{{ $order->description }}</p>
                @endif
            </div>
        </div>

        <!-- آیتم‌های سفارش -->
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <h5 class="mb-3">محصولات سفارش</h5>
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead class="table-light">
                        <tr>
                            <th>ردیف</th>
                            <th>نام محصول</th>
                            <th>قیمت واحد</th>
                            <th>تخفیف</th>
                            <th>تعداد</th>
                            <th>قیمت نهایی</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($order->orderItems as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td title="{{ $item->product->name }}">{{ \Illuminate\Support\Str::limit($item->product->name, 40) }}</td>
                                <td>{{ number_format($item->price) }} تومان</td>
                                <td>{{ $item->discount ? number_format($item->discount) . ' تومان' : '-' }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td class="fw-bold">{{ number_format(($item->price - ($item->discount ?? 0)) * $item->quantity) }} تومان</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

