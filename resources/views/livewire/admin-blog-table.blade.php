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
            <a href="{{route('admin.blog.create')}}" class="btn btn-primary w-100" style="background-color: #0e9f6e;color: white;">افزودن</a>
        </div>
    </div>

    {{-- جدول --}}
    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead>
            <tr>

                <th class="text-center">عنوان</th>
                <th class="text-center">اسلاگ</th>
                <th class="text-center">عملیات</th>
            </tr>
            </thead>

            <tbody>
            @forelse($blogs as $blog)
                <tr>

                    <td title="{{ $blog->title }}">
                        {{ \Illuminate\Support\Str::limit( $blog->title, 25) }}
                    </td>
                    <td class="text-center">{{ $blog->slug }}</td>
                    <td class="text">
                        <div class="dropdown position-static">
                            <button class="btn btn-sm btn-light" type="button" data-bs-toggle="dropdown" data-bs-boundary="viewport">
                                عملیات  <i class="bi bi-three-dots-vertical"></i>
                            </button>

                            <ul class="dropdown-menu">


                                <li>
                                    <a href="{{route('admin.blog.edit',['blog'=>$blog])}}" class="dropdown-item" >
                                        <i class="bi bi-pencil me-2"></i> ویرایش
                                    </a>
                                </li>

                                <li>
                                    <a class="dropdown-item text-danger"
                                       href="#"
                                       onclick="cancelArticle('{{ route('admin.blog.delete', ['blog'=>$blog]) }}', 'cancel-article-form-{{ $blog->id }}')">
                                        <i class="bi bi-trash me-2"></i> حذف
                                    </a>
                                    <form id="cancel-article-form-{{ $blog->id }}"
                                          action="{{ route('admin.blog.delete', ['blog'=>$blog]) }}"
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
                         بلاگی یافت نشد
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    {{-- صفحه‌بندی --}}
    <div class="mt-3">
        {{ $blogs->links() }}
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
    </script>

@endpush


