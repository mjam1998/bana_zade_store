<div>
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">
            <div class="row g-3">
                <div class="col-md-5">
                    <input type="text" wire:model.defer="searchInput" class="form-control" placeholder="جستجوی کد سفارش...">
                </div>
                <div class="col-md-4">
                    <select wire:model.defer="statusFilter" class="form-select">
                        <option value="">همه وضعیت‌ها</option>
                        @foreach(\App\Enums\OrderStatus::cases() as $status)
                            <option value="{{ $status->value }}">{{ $status->label() }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 d-flex gap-2">
                    <button wire:click="applySearch" class="btn btn-primary w-100">جستجو</button>
                    <button wire:click="resetFilters" class="btn btn-secondary w-50" title="پاک کردن فیلترها"><i class="bi bi-x-circle"></i></button>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                    <tr class="text-center">
                        <th class="px-4 py-3">کد سفارش</th>
                        <th>مبلغ کل</th>
                        <th>وضعیت</th>
                        <th>تاریخ ثبت</th>
                        <th >عملیات</th>
                    </tr>
                    </thead>
                    <tbody >
                    @forelse($orders as $order)
                        <tr class="text-center">
                            <td class="px-4 fw-bold text-muted">#{{ $order->code }}</td>
                            <td>{{ number_format($order->pay_amount) }} تومان</td>
                            <td>
                                    <span class="badge bg-{{ $order->status->color() }}">
                                        {{ $order->status->label() }}
                                    </span>
                            </td>
                            <td>{{ \Morilog\Jalali\Jalalian::fromDateTime($order->created_at)->format('Y/m/d H:i') }}</td>
                            <td >
                                <a href="{{ route('profile.orders.show', $order->id) }}" class="btn btn-sm btn-outline-info rounded-pill">
                                    جزئیات
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">هیچ سفارشی یافت نشد.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white border-0 py-3">
            {{ $orders->links() }}
        </div>
    </div>
</div>

