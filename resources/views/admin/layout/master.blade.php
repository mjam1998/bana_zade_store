<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{asset('front/assets/images/logo.png')}}">
    <link rel="icon" type="image/png" href="{{asset('front/assets/images/logo.pn')}}">

    <!-- برای دستگاه‌های اپل -->
    <link rel="apple-touch-icon" href="{{asset('front/assets/images/logo.pn')}}">
    <title>پنل کاربری </title>
    <!-- Bootstrap RTL CSS -->
    <link href="{{asset('bootstrap/bootstrap.rtl.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('bootstrap/bootstrap-icons.css')}}">

    <link href="{{ asset('admin/css/app.css') }}" rel="stylesheet">
    <link href="{{asset('admin/choises/choices.min.css')}}" rel="stylesheet" />
    <link href="{{asset('bootstrap/tagify.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('admin/css/persianDatepicker-default.css')}}"/>


    @livewireStyles

</head>
<body>

<!-- Overlay -->
<div class="overlay"></div>

<!-- Sidebar -->
<div class="sidebar" id="side1" >
    <div class="sidebar-header" >
        <div style="font-size: xxx-large; margin-left: 15px" ><i class="bi bi-person-circle"></i></div>
        <div class="user-info">
            <div class="user-name mt-3"><p style="font-size: small"></p></div>
            {{auth()->user()->name}}
            <div  class="user-status" style="font-size: medium;color: blue">
               ادمین



            </div>
        </div>
    </div>

    <div class="nav-menu">
        <ul>
            <li><a href="{{route('admin.index')}}"  ><i class="bi bi-house"></i> داشبورد</a></li>
            <li><a href="{{route('admin.list')}}"  ><i class="bi bi-people"></i> ادمین ها</a></li>
            <li><a href="{{route('admin.mega-category.index')}}"  ><i class="bi bi-list-ul"></i> دسته بندی ها</a></li>

            <li class="has-submenu" >
                <a href="javascript:void(0)" class="menu-toggle">
                    <i class="bi bi-box-seam"></i> محصولات</a>
                <ul class="submenu">

                    <li><a href="{{route('admin.product.create')}}" style="font-size: small"><i class="bi bi-pencil-square"></i> افزودن محصول</a></li>
                    <li><a href="{{route('admin.product.excel.create')}}" style="font-size: small"><i class="bi bi-pencil-square"></i> افزودن لیستی محصولات ثابت</a></li>
                    <li><a href="{{route('admin.product.excel.create-sub-product')}}" style="font-size: small"><i class="bi bi-pencil-square"></i> افزودن لیستی محصولات متغیر</a></li>
                    <li><a href="{{route('admin.product.index')}}" style="font-size: small"><i class="bi bi-pencil-square"></i> لیست محصولات</a></li>
                    <li><a href="{{route('admin.product.bulk-upload')}}" style="font-size: small"><i class="bi bi-pencil-square"></i> آپلود گروهی عکس محصولات</a></li>
                    <li><a href="{{route('admin.product.uploaded-images')}}" style="font-size: small"><i class="bi bi-pencil-square"></i>  عکس های آپلود شده</a></li>

                </ul>
            </li>
            <li><a href="{{route('admin.order.index')}}"  ><i class="bi bi-cart"></i> سفارشات</a></li>
            <li><a href="{{route('admin.blog.index')}}"  ><i class="bi bi-layout-text-sidebar"></i> بلاگ</a></li>
            <li><a href="{{route('admin.send-method.index')}}"  ><i class="bi bi-truck"></i> روش ارسال</a></li>
            <li><a href="{{route('admin.banners.index')}}"  ><i class="bi bi-image"></i> بنرها</a></li>
            <li><a href="{{route('admin.extra.page.index')}}"  ><i class="bi bi-window-stack"></i> صفحات اضافه</a></li>
            <li><a href="{{route('admin.payment-gateway')}}"  ><i class="bi bi-bank"></i>  درگاه بانکی</a></li>




        </ul>
    </div>

    <div class="sidebar-footer">
        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-danger" aria-label="خروج از حساب">
            <i class="bi bi-escape"></i> خروج از حساب کاربری
        </a>

        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
</div>

<!-- Main Content -->
<div class="main">







    <!-- Content Area -->


    @yield('content')





    <!-- Mobile Bottom Nav -->
    <div class="mobile-bottom-nav">
        <div class="nav-item active " id="nav-home" >
            <div class="p-1" >
                <a href="#"  onclick="openSidebarAndLoad('dashboard.html')"><i class="bi bi-list" style="font-size:30px;color: black"></i></a>
            </div>

        </div>
        <div class="nav-item" id="nav-profile">
            <div class="p-1" >
                <a href="{{route('admin.index')}}" ><i class="bi bi-house" style="font-size: 30px;color: black"></i></a>
            </div>
        </div>



        <div class="nav-item" id="nav-profile">
            <div class="p-1" >
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" ><i class="bi bi-escape" style="font-size:30px;color: black"></i></a>
            </div>
        </div>

    </div>
    <!-- Bootstrap JS -->
    <script src="{{asset('admin/select2/jquery-3.6.0.min.js')}}"></script>
    <script src="{{asset('bootstrap/bootstrap.bundle.min.js')}}"></script>

    <script src="{{asset('admin/choises/choices.min.js')}}"></script>
    <script src="{{asset('admin/list/list.js')}}"></script>
    <script src="{{asset('admin/sweetalert/sweetalert.js')}}"></script>
    <script src="{{asset('bootstrap/tagify.js')}}"></script>

    <script src="{{asset('admin/js/persianDatepicker.min.js')}}"></script>
    @livewireScripts
    <script>



        // باز کردن سایدبار + لود صفحه
        function openSidebarAndLoad(page) {
            document.querySelector('.sidebar').classList.add('active');
            document.querySelector('.overlay').classList.add('active');
            // loadPage(page);
            updateActiveNavItem('nav-home');
        }

        // لود صفحه + بستن سایدبار
        function loadAndClose(page) {
            document.querySelector('.sidebar').classList.remove('active');
            document.querySelector('.overlay').classList.remove('active');
            // loadPage(page);
            const map = { 'wishlist.html': 'nav-wishlist', 'new-ad.html': 'nav-add-ad', 'messages.html': 'nav-messages', 'profile.html': 'nav-profile' };
            updateActiveNavItem(map[page]);
        }

        // بروزرسانی active در نوار پایین
        function updateActiveNavItem(id) {
            document.querySelectorAll('.nav-item').forEach(el => el.classList.remove('active'));
            const active = document.getElementById(id);
            if (active) active.classList.add('active');
        }

        // بستن سایدبار با کلیک روی overlay
        document.querySelector('.overlay').addEventListener('click', () => {
            document.querySelector('.sidebar').classList.remove('active');
            document.querySelector('.overlay').classList.remove('active');
        });
        function copyText() {
            var text = document.getElementById('userUrl').innerText;
            navigator.clipboard.writeText(text);
            alert('کپی شد!');
            return false;
        }

        // Toggle submenu
        document.addEventListener('DOMContentLoaded', function() {
            const menuToggles = document.querySelectorAll('.menu-toggle');

            menuToggles.forEach(toggle => {
                toggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    const parentLi = this.closest('.has-submenu');
                    const wasActive = parentLi.classList.contains('active');

                    // بستن همه submenuها
                    document.querySelectorAll('.has-submenu').forEach(item => {
                        item.classList.remove('active');
                    });

                    // اگر قبلاً باز نبود، بازش کن
                    if (!wasActive) {
                        parentLi.classList.add('active');
                    }
                });
            });

            // بستن submenu با کلیک خارج از آن
            document.addEventListener('click', function(e) {
                if (!e.target.closest('.has-submenu')) {
                    document.querySelectorAll('.has-submenu').forEach(item => {
                        item.classList.remove('active');
                    });
                }
            });
        });

    </script>
    <script>

        document.addEventListener('DOMContentLoaded', function () {
            const textareas = document.querySelectorAll('.auto-resize');

            textareas.forEach(textarea => {
                const resize = () => {
                    textarea.style.height = 'auto';
                    textarea.style.height = textarea.scrollHeight + 'px';
                };

                textarea.addEventListener('input', resize);

                // برای زمانی که old('summary') مقدار دارد
                resize();
            });
        });

    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#persianDate').persianDatepicker({
                format: 'YYYY/MM/DD',
                autoClose: true,
                observer: true,

                position: 'auto',
                toolbox: {
                    calendarSwitch: { enabled: false }
                },
                altField: '#hiddenDate', // اختیاری
                navigator: {
                    enabled: true
                },
                // مهم‌ترین بخش:
                initialValue: false,
                calendar: {
                    persian: {
                        leapYearMode: 'astronomical'
                    }
                },
                // موقعیت تقویم
                placement: 'bottom' // یا 'top' یا 'auto'
            });
        });
    </script>
    @stack('scripts')

</div>
</body>
</html>
