@extends('front.layout.master')

@section('meta_title', $product->meta_title ?? $product->name . ' | آقای صفر تا صد')
@section('meta_description', $product->meta_description ?? Str::limit(strip_tags($product->description), 160))
@section('meta_keywords', $product->keywords ?? '')
@section('og_type', 'product')
@section('og_image', $product->image ? asset('/product/' . $product->image) : asset('/category/' . $product->category->image))

@push('canonical')
    <link rel="canonical" href="{{ route('product.detail', $product->slug) }}">
@endpush


@section('content')
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">

            {{-- بازگشت به دسته‌بندی --}}
            <div class="mb-6">
                <a href="{{ route('category', $product->category->slug) }}"
                   class="inline-flex items-center text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 transition-colors">
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    بازگشت به {{ $product->category->name }}
                </a>
            </div>
            @if($errors->any())
                <div class="relative mb-6 bg-red-500/10 dark:bg-red-500/20 backdrop-blur-xl p-5 rounded-3xl border border-red-500/30 dark:border-red-500/40 shadow-xl animate-shake">
                    <div class="flex items-start gap-4">
                        <!-- Icon -->
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 rounded-full bg-red-500/20 dark:bg-red-500/30 flex items-center justify-center">
                                <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="flex-1">
                            <h3 class="text-sm font-black text-red-700 dark:text-red-400 mb-2">خطا در اطلاعات وارد شده</h3>
                            <ul class="space-y-1">
                                @foreach($errors->all() as $error)
                                    <li class="text-xs text-red-600 dark:text-red-300 flex items-start gap-2">
                                        <span class="text-red-500 mt-0.5">•</span>
                                        <span>{{ $error }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <!-- Close Button -->
                        <button onclick="this.parentElement.parentElement.remove()"
                                class="flex-shrink-0 text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-200 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>
            @endif
            @if(session('success'))
                <div class="relative mb-6 bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/30 dark:to-emerald-900/30 backdrop-blur-xl p-5 rounded-2xl border border-green-200 dark:border-green-700 shadow-lg">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-green-500 to-emerald-600 flex items-center justify-center shadow-lg">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-base font-bold text-green-800 dark:text-green-300 mb-1">عملیات موفق</h3>
                            <p class="text-sm text-green-700 dark:text-green-400">
                                {{ session('success') }}
                            </p>
                        </div>
                        <button onclick="this.parentElement.parentElement.remove()"
                                class="flex-shrink-0 text-green-600 dark:text-green-400 hover:text-green-800 dark:hover:text-green-200 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>
            @endif


            {{-- اطلاعات اصلی محصول --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden mb-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 p-8">

                    {{-- تصویر محصول --}}
                    <div class="space-y-4">
                        <div class="aspect-square rounded-xl overflow-hidden bg-gray-100 dark:bg-gray-700">
                            @if($product->image)
                                <img src="{{ asset('product/' . $product->image) }}"
                                     alt="{{ $product->image_alt }}"
                                     title="{{ $product->image_title }}"
                                     class="w-full h-full object-cover">
                            @else
                                <img src="{{ asset('category/' . $product->category->image) }}"
                                     alt="{{ $product->category->image_alt }}"
                                     title="{{ $product->category->image_title }}"
                                     class="w-full h-full object-cover">
                            @endif
                        </div>
                    </div>

                    {{-- اطلاعات محصول --}}
                    <div class="space-y-6">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                                {{ $product->name }}
                            </h1>
                            <p class="text-gray-600 dark:text-gray-400">
                                دسته‌بندی:
                                <a href="{{ route('category', $product->category->slug) }}"
                                   class="text-blue-600 dark:text-blue-400 hover:underline">
                                    {{ $product->category->name ?? 'بدون دسته‌بندی' }}
                                </a>
                            </p>
                            <p class="text-gray-600 dark:text-gray-400">
                                کد محصول:{{$product->code}}

                            </p>
                            @if($product->size)
                                <p class="text-gray-600 dark:text-gray-400">
                                    سایز:{{$product->size}}

                                </p>
                            @endif

                        </div>

                        {{-- انتخاب نوع محصول (اگر sub-product داشته باشد) --}}
                        @if($product->has_sub_product && $product->subProducts->count() > 0)
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">انتخاب نوع محصول:</label>
                                <div class="relative">
                                    <select id="subProductSelect" class="w-full px-4 py-3 pr-12 rounded-xl bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 text-gray-900 dark:text-white focus:border-blue-500 dark:focus:border-blue-400 focus:ring-2 focus:ring-blue-500/20 outline-none transition-all appearance-none cursor-pointer">

                                        @foreach($product->subProducts as $subProduct)
                                            <option value="{{ $subProduct->id }}"
                                                    data-price="{{ $subProduct->price }}"
                                                    data-discount="{{ $subProduct->discount }}"
                                                    data-size="{{ $subProduct->size ?? '' }}">
                                                {{ $subProduct->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400 dark:text-gray-500">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        @endif



                        {{-- قیمت --}}
                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-xl p-6" id="priceContainer">
                            @if($discountPercentage > 0)
                                <div class="flex items-center gap-3 mb-2">
                                    <span class="text-2xl font-bold text-gray-900 dark:text-white" id="finalPrice">
                                        {{ number_format($finalPrice) }} تومان
                                    </span>
                                    <span class="bg-red-500 text-white text-sm font-bold px-3 py-1 rounded-full" id="discountBadge">
                                        {{ $discountPercentage }}% تخفیف
                                    </span>
                                </div>
                                <div class="text-gray-500 dark:text-gray-400 line-through" id="originalPrice">
                                    {{ number_format($originalPrice) }} تومان
                                </div>
                            @else
                                <div class="text-2xl font-bold text-gray-900 dark:text-white" id="finalPrice">
                                    {{ number_format($finalPrice) }} تومان
                                </div>
                            @endif
                        </div>

                        {{-- کلمات کلیدی --}}
                        @if(!empty($keywords) && is_array($keywords))
                            <div>
                                <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">برچسب‌ها:</h3>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($keywords as $keyword)
                                        <span class="px-3 py-1.5 bg-gradient-to-r from-purple-100 to-pink-100 dark:from-purple-900/30 dark:to-pink-900/30 text-purple-700 dark:text-purple-300 rounded-full text-sm font-medium border border-purple-200 dark:border-purple-500/30">
                                            {{ $keyword }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- انتخاب تعداد و افزودن به سبد خرید --}}
                        <div class="space-y-4">
                            {{-- انتخاب تعداد --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">تعداد:</label>
                                <div class="flex items-center gap-3">
                                    <button type="button" id="decreaseQty" class="w-12 h-12 flex items-center justify-center bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                        </svg>
                                    </button>

                                    <input type="number"
                                           id="quantity"
                                           value="1"
                                           min="1"

                                           class="w-20 h-12 text-center text-lg font-bold bg-gray-50 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 text-gray-900 dark:text-white rounded-lg focus:border-blue-500 dark:focus:border-blue-400 focus:ring-2 focus:ring-blue-500/20 outline-none transition-all">

                                    <button type="button" id="increaseQty" class="w-12 h-12 flex items-center justify-center bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            {{-- دکمه افزودن به سبد خرید --}}
                            <button id="addToCartBtn" class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold py-4 px-6 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg flex items-center justify-center gap-2">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                افزودن به سبد خرید
                            </button>
                        </div>

                    </div>
                </div>
            </div>

            {{-- توضیحات محصول --}}
            @if($product->description)
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8 mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">توضیحات محصول</h2>
                    <div class="prose prose-lg dark:prose-invert max-w-none product-content">
                        {!! $product->description !!}
                    </div>
                </div>
            @endif

            {{-- بخش نظرات --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">
                    نظرات کاربران
                    <span class="text-lg text-gray-500 dark:text-gray-400 font-normal">
                        ({{ $approvedComments->total() }} نظر)
                    </span>
                </h2>

                {{-- لیست نظرات --}}
                @if($approvedComments->count() > 0)
                    <div class="space-y-6 mb-8">
                        @foreach($approvedComments as $comment)
                            <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-6 border border-gray-200 dark:border-gray-600">
                                <div class="flex items-start justify-between mb-3">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full flex items-center justify-center text-white font-bold">
                                            {{ mb_substr($comment->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <h4 class="font-semibold text-gray-900 dark:text-white">{{ $comment->name }}</h4>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                                {{ \Morilog\Jalali\Jalalian::fromDateTime($comment->created_at)->format('d F Y') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                                    {{ $comment->comment }}
                                </p>
                                {{-- پاسخ ادمین (اگر وجود داشته باشد) --}}
                                @if($comment->admin_response)
                                    <div class="mt-4 mr-8 bg-gradient-to-r from-amber-50 to-orange-50 dark:from-amber-900/20 dark:to-orange-900/20 rounded-lg p-4 border-r-4 border-amber-500 dark:border-amber-600">
                                        <div class="flex items-start gap-3">
                                            <div class="flex-shrink-0">
                                                <div class="w-8 h-8 bg-gradient-to-br from-amber-500 to-orange-600 rounded-full flex items-center justify-center">
                                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="flex-1">
                                                <h5 class="text-sm font-bold text-amber-900 dark:text-amber-300 mb-2">پاسخ مدیریت:</h5>
                                                <p class="text-sm text-amber-800 dark:text-amber-200 leading-relaxed">
                                                    {{ $comment->admin_response }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    @if($approvedComments->hasPages())
                        <div class="flex justify-center mt-8">
                            {{ $approvedComments->links() }}
                        </div>
                    @endif
                @else
                    <div class="text-center py-8 mb-8">
                        <svg class="w-16 h-16 mx-auto text-gray-400 dark:text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                        <p class="text-gray-500 dark:text-gray-400">هنوز نظری ثبت نشده است. اولین نفر باشید!</p>
                    </div>
                @endif

                {{-- فرم ثبت نظر --}}
                <div class="border-t border-gray-200 dark:border-gray-700 pt-8">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6">نظر خود را بنویسید</h3>

                    <form action="{{ route('product.comment.store', $product->slug) }}" method="POST" class="space-y-6">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- نام --}}
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    نام <span class="text-red-500">*</span>
                                </label>
                                <input type="text"
                                       id="name"
                                       name="name"
                                       value="{{ old('name') }}"
                                       class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent transition-all @error('name') border-red-500 @enderror"
                                       placeholder="نام خود را وارد کنید"
                                required>
                                @error('name')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>


                        </div>

                        {{-- متن نظر --}}
                        <div>
                            <label for="comment" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                نظر شما <span class="text-red-500">*</span>
                            </label>
                            <textarea id="comment"
                                      name="comment"
                                      rows="5"
                                      required
                                      class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent transition-all resize-none @error('comment') border-red-500 @enderror"
                                      placeholder="نظر خود را در مورد این محصول بنویسید... (حداقل 10 کاراکتر)">{{ old('comment') }}</textarea>
                            @error('comment')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- دکمه ارسال --}}
                        <div>
                            <button type="submit"
                                    class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold py-3 px-8 rounded-lg transition-all duration-300 transform hover:scale-105 shadow-lg">
                                ارسال نظر
                            </button>
                            <p class="mt-3 text-sm text-gray-500 dark:text-gray-400">
                                نظر شما پس از تایید مدیر نمایش داده خواهد شد.
                            </p>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

    {{-- استایل‌های دارک مود برای محتوای HTML --}}
    <style>
        .product-content {
            color: #374151;
        }

        .dark .product-content {
            color: #e5e7eb !important;
        }

        .product-content p {
            margin-bottom: 1.5rem;
            line-height: 1.8;
            color: #374151;
        }

        .dark .product-content p {
            color: #e5e7eb !important;
        }

        .product-content span {
            color: inherit !important;
        }

        .dark .product-content span {
            color: #e5e7eb !important;
        }

        .product-content strong {
            font-weight: 700;
            color: #111827;
        }

        .dark .product-content strong {
            color: #f3f4f6 !important;
        }

        .product-content div {
            color: #374151;
        }

        .dark .product-content div {
            color: #e5e7eb !important;
        }

        .product-content img {
            max-width: 100%;
            height: auto;
            border-radius: 0.75rem;
            margin: 2rem auto;
            display: block;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        .dark .product-content img {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3);
        }

        .product-content table {
            width: 100%;
            border-collapse: collapse;
            margin: 2rem 0;
            background: white;
            border-radius: 0.75rem;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .dark .product-content table {
            background: #1f2937;
        }

        .product-content th,
        .product-content td {
            padding: 1rem;
            text-align: right;
            border-bottom: 1px solid #e5e7eb;
            color: #374151;
        }

        .dark .product-content th,
        .dark .product-content td {
            border-bottom-color: #374151;
            color: #e5e7eb !important;
        }

        .product-content th {
            background: #f9fafb;
            font-weight: 700;
            color: #111827;
        }

        .dark .product-content th {
            background: #111827;
            color: #f3f4f6 !important;
        }

        .product-content ul,
        .product-content ol {
            margin: 1.5rem 0;
            padding-right: 2rem;
        }

        .product-content li {
            margin-bottom: 0.75rem;
            line-height: 1.8;
            color: #374151;
        }

        .dark .product-content li {
            color: #e5e7eb !important;
        }

        .product-content a {
            color: #2563eb;
            text-decoration: underline;
        }

        .dark .product-content a {
            color: #60a5fa !important;
        }

        .product-content h1,
        .product-content h2,
        .product-content h3,
        .product-content h4,
        .product-content h5,
        .product-content h6 {
            font-weight: 700;
            margin-top: 2rem;
            margin-bottom: 1rem;
            color: #111827;
        }

        .dark .product-content h1,
        .dark .product-content h2,
        .dark .product-content h3,
        .dark .product-content h4,
        .dark .product-content h5,
        .dark .product-content h6 {
            color: #f3f4f6 !important;
        }
    </style>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const subProductSelect = document.getElementById('subProductSelect');
            const sizeContainer = document.getElementById('sizeContainer');
            const sizeValue = document.getElementById('sizeValue');

            if(subProductSelect) {
                subProductSelect.addEventListener('change', function() {
                    const selectedOption = this.options[this.selectedIndex];
                    const price = parseFloat(selectedOption.dataset.price);
                    const discount = parseFloat(selectedOption.dataset.discount);
                    const size = selectedOption.dataset.size;

                    let finalPrice = price;
                    let discountPercent = 0;

                    if(discount > 0) {
                        finalPrice = price - discount;
                        discountPercent = Math.round((discount / price) * 100);
                    }

                    const priceContainer = document.getElementById('priceContainer');

                    if(discount > 0) {
                        priceContainer.innerHTML = `
                            <div class="flex items-center gap-3 mb-2">
                                <span class="text-2xl font-bold text-gray-900 dark:text-white">
                                    ${finalPrice.toLocaleString()} تومان
                                </span>
                                <span class="bg-red-500 text-white text-sm font-bold px-3 py-1 rounded-full">
                                    ${discountPercent}% تخفیف
                                </span>
                            </div>
                            <div class="text-gray-500 dark:text-gray-400 line-through">
                                ${price.toLocaleString()} تومان
                            </div>
                        `;
                    } else {
                        priceContainer.innerHTML = `
                            <div class="text-2xl font-bold text-gray-900 dark:text-white">
                                ${price.toLocaleString()} تومان
                            </div>
                        `;
                    }

                    if(sizeContainer && sizeValue) {
                        sizeValue.textContent = size ? size : 'نامشخص';
                    }
                });
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            // دریافت المان‌های مورد نیاز
            const quantityInput = document.getElementById('quantity');
            const increaseQtyBtn = document.getElementById('increaseQty');
            const decreaseQtyBtn = document.getElementById('decreaseQty');
            const addToCartBtn = document.getElementById('addToCartBtn');
            const subProductSelect = document.getElementById('subProductSelect');
            const sizeContainer = document.getElementById('sizeContainer');
            const sizeValue = document.getElementById('sizeValue');

            // مدیریت افزایش تعداد
            if (increaseQtyBtn) {
                increaseQtyBtn.addEventListener('click', function() {
                    let currentValue = parseInt(quantityInput.value);
                    if (currentValue < 99) {
                        quantityInput.value = currentValue + 1;
                    }
                });
            }

            // مدیریت کاهش تعداد
            if (decreaseQtyBtn) {
                decreaseQtyBtn.addEventListener('click', function() {
                    let currentValue = parseInt(quantityInput.value);

                        quantityInput.value = currentValue - 1;

                });
            }

            // محدود کردن ورودی دستی
            if (quantityInput) {
                quantityInput.addEventListener('input', function() {
                    let value = parseInt(this.value);
                    if (isNaN(value) || value < 1) {
                        this.value = 1;
                    }
                });
            }

            // تغییر قیمت با انتخاب sub-product
            if(subProductSelect) {
                subProductSelect.addEventListener('change', function() {
                    const selectedOption = this.options[this.selectedIndex];
                    const price = parseFloat(selectedOption.dataset.price);
                    const discount = parseFloat(selectedOption.dataset.discount);
                    const size = selectedOption.dataset.size;

                    let finalPrice = price;
                    let discountPercent = 0;

                    if(discount > 0) {
                        finalPrice = price - discount;
                        discountPercent = Math.round((discount / price) * 100);
                    }

                    const priceContainer = document.getElementById('priceContainer');

                    if(discount > 0) {
                        priceContainer.innerHTML = `
                    <div class="flex items-center gap-3 mb-2">
                        <span class="text-2xl font-bold text-gray-900 dark:text-white">
                            ${finalPrice.toLocaleString()} تومان
                        </span>
                        <span class="bg-red-500 text-white text-sm font-bold px-3 py-1 rounded-full">
                            ${discountPercent}% تخفیف
                        </span>
                    </div>
                    <div class="text-gray-500 dark:text-gray-400 line-through">
                        ${price.toLocaleString()} تومان
                    </div>
                `;
                    } else {
                        priceContainer.innerHTML = `
                    <div class="text-2xl font-bold text-gray-900 dark:text-white">
                        ${price.toLocaleString()} تومان
                    </div>
                `;
                    }

                    if(sizeContainer && sizeValue) {
                        sizeValue.textContent = size ? size : 'نامشخص';
                    }
                });
            }

            // افزودن به سبد خرید با AJAX
            if (addToCartBtn) {
                addToCartBtn.addEventListener('click', function() {
                    const quantity = parseInt(quantityInput.value);
                    const selectedOption = subProductSelect ? subProductSelect.value : 'default';

                    const productId = {{ $product->id }};
                    const subProductId = selectedOption !== 'default' ? selectedOption : null;

                    // نمایش لودینگ
                    addToCartBtn.disabled = true;
                    addToCartBtn.innerHTML = `
                <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                در حال افزودن...
            `;

                    fetch('{{ route("cart.add") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            product_id: productId,
                            sub_product_id: subProductId,
                            quantity: quantity
                        })
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'success') {
                                showNotification('success', data.message);

                                // به‌روزرسانی شمارنده سبد خرید
                                const cartCounts = document.querySelectorAll('.cart-badge');

                                cartCounts.forEach(cartCount => {
                                    cartCount.textContent = data.cart_count;

                                    cartCount.classList.add('animate-bounce');

                                    setTimeout(() => {
                                        cartCount.classList.remove('animate-bounce');
                                    }, 1000);
                                });

                                // ریست کردن تعداد به 1
                                quantityInput.value = 1;
                                if (window.innerWidth < 1024) {
                                    refreshMobileCartDrawer(true);
                                }
                            } else {
                                showNotification('error', 'خطا در افزودن به سبد خرید');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showNotification('error', 'خطا در ارتباط با سرور');
                        })
                        .finally(() => {
                            // بازگرداندن دکمه به حالت اولیه
                            addToCartBtn.disabled = false;
                            addToCartBtn.innerHTML = `
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    افزودن به سبد خرید
                `;
                        });
                });
            }

            // تابع نمایش نوتیفیکیشن
            function showNotification(type, message) {
                const notification = document.createElement('div');
                notification.className = `fixed top-4 left-1/2 transform -translate-x-1/2 -translate-y-20 z-50 px-6 py-4 rounded-lg shadow-2xl transition-all duration-500 flex items-center gap-3 ${
                    type === 'success'
                        ? 'bg-emerald-600 text-white border-2 border-emerald-400'
                        : 'bg-rose-600 text-white border-2 border-rose-400'
                }`;

                // آیکون
                const icon = type === 'success'
                    ? '<svg class="w-6 h-6 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>'
                    : '<svg class="w-6 h-6 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>';

                notification.innerHTML = `${icon}<span class="font-semibold text-lg">${message}</span>`;

                document.body.appendChild(notification);

                // انیمیشن ورود
                setTimeout(() => {
                    notification.style.transform = 'translate(-50%, 0)';
                }, 10);

                // انیمیشن خروج
                setTimeout(() => {
                    notification.style.transform = 'translate(-50%, -20px)';
                    notification.style.opacity = '0';
                    setTimeout(() => notification.remove(), 500);
                }, 3000);
            }


        });


    </script>
@endpush
