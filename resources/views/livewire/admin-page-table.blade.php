<div>
    {{-- جستجو --}}
    <div class="row mb-3 g-2">
        <div class="col-12 col-md-8">
            <input type="text"
                   wire:model.defer="searchInput"
                   wire:keydown.enter="applySearch"
                   class="form-control"
                   placeholder="جستجو بر اساس عنوان یا اسلاگ...">
        </div>
        <div class="col-6 col-md-2">
            <button wire:click="applySearch" class="btn btn-primary w-100">
                جستجو
            </button>
        </div>
        <div class="col-6 col-md-2">
            <a href="{{route('admin.extra.page.create')}}" class="btn btn-primary w-100" style="background-color: #0e9f6e;color: white;">افزودن</a>
        </div>
    </div>

    {{-- جدول --}}
    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead>
            <tr>

                <th class="text-center">عنوان</th>
                <th class="text-center">اسلاگ</th>
                <th class="text-center">وضعیت</th>
                <th class="text-center">عملیات</th>
            </tr>
            </thead>

            <tbody>
            @forelse($pages as $page)
                <tr>

                    <td title="{{ $page->title }}">
                        {{ \Illuminate\Support\Str::limit( $page->title, 25) }}
                    </td>
                    <td class="text-center">{{ $page->slug }}</td>
                    <td class="text-center">
                        @if($page->is_active)
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
                                    <a href="{{route('admin.extra.page.edit',['page'=>$page])}}" class="dropdown-item" >
                                        <i class="bi bi-pencil me-2"></i> ویرایش
                                    </a>
                                </li>
                                <li>
                                    <a href="#"
                                       class="dropdown-item {{ $page->is_active ? 'text-warning' : 'text-success' }}"
                                       onclick="toggleStatus('{{ route('admin.extra.page.change.status', ['page' => $page]) }}', 'status-form-{{ $page->id }}'); return false;">

                                        @if($page->is_active)
                                            <i class="bi bi-toggle-off me-2"></i>
                                            غیرفعال کردن
                                        @else
                                            <i class="bi bi-toggle-on me-2"></i>
                                            فعال کردن
                                        @endif
                                    </a>

                                    <form id="status-form-{{ $page->id }}"
                                          action="{{ route('admin.extra.page.change.status', ['page' => $page]) }}"
                                          method="POST"
                                          style="display:none;">
                                        @csrf
                                        @method('PATCH')
                                    </form>
                                </li>
                                <li>
                                    <a class="dropdown-item text-danger"
                                       href="#"
                                       onclick="cancelArticle('{{ route('admin.extra.page.delete', ['page'=>$page]) }}', 'cancel-article-form-{{ $page->id }}')">
                                        <i class="bi bi-trash me-2"></i> حذف
                                    </a>
                                    <form id="cancel-article-form-{{ $page->id }}"
                                          action="{{ route('admin.extra.page.delete', ['page'=>$page]) }}"
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
                        صفحه ای یافت نشد
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    {{-- صفحه‌بندی --}}
    <div class="mt-3">
        {{ $pages->links() }}
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



