@extends('admin.layout.master')

@section('content')
    <div class="profile-content">
        <div class="profile-section active">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="section-title mb-0">
                    <i class="bi bi-pencil-square"></i> جزئیات سفارش #{{ $order->code }}
                </h3>
                <div class="d-flex gap-2">

                    <a
                        href="{{ route('admin.order.invoice-pdf', $order->id) }}"
                        class="btn btn-danger"
                        style="padding: 10px;"
                    >
                        <i class="fas fa-file-pdf"></i> دانلود فاکتور
                    </a>
                </div>
            </div>

            <div class="card-body">
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <!-- اطلاعات سفارش -->
                        <div class="row mb-4">
                            <div class="col-lg-6 col-12 mb-3 mb-lg-0">
                                <h5 class="mb-3">اطلاعات مشتری</h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tbody>
                                        <tr>
                                            <th width="30%">نام</th>
                                            <td>{{ $order->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>موبایل</th>
                                            <td>{{ $order->mobile }}</td>
                                        </tr>
                                        <tr>
                                            <th>استان</th>
                                            <td>{{ $order->state }}</td>
                                        </tr>
                                        <tr>
                                            <th>شهر</th>
                                            <td>{{ $order->city }}</td>
                                        </tr>
                                        <tr>
                                            <th>کد پستی</th>
                                            <td>{{ $order->postal_code }}</td>
                                        </tr>
                                        <tr>
                                            <th>آدرس</th>
                                            <td>{{ $order->address }}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="col-lg-6 col-12">
                                <h5 class="mb-3">اطلاعات مالی و ارسال</h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tbody>
                                        <tr>
                                            <th width="30%">مبلغ کل</th>
                                            <td>{{ number_format($order->total_amount) }} تومان</td>
                                        </tr>
                                        <tr>
                                            <th>مبلغ پرداخت شده</th>
                                            <td>{{ number_format($order->pay_amount) }} تومان</td>
                                        </tr>
                                        <tr>
                                            <th>وضعیت پرداخت</th>
                                            <td>
                                                @if($order->is_paid)
                                                    <span class="badge bg-success">پرداخت شده</span>
                                                @else
                                                    <span class="badge bg-danger">پرداخت نشده</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @if($order->ref_id)
                                            <tr>
                                                <th> شناسه ارجاع بانک</th>
                                                <td>{{ $order->ref_id }}</td>
                                            </tr>
                                        @endif
                                        @if($order->paid_at)
                                            <tr>
                                                <th>زمان پرداخت</th>
                                                <td>{{ \Morilog\Jalali\Jalalian::fromDateTime($order->paid_at)->format('Y/m/d H:i') }}</td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <th>تاریخ ثبت سفارش</th>
                                            <td>{{ \Morilog\Jalali\Jalalian::fromDateTime($order->created_at)->format('Y/m/d H:i') }}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- آیتم‌های سفارش -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="mb-3">محصولات سفارش</h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
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

                                                    @if($item->product->has_sub_product)
                                                    <td title="{{  $item->product->name .'-'.$item->subProduct->name }}">
                                                        {{ \Illuminate\Support\Str::limit(  $item->product->name .'-'.$item->subProduct->name, 25) }}
                                                    </td>
                                                    @else
                                                    <td title="{{  $item->product->name }}">
                                                        {{ \Illuminate\Support\Str::limit(  $item->product->name , 25) }}
                                                    </td>
                                                    @endif


                                                <td class="text-nowrap">{{ number_format($item->price) }} تومان</td>
                                                <td class="text-nowrap">{{ $item->discount ? number_format($item->discount) . ' تومان' : '-' }}</td>
                                                <td>{{ $item->quantity }}</td>
                                                <td class="text-nowrap">{{ number_format(($item->price - ($item->discount ?? 0)) * $item->quantity) }} تومان</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- فرم مدیریت سفارش -->
                        <div class="row">
                            <div class="col-12">
                                <h5 class="mb-3">مدیریت سفارش</h5>
                                <form action="{{ route('admin.order.update', $order->id) }}" method="post">
                                    @csrf
                                    @method('PUT')

                                    <div class="row">
                                        <div class="col-lg-3 col-md-6 col-12">
                                            <div class="mb-3">
                                                <label for="status" class="form-label">وضعیت سفارش</label>
                                                <select name="status" id="status" class="form-control">
                                                    <option value="0">انتخاب کنید</option>
                                                    @foreach(\App\Enums\OrderStatus::cases() as $status)
                                                        <option value="{{ $status->value }}"
                                                            {{ old('status', $order->status) == $status->value }}>
                                                            {{ $status->label() }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-md-6 col-12">
                                            <div class="mb-3">
                                                <label for="send_method_id" class="form-label">روش ارسال</label>
                                                <select name="send_method_id" id="send_method_id" class="form-control">
                                                    <option value="0">انتخاب کنید</option>
                                                    @foreach($sendMethods as $method)
                                                        <option value="{{ $method->id }}"
                                                            {{ old('send_method_id', $order->send_method_id) == $method->id  }}>
                                                            {{ $method->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-md-6 col-12">
                                            <div class="mb-3">
                                                <label for="track_number" class="form-label"> کد پیگیری روش ارسال</label>
                                                <input type="text"
                                                       name="track_number"
                                                       id="track_number"
                                                       class="form-control"
                                                       value="{{ old('track_number') }}"
                                                       placeholder="کد پیگیری روش ارسال مرسوله">
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-md-6 col-12">
                                            <div class="mb-3">
                                                <label for="send_at" class="form-label">تاریخ ارسال</label>
                                                <input type="text"
                                                       name="send_at"
                                                       id="persianDate"
                                                       class="form-control"
                                                       value="{{ old('send_at') }}"
                                                       placeholder="1403/12/01">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary mb-2 mb-sm-0">
                                                <i class="fas fa-save"></i> ذخیره تغییرات
                                            </button>
                                            <a href="{{ route('admin.order.index') }}" class="btn btn-secondary">
                                                <i class="fas fa-arrow-right"></i> بازگشت
                                            </a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- نمایش وضعیت فعلی -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="alert alert-{{ $order->status->color() }}">
                                    <div class="d-flex flex-column flex-sm-row flex-wrap gap-2">
                                        <span><strong>وضعیت فعلی:</strong> {{ $order->status->label() }}</span>
                                        @if($order->send_method_id)
                                            <span class="d-none d-sm-inline">|</span>
                                            <span><strong>روش ارسال:</strong> {{ $order->sendMethod->name }}</span>
                                        @endif
                                        @if($order->track_number)
                                            <span class="d-none d-sm-inline">|</span>
                                            <span><strong>کد پیگیری روش ارسال:</strong> {{ $order->track_number }}</span>
                                        @endif
                                        @if($order->send_at)
                                            <span class="d-none d-sm-inline">|</span>
                                            <span><strong>تاریخ ارسال:</strong> {{ \Morilog\Jalali\Jalalian::fromDateTime($order->send_at)->format('Y/m/d') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

@endsection


