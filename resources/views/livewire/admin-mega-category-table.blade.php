<div>
    {{-- جستجو --}}
    <div class="row mb-3 g-2">
        <div class="col-12 col-md-8">
            <input type="text"
                   wire:model.defer="searchInput"
                   wire:keydown.enter="applySearch"
                   class="form-control"
                   placeholder="جستجو بر اساس نام">
        </div>
        <div class="col-6 col-md-2">
            <button wire:click="applySearch" class="btn btn-primary w-100">
                جستجو
            </button>
        </div>
        <div class="col-6 col-md-2">
            <a href="{{route('admin.mega-category.create')}}" class="btn btn-primary w-100" style="background-color: #0e9f6e;color: white;">افزودن</a>
        </div>
    </div>

    {{-- جدول --}}
    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead>
            <tr>

                <th class="text-center">نام</th>

                <th class="text-center">عملیات</th>
            </tr>
            </thead>

            <tbody>
            @forelse($megaCategories as $megaCategory)
                <tr>

                    <td title="{{ $megaCategory->name }}">
                        {{ \Illuminate\Support\Str::limit( $megaCategory->name, 25) }}
                    </td>

                    <td class="text">
                        <div class="dropdown position-static">
                            <button class="btn btn-sm btn-light" type="button" data-bs-toggle="dropdown" data-bs-boundary="viewport">
                                عملیات  <i class="bi bi-three-dots-vertical"></i>
                            </button>

                            <ul class="dropdown-menu">


                                <li>
                                    <a href="{{route('admin.mega-category.edit',['mega_category'=>$megaCategory])}}" class="dropdown-item" >
                                        <i class="bi bi-pencil me-2"></i> ویرایش
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('admin.super-category.index',['mega_category'=>$megaCategory])}}" class="dropdown-item" >
                                        <i class="bi bi-list-ul"></i>  دسته بندی های زیر شاخه
                                    </a>
                                </li>

                                <li>
                                    <a class="dropdown-item text-danger"
                                       href="#"
                                       onclick="cancelArticle('{{ route('admin.mega-category.delete', ['mega_category'=>$megaCategory]) }}', 'cancel-article-form-{{ $megaCategory->id }}')">
                                        <i class="bi bi-trash me-2"></i> حذف
                                    </a>
                                    <form id="cancel-article-form-{{ $megaCategory->id }}"
                                          action="{{ route('admin.mega-category.delete', ['mega_category'=>$megaCategory]) }}"
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
        {{ $megaCategories->links() }}
    </div>
</div>

@push('scripts')
    <script>
        function cancelArticle(url, formId) {
            Swal.fire({
                title: 'آیا مطمئن هستید؟',
                text: 'این عملیات قابل بازگشت نیست! با حذف این دسته بندی تمام دسته بندی های زیر شاخه و محصولات مرتبط حذف خواهد شد!!',
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
    </script>

@endpush
