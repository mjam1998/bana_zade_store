@extends('admin.layout.master')

@section('content')
    <div class="profile-content">
        <div class="profile-section active">
            <h3 class="section-title mb-4">
                <i class="bi bi-image"></i> تصاویر آپلود‌شده
            </h3>


        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($files->isEmpty())
            <p>تصویری یافت نشد.</p>
        @else
            <div class="row g-3">
                @foreach($files as $file)
                    <div class="col-6 col-md-3 col-lg-2 text-center position-relative">
                        <img src="{{ asset('product/' . $file) }}"
                             class="img-fluid rounded border"
                             style="height:120px;object-fit:cover;width:100%;"
                             alt="{{ $file }}">
                        <small class="d-block mt-1 text-muted text-truncate">{{ $file }}</small>

                        <form method="POST"
                              action="{{ route('admin.product.delete-image', $file) }}"
                              onsubmit="return confirm('حذف شود؟')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm mt-1 w-100">
                                <i class="fa fa-trash"></i> حذف
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>

            <div class="mt-4">
                {{ $files->links() }}
            </div>
        @endif
        </div>
    </div>
@endsection
