@extends('front.layout.master')


@push('styles')
    <style>
        /*
         * استایل‌های محافظتی برای محتوای تولید شده توسط CKEditor
         */
        .dynamic-content {
            font-size: 1rem;
            line-height: 2;
            text-align: justify;
            color: #333;
        }

        /* ریسپانسیو کردن تمام عکس‌های داخل محتوا */
        .dynamic-content img {
            max-width: 100% !important;
            height: auto !important;
            border-radius: 8px;
            margin: 15px 0;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05); /* یک سایه ملایم برای زیبایی */
        }

        /* جلوگیری از بیرون زدن جداول و افزودن اسکرول افقی */
        .dynamic-content table {
            width: 100% !important;
            max-width: 100%;
            margin-bottom: 1rem;
            background-color: transparent;
            border-collapse: collapse;
        }

        .dynamic-content-table-wrapper {
            overflow-x: auto;
        }

        /* ریسپانسیو کردن iframe ها (مثل ویدیوهای آپارات) */
        .dynamic-content iframe {
            max-width: 100%;
            border-radius: 8px;
        }

        /* استایل‌دهی به نقل‌قول‌ها (Blockquote) */
        .dynamic-content blockquote {
            border-right: 4px solid #0d6efd; /* رنگ primary بوت‌استرپ */
            padding: 10px 20px;
            margin: 20px 0;
            background: #f8f9fa;
            border-radius: 4px;
            color: #555;
        }
        .dynamic-content img {
            max-width: 100% !important; /* در موبایل اجازه نمیدهد از کادر بیرون بزند */
            height: auto !important;    /* تناسب طول و عرض را حفظ میکند */
            border-radius: 8px;
            margin: 15px 0;
        }


    </style>
@endpush

@section('content')
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-9">

                {{-- کارت اصلی نمایش محتوا --}}
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body p-4 p-md-5">

                        {{-- عنوان صفحه --}}
                        <h1 class="h2 mb-4 text-primary fw-bold">
                            {{ $page->title }}
                        </h1>

                        <hr class="mb-4 text-muted">

                        {{--
                            محتوای داینامیک
                            توجه: استفاده از {!! !!} ضروری است تا کدهای HTML رندر شوند
                        --}}
                        <div class="dynamic-content">
                            {!! $page->description !!}
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            // فقط افزودن کلاس ریسپانسیو، بدون پاک کردن ابعاد دستی شما
            const images = document.querySelectorAll('.dynamic-content img');
            images.forEach(img => {
                img.classList.add('img-fluid');
            });

            // ریسپانسیو کردن جداول (بدون تغییر)
            const tables = document.querySelectorAll('.dynamic-content table');
            tables.forEach(table => {
                const wrapper = document.createElement('div');
                wrapper.className = 'table-responsive';
                table.parentNode.insertBefore(wrapper, table);
                wrapper.appendChild(table);
                table.classList.add('table');
            });

        });
    </script>
@endpush

