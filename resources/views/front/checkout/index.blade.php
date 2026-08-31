@extends('front.layout.master')
@section('title', 'تکمیل اطلاعات و ثبت سفارش')

@section('content')
    <div class="container py-5 mt-5">
        <h1 class="h3 fw-bold mb-4">تکمیل اطلاعات ارسال</h1>

        @if($errors->any())
            <div class="alert alert-danger rounded-4">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="#" method="POST">
            @csrf
            <div class="row g-4">

                {{-- فرم اطلاعات کاربر --}}
                <div class="col-lg-7">
                    <div class="card border-0 shadow-sm rounded-4 p-4">
                        <h5 class="fw-bold mb-4">مشخصات گیرنده</h5>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">نام و نام خانوادگی گیرنده <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', auth()->user()->name) }}" required>
                            </div>

                            <div class="col-md-6">
                                <label for="mobile" class="form-label">شماره موبایل <span class="text-danger">*</span></label>
                                <input type="text" name="mobile" id="mobile" class="form-control" placeholder="09xxxxxxxxx" value="{{ old('mobile', auth()->user()->mobile ?? '') }}" required>
                            </div>

                            <div class="col-md-6">
                                <label for="state" class="form-label">استان <span class="text-danger">*</span></label>
                                <input type="text" name="state" id="state" class="form-control" value="{{ old('state') }}" required>
                            </div>

                            <div class="col-md-6">
                                <label for="city" class="form-label">شهرستان <span class="text-danger">*</span></label>
                                <input type="text" name="city" id="city" class="form-control" value="{{ old('city') }}" required>
                            </div>

                            <div class="col-md-12">
                                <label for="postal_code" class="form-label">کد پستی (۱۰ رقمی) <span class="text-danger">*</span></label>
                                <input type="text" name="postal_code" id="postal_code" class="form-control" value="{{ old('postal_code') }}" required>
                            </div>

                            <div class="col-md-12">
                                <label for="address" class="form-label">آدرس دقیق پستی <span class="text-danger">*</span></label>
                                <textarea name="address" id="address" class="form-control" rows="3" required>{{ old('address') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- مرور سفارش و دکمه پرداخت --}}
                <div class="col-lg-5">
                    <div class="card border-0 shadow-sm rounded-4 p-4 sticky-top" style="top: 120px;">
                        <h5 class="fw-bold mb-4">فاکتور نهایی شما</h5>

                        @php
                            $grandOriginalTotal = 0;
                            $grandTotal = 0;
                            $totalDiscount = 0;
                        @endphp

                        <div class="mb-4" style="max-height: 300px; overflow-y: auto;">
                            @foreach($products as $product)
                                @php
                                    $qty = $cart[$product->id];
                                    $imagePath = $product->image ?? optional($product->category)->image;
                                    $imageUrl = $product->image ? asset('product/'.$imagePath) : asset('category/'.$imagePath);

                                    $basePrice = $product->base_price;
                                    $unitPrice = $product->unitPriceFor($qty);

                                    if ($unitPrice == $basePrice && $product->discount > 0) {
                                        $unitPrice = round($basePrice * (1 - $product->discount / 100));
                                    }

                                    $itemOriginalTotal = $basePrice * $qty;
                                    $itemFinalTotal = $unitPrice * $qty;
                                    $itemDiscountAmount = $itemOriginalTotal - $itemFinalTotal;

                                    $grandOriginalTotal += $itemOriginalTotal;
                                    $grandTotal += $itemFinalTotal;
                                    $totalDiscount += $itemDiscountAmount;
                                @endphp

                                <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                                    <img src="{{ $imageUrl }}" class="rounded me-3" style="width: 60px; height: 60px; object-fit: cover;" alt="{{ $product->name }}">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1 text-truncate" style="max-width: 200px;" title="{{ $product->name }}">{{ $product->name }}</h6>
                                        <div class="text-muted small">{{ $qty }} عدد</div>
                                    </div>
                                    <div class="text-end">
                                        @if($itemDiscountAmount > 0)
                                            <del class="text-muted small d-block">{{ number_format($itemOriginalTotal) }}</del>
                                        @endif
                                        <span class="fw-bold text-success">{{ number_format($itemFinalTotal) }} تومان</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted">قیمت کالاها</span>
                            <span>{{ number_format($grandOriginalTotal) }} تومان</span>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-3 text-danger">
                            <span>تخفیف کالاها</span>
                            <span>{{ number_format($totalDiscount) }} تومان</span>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <span class="fw-bold">مبلغ قابل پرداخت</span>
                            <span class="fw-bold fs-5 text-success">{{ number_format($grandTotal) }} تومان</span>
                        </div>

                        <button type="submit" class="btn btn-success w-100 rounded-pill py-3 fw-bold shadow-sm">
                            تایید نهایی و پرداخت
                        </button>
                    </div>
                </div>

            </div>
        </form>
    </div>
@endsection
