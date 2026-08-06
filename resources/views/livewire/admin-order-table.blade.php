<div>
    {{-- جستجو و فیلتر --}}
    <div class="row mb-3 g-2">
        <div class="col-lg-6 col-md-6 col-12">
            <input type="text"
                   wire:model.defer="searchInput"
                   wire:keydown.enter="applySearch"
                   class="form-control"
                   placeholder="جستجو بر اساس کد سفارش یا موبایل یا نام سفارش دهنده...">
        </div>

        <div class="col-lg-2 col-md-6 col-12">
            <select wire:model="statusFilter"
                    wire:change="applySearch"
                    class="form-select">
                <option value="">همه وضعیت‌ها</option>
                <option value="0">منتظر ارسال</option>
                <option value="1">ارسال شده</option>
                <option value="2">کنسل شده</option>
            </select>
        </div>

        <div class="col-lg-2 col-md-6 col-12">
            <button wire:click="applySearch" class="btn btn-primary w-100">
                جستجو
            </button>
        </div>

        <div class="col-lg-2 col-md-6 col-12">
            <button wire:click="resetFilters" class="btn btn-secondary w-100">
                پاک کردن فیلتر
            </button>
        </div>
    </div>

    {{-- جدول --}}
    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead>
            <tr>
                <th class="text-center">کد</th>
                <th class="text-center">مبلغ(تومان)</th>
                <th class="text-center">وضعیت</th>
                <th class="text-center">عملیات</th>
            </tr>
            </thead>

            <tbody>
            @forelse($orders as $order)
                <tr>
                    <td class="text-center">{{ $order->code }}</td>
                    <td class="text-center">{{number_format($order->pay_amount)  }}</td>
                    <td class="text-center">
                        <span class="badge bg-{{ $order->status->color() }}">
                            {{ $order->status->label() }}
                        </span>
                    </td>
                    <td class="text-center">
                        <a href="{{route('admin.order.show',['order'=>$order->id])}}"
                           class="btn btn-primary btn-sm">
                            جزئیات
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center text-muted">
                        سفارشی یافت نشد
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    {{-- صفحه‌بندی --}}
    <div class="mt-3">
        {{ $orders->links() }}
    </div>
</div>
