<div>
    {{-- جستجو --}}
    <div class="row mb-3 g-2">
        <div class="col-12 col-md-8">
            <input type="text"
                   wire:model.defer="searchInput"
                   wire:keydown.enter="applySearch"
                   class="form-control"
                   placeholder="جستجو بر اساس نام، اسلاگ ">
        </div>
        <div class="col-6 col-md-2">
            <button wire:click="applySearch" class="btn btn-primary w-100">
                جستجو
            </button>
        </div>
        <div class="col-6 col-md-2">
            <a href="{{route('admin.category.create')}}" class="btn btn-primary w-100" style="background-color: #0e9f6e;color: white;">افزودن</a>
        </div>
    </div>

    {{-- جدول --}}
    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead>
            <tr>

                <th class="text-center">نام</th>
                <th class="text-center">اسلاگ</th>
                <th class="text-center">وضعیت</th>
                <th class="text-center">عملیات</th>
            </tr>
            </thead>

            <tbody>
            @forelse($categories as $category)
                <tr>

                    <td title="{{ $category->name }}">
                        {{ \Illuminate\Support\Str::limit( $category->name, 25) }}
                    </td>
                    <td class="text-center">{{ $category->slug }}</td>
                    <td class="text-center">
                        @if($category->is_active)
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
                                    <a href="{{route('admin.category.edit',['category'=>$category])}}" class="dropdown-item" >
                                        <i class="bi bi-pencil me-2"></i> ویرایش
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('admin.category.product.index',['category'=>$category])}}" class="dropdown-item" >
                                        <i class="bi bi-box-seam"></i>  محصولات دسته بندی
                                    </a>
                                </li>
                                <li>
                                    <a href="#"
                                       class="dropdown-item {{ $category->is_active ? 'text-warning' : 'text-success' }}"
                                       onclick="toggleCategoryStatus('{{ route('admin.category.change.status', ['category' => $category]) }}', 'status-form-{{ $category->id }}'); return false;">

                                        @if($category->is_active)
                                            <i class="bi bi-toggle-off me-2"></i>
                                            غیرفعال کردن
                                        @else
                                            <i class="bi bi-toggle-on me-2"></i>
                                            فعال کردن
                                        @endif
                                    </a>

                                    <form id="status-form-{{ $category->id }}"
                                          action="{{ route('admin.category.change.status', ['category' => $category]) }}"
                                          method="POST"
                                          style="display:none;">
                                        @csrf
                                        @method('PATCH')
                                    </form>
                                </li>
                                <li>
                                    <a class="dropdown-item text-danger"
                                       href="#"
                                       onclick="cancelArticle('{{ route('admin.category.delete', ['category'=>$category]) }}', 'cancel-article-form-{{ $category->id }}')">
                                        <i class="bi bi-trash me-2"></i> حذف
                                    </a>
                                    <form id="cancel-article-form-{{ $category->id }}"
                                          action="{{ route('admin.category.delete', ['category'=>$category]) }}"
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
                        دسته بندی یافت نشد
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    {{-- صفحه‌بندی --}}
    <div class="mt-3">
        {{ $categories->links() }}
    </div>
</div>

@push('scripts')
    <script>
        function cancelArticle(url, formId) {
            Swal.fire({
                title: 'آیا مطمئن هستید؟',
                text: 'این عملیات قابل بازگشت نیست! با حذف این دسته بندی تمام محصولات مرتبط حذف خواهد شد!!',
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
        function toggleCategoryStatus(url, formId) {
            Swal.fire({
                title: 'آیا مطمئن هستید؟',
                text: ' با تغییر وضعیت این دسته بندی تمام  محصولات مرتبط تغییر وضعیت خواهد کرد!!',
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


