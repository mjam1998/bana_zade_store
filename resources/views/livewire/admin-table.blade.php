<div>
    {{-- جستجو --}}
    @php
        $roleTranslations = [
               'super-admin' => 'سوپر ادمین‌',
             'user' => 'کاربر عادی',


            'manage-category' => 'مدیریت دسته‌بندی‌ها',
            'manage-product' => 'مدیریت محصولات',
            'manage-order' => 'مدیریت سفارشات',
            'manage-blog' => 'مدیریت بلاگ',
            'manage-banner' => 'مدیریت بنر',
            'manage-extra-page' => 'مدیریت صفحات جانبی',
            'manage-payment-gateway' => 'مدیریت درگاه پرداخت',
        ];
    @endphp
    <div class="row mb-3 g-2">
        <div class="col-12 col-md-6">
            <input type="text"
                   wire:model.defer="searchInput"
                   wire:keydown.enter="applySearch"
                   class="form-control"
                   placeholder="جستجو بر اساس نام یا شماره موبایل...">
        </div>
        <div class="col-12 col-md-2">
            <select wire:model.live="selectedRole" class="form-select">
                <option value="">همه نقش‌ها</option>
                @foreach($roles as $role)
                    <option value="{{ $role->name }}"> {{ $roleTranslations[$role->name] ?? $role->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-6 col-md-2">
            <button wire:click="applySearch" class="btn btn-primary w-100">جستجو</button>
        </div>
        <div class="col-6 col-md-2">
            <a href="{{ route('admin.create') }}" class="btn btn-primary w-100" style="background-color: #0e9f6e;color: white;">افزودن</a>
        </div>
    </div>


    {{-- جدول --}}
    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead>
            <tr>

                <th class="text-center">نام</th>
                <th class="text-center">موبایل</th>
                <th class="text-center">نقش</th>
                <th class="text-center">وضعیت</th>
                <th class="text-center">عملیات</th>
            </tr>
            </thead>

            <tbody>
            @forelse($users as $user)
                <tr>


                    <td title="{{ $user->name }}">
                        {{ \Illuminate\Support\Str::limit( $user->name, 25) }}
                    </td>
                    <td class="text-center">{{ $user->mobile }}</td>
                    <td class="text-center">
                        @foreach($user->roles as $role)
                            <span class="badge bg-secondary">      {{ $roleTranslations[$role->name] ?? $role->name }}</span>
                        @endforeach
                    </td>
                    <td class="text-center">
                        @if($user->is_active)
                            <span class="badge bg-success">فعال</span>
                        @else
                            <span class="badge bg-danger">غیرفعال</span>
                        @endif
                    </td>
                    <td class="text">
                        <div class="dropdown position-static">
                            <button class="btn btn-sm btn-light" type="button" data-bs-toggle="dropdown" data-bs-boundary="viewport">
                                عملیات  <i class="bi bi-three-dots-vertical"></i>
                            </button>

                            <ul class="dropdown-menu">


                                <li>
                                    <a href="{{route('admin.edit',['user'=>$user])}}" class="dropdown-item" >
                                        <i class="bi bi-pencil me-2"></i> ویرایش
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('admin.order.user.list',['user'=>$user])}}" class="dropdown-item" >
                                        <i class="bi bi-cart me-2"></i> لیست سفارشات
                                    </a>
                                </li>
                                <li>
                                    <a href="#"
                                       class="dropdown-item {{ $user->is_active ? 'text-warning' : 'text-success' }}"
                                       onclick="toggleStatus('{{ route('admin.change.status', ['user' => $user]) }}', 'status-form-{{ $user->id }}'); return false;">

                                        @if($user->is_active)
                                            <i class="bi bi-toggle-off me-2"></i>
                                            غیرفعال کردن
                                        @else
                                            <i class="bi bi-toggle-on me-2"></i>
                                            فعال کردن
                                        @endif
                                    </a>

                                    <form id="status-form-{{ $user->id }}"
                                          action="{{ route('admin.change.status', ['user' => $user]) }}"
                                          method="POST"
                                          style="display:none;">
                                        @csrf
                                        @method('PATCH')
                                    </form>
                                </li>
                                <li>
                                    <a class="dropdown-item text-danger"
                                       href="#"
                                       onclick="cancelArticle('{{ route('admin.delete', ['user'=>$user]) }}', 'cancel-article-form-{{ $user->id }}')">
                                        <i class="bi bi-trash me-2"></i> حذف
                                    </a>
                                    <form id="cancel-article-form-{{ $user->id }}"
                                          action="{{ route('admin.delete', ['user'=>$user]) }}"
                                          method="POST"
                                          style="display:none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </li>

                            </ul>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center text-muted">
                        کاربری یافت نشد
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    {{-- صفحه‌بندی --}}
    <div class="mt-3">
        {{ $users->links() }}
    </div>
</div>

@push('scripts')
    <script>
        function cancelArticle(url, formId) {
            Swal.fire({
                title: 'آیا مطمئن هستید؟',
                text: 'این عملیات قابل بازگشت نیست! ',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'بله، حذف شود',
                cancelButtonText: 'خیر'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById(formId);
                    form.action = url;
                    form.submit();
                }
            });
        }
        function toggleStatus(url, formId) {
            Swal.fire({
                title: 'آیا مطمئن هستید؟',
                // text: ' با تغییر وضعیت این دسته بندی تمام  محصولات مرتبط تغییر وضعیت خواهد کرد!!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'بله، تغییر کند',
                cancelButtonText: 'خیر'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById(formId);
                    form.action = url;
                    form.submit();
                }
            });
        }
    </script>

@endpush



